<img src="{{ file_exists(public_path('image/landing/logo.png')) ? asset('image/landing/logo.png') : asset('storage/image/landing/logo.png') }}"
     alt="Logo LP3I"
     {{ $attributes->merge(['class' => 'h-16 w-auto object-contain']) }}>
