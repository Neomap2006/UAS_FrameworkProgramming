/**
 * Instant Navigation & Page Transition Engine
 * Provides instant, SPA-like navigation, link prefetching,
 * smooth top loading bar, and seamless Alpine.js rehydration.
 */

class InstantNav {
    constructor() {
        this.cache = new Map();
        this.cacheDuration = 60 * 1000; // 60 seconds
        this.progressBar = null;
        this.progressInterval = null;
        this.currentProgress = 0;
        this.isNavigating = false;

        this.init();
    }

    init() {
        if (typeof window === 'undefined') return;

        this.createProgressBar();
        this.bindEvents();
    }

    createProgressBar() {
        if (document.getElementById('instant-progress-bar')) {
            this.progressBar = document.getElementById('instant-progress-bar');
            return;
        }

        const bar = document.createElement('div');
        bar.id = 'instant-progress-bar';
        bar.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6 0%, #6366f1 50%, #06b6d4 100%);
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.8), 0 0 5px rgba(99, 102, 241, 0.6);
            z-index: 999999;
            opacity: 0;
            transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.2s ease;
            pointer-events: none;
        `;
        document.body.appendChild(bar);
        this.progressBar = bar;
    }

    startProgress() {
        if (!this.progressBar) return;
        clearInterval(this.progressInterval);
        this.currentProgress = 15;
        this.progressBar.style.opacity = '1';
        this.progressBar.style.width = '15%';

        this.progressInterval = setInterval(() => {
            if (this.currentProgress < 75) {
                this.currentProgress += Math.random() * 15;
                this.progressBar.style.width = `${Math.min(this.currentProgress, 75)}%`;
            } else if (this.currentProgress < 90) {
                this.currentProgress += Math.random() * 3;
                this.progressBar.style.width = `${Math.min(this.currentProgress, 90)}%`;
            }
        }, 120);
    }

    finishProgress() {
        if (!this.progressBar) return;
        clearInterval(this.progressInterval);
        this.currentProgress = 100;
        this.progressBar.style.width = '100%';

        setTimeout(() => {
            this.progressBar.style.opacity = '0';
            setTimeout(() => {
                this.progressBar.style.width = '0%';
                this.currentProgress = 0;
            }, 250);
        }, 180);
    }

    isValidLink(link, e) {
        if (!link || !link.href) return false;
        if (e && (e.ctrlKey || e.metaKey || e.shiftKey || e.altKey || e.button !== 0)) return false;

        // Skip non-HTTP(S)
        if (!link.href.startsWith('http://') && !link.href.startsWith('https://')) return false;

        // Origin check
        if (link.origin !== window.location.origin) return false;

        // Target check
        if (link.target && link.target !== '_self') return false;

        // Ignore download links or explicitly excluded links
        if (link.hasAttribute('download') || link.hasAttribute('data-no-instant')) return false;

        // Ignore anchor hash on same page
        const currentUrlNoHash = window.location.href.split('#')[0];
        const targetUrlNoHash = link.href.split('#')[0];
        if (currentUrlNoHash === targetUrlNoHash && link.hash) return false;

        // Ignore logout forms or links inside forms
        if (link.closest('form')) return false;

        return true;
    }

    async prefetch(url) {
        if (this.cache.has(url)) {
            const cached = this.cache.get(url);
            if (Date.now() - cached.timestamp < this.cacheDuration) {
                return cached.html;
            }
            this.cache.delete(url);
        }

        try {
            const res = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html, application/xhtml+xml',
                },
            });
            if (res.ok) {
                const html = await res.text();
                this.cache.set(url, { html, timestamp: Date.now() });
                return html;
            }
        } catch (_) {
            // Silently ignore prefetch errors
        }
        return null;
    }

    async navigate(url, pushState = true) {
        if (this.isNavigating) return;

        // If navigating to the exact current URL without hash, just scroll top
        if (url === window.location.href) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }

        this.isNavigating = true;
        this.startProgress();

        try {
            let html = null;
            if (this.cache.has(url)) {
                const cached = this.cache.get(url);
                if (Date.now() - cached.timestamp < this.cacheDuration) {
                    html = cached.html;
                }
            }

            if (!html) {
                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html, application/xhtml+xml',
                    },
                });

                if (!response.ok) {
                    window.location.href = url;
                    return;
                }

                html = await response.text();
                this.cache.set(url, { html, timestamp: Date.now() });
            }

            this.applyPageTransition(html, url, pushState);
        } catch (error) {
            console.error('Instant navigation fallback:', error);
            window.location.href = url;
        } finally {
            this.finishProgress();
            this.isNavigating = false;
        }
    }

    applyPageTransition(html, url, pushState) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        // 1. Update Title
        if (doc.title) {
            document.title = doc.title;
        }

        // 2. Update Main Content
        const newMain = doc.querySelector('main');
        const currentMain = document.querySelector('main');

        if (newMain && currentMain) {
            currentMain.innerHTML = newMain.innerHTML;

            // Re-initialize Alpine on the new main content
            if (window.Alpine) {
                window.Alpine.initTree(currentMain);
            }
        } else {
            // Fallback if layout structure is different
            window.location.href = url;
            return;
        }

        // 3. Update Sidebar Active State
        const newAside = doc.querySelector('aside');
        const currentAside = document.querySelector('aside');
        if (newAside && currentAside) {
            currentAside.innerHTML = newAside.innerHTML;
            if (window.Alpine) {
                window.Alpine.initTree(currentAside);
            }
        }

        // 4. Update History
        if (pushState) {
            window.history.pushState({ url }, '', url);
        }

        // 5. Scroll to top
        window.scrollTo({ top: 0, behavior: 'instant' });

        // Dispatch custom event for any listeners
        window.dispatchEvent(new CustomEvent('instant:navigated', { detail: { url } }));
    }

    bindEvents() {
        // Link click interception
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a');
            if (this.isValidLink(link, e)) {
                e.preventDefault();
                this.navigate(link.href, true);
            }
        });

        // Link hover prefetch (instant responsiveness on click)
        let hoverTimeout = null;
        document.addEventListener('pointerenter', (e) => {
            const link = e.target.closest('a');
            if (this.isValidLink(link, null)) {
                hoverTimeout = setTimeout(() => {
                    this.prefetch(link.href);
                }, 50);
            }
        }, true);

        document.addEventListener('pointerleave', (e) => {
            if (hoverTimeout) {
                clearTimeout(hoverTimeout);
                hoverTimeout = null;
            }
        }, true);

        // Handle browser Back / Forward buttons
        window.addEventListener('popstate', () => {
            this.navigate(window.location.href, false);
        });

        // Invalidate cache on form submits (so fresh data is shown after store/update/delete)
        document.addEventListener('submit', () => {
            this.cache.clear();
        });
    }
}

// Auto-initialize when DOM is ready
if (typeof window !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => new InstantNav());
    } else {
        new InstantNav();
    }
}

export default InstantNav;
