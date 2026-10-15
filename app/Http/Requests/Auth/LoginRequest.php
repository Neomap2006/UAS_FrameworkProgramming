<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare inputs before validation.
     */
    protected function prepareForValidation(): void
    {
        $loginValue = $this->input('login') ?? $this->input('email');

        if ($loginValue !== null) {
            $this->merge([
                'login' => trim($loginValue),
                'email' => trim($loginValue),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $login = $this->input('login') ?? $this->input('email');
        $password = $this->input('password');
        $remember = $this->boolean('remember');

        $isEmail = filter_var($login, FILTER_VALIDATE_EMAIL);
        $attempted = false;

        if ($isEmail) {
            $attempted = Auth::attempt(['email' => $login, 'password' => $password], $remember);
        } else {
            $attempted = Auth::attempt(['username' => $login, 'password' => $password], $remember);
            if (! $attempted) {
                $attempted = Auth::attempt(['name' => $login, 'password' => $password], $remember);
            }
        }

        // Direct user query fallback for case-insensitive or name match
        if (! $attempted) {
            $user = User::where('email', $login)
                ->orWhere('username', $login)
                ->orWhere('name', $login)
                ->first();

            if ($user && Hash::check($password, $user->password)) {
                Auth::login($user, $remember);
                $attempted = true;
            }
        }

        if (! $attempted) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => trans('auth.failed'),
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        $login = $this->input('login') ?? $this->input('email');
        return Str::transliterate(Str::lower($login).'|'.$this->ip());
    }
}
