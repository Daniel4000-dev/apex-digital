/**
 * Agency Site Main Vanilla JavaScript: Confident Editorial Studio Interactions
 *
 * Handles:
 * - Progressive JS Detection
 * - Page Scroll Progress Indicator
 * - Interactive Poster Study Switcher (Keyboard accessible tabs)
 * - Bounded Pointer Parallax for Poster Artboard
 * - Restrained Scroll Reveals
 * - Responsive Mobile Drawer Navigation
 * - Sticky Header Scroll States
 * - FAQ Accordion Disclosures
 * - Copy Article Link to Clipboard
 * - Back to Top Smooth Scroll
 * - AJAX Contact Form Submission
 */

document.addEventListener('DOMContentLoaded', () => {
    initJsDetection();
    initScrollProgress();
    initPosterStudies();
    initPosterParallax();
    initScrollReveal();
    initMobileMenu();
    initStickyHeader();
    initFaqAccordion();
    initCopyLink();
    initBackToTop();
    initContactForm();
});

/**
 * Mark Document as JavaScript-Enabled
 */
function initJsDetection() {
    document.documentElement.classList.remove('no-js');
    document.documentElement.classList.add('js-enabled');
}

/**
 * Top Page Scroll Progress Indicator
 */
function initScrollProgress() {
    const progressBar = document.getElementById('page-scroll-progress');
    if (!progressBar) return;

    let ticking = false;

    function updateProgress() {
        const scrollTop = window.scrollY || document.documentElement.scrollTop;
        const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const progress = docHeight > 0 ? Math.min(100, Math.max(0, (scrollTop / docHeight) * 100)) : 0;
        progressBar.style.width = progress + '%';
        ticking = false;
    }

    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(updateProgress);
            ticking = true;
        }
    }, { passive: true });

    updateProgress();
}

/**
 * Interactive Poster Study Switcher (Accessible Tabs)
 */
function initPosterStudies() {
    const tabs = Array.from(document.querySelectorAll('.poster-tab-btn'));
    if (!tabs.length) return;

    const panels = {
        '1': document.getElementById('study-panel-1'),
        '2': document.getElementById('study-panel-2'),
        '3': document.getElementById('study-panel-3')
    };

    function activateStudy(studyId, focusTab = false) {
        tabs.forEach(tab => {
            const isMatch = tab.getAttribute('data-study') === studyId;
            tab.setAttribute('aria-selected', isMatch ? 'true' : 'false');
            tab.setAttribute('tabindex', isMatch ? '0' : '-1');

            // Reset base styles
            tab.className = 'poster-tab-btn px-2.5 py-1 text-xs font-bold transition-colors';

            if (isMatch) {
                if (studyId === '1') {
                    tab.classList.add('bg-coral', 'text-white');
                } else if (studyId === '2') {
                    tab.classList.add('bg-cobalt', 'text-white');
                } else if (studyId === '3') {
                    tab.classList.add('bg-lime', 'text-ink');
                }
                if (focusTab) {
                    tab.focus();
                }
            } else {
                tab.classList.add('bg-ivory', 'text-ink', 'hover:bg-ink/10');
            }
        });

        // Toggle study panels with smooth crossfade
        Object.keys(panels).forEach(id => {
            const panel = panels[id];
            if (!panel) return;
            if (id === studyId) {
                panel.classList.remove('opacity-0', 'pointer-events-none', 'z-0');
                panel.classList.add('opacity-100', 'pointer-events-auto', 'z-10');
            } else {
                panel.classList.remove('opacity-100', 'pointer-events-auto', 'z-10');
                panel.classList.add('opacity-0', 'pointer-events-none', 'z-0');
            }
        });
    }

    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => {
            const studyId = tab.getAttribute('data-study');
            activateStudy(studyId);
        });

        // Keyboard Arrow Navigation
        tab.addEventListener('keydown', (e) => {
            let targetIndex = -1;
            if (e.key === 'ArrowRight') {
                targetIndex = (index + 1) % tabs.length;
            } else if (e.key === 'ArrowLeft') {
                targetIndex = (index - 1 + tabs.length) % tabs.length;
            } else if (e.key === 'Home') {
                targetIndex = 0;
            } else if (e.key === 'End') {
                targetIndex = tabs.length - 1;
            }

            if (targetIndex !== -1) {
                e.preventDefault();
                const nextStudyId = tabs[targetIndex].getAttribute('data-study');
                activateStudy(nextStudyId, true);
            }
        });
    });
}

/**
 * Bounded Pointer Parallax for Poster Canvas
 */
function initPosterParallax() {
    const artboard = document.getElementById('poster-artboard');
    if (!artboard) return;

    // Skip on touch screens or if user prefers reduced motion
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const isFinePointer = window.matchMedia('(pointer: fine)').matches;

    if (prefersReducedMotion || !isFinePointer) return;

    let bounds = null;

    artboard.addEventListener('mouseenter', () => {
        bounds = artboard.getBoundingClientRect();
    });

    artboard.addEventListener('mousemove', (e) => {
        if (!bounds) bounds = artboard.getBoundingClientRect();

        const x = e.clientX - bounds.left;
        const y = e.clientY - bounds.top;

        const xPercent = (x / bounds.width) - 0.5;
        const yPercent = (y / bounds.height) - 0.5;

        // Strictly bounded movement: tilt within ±4deg, translation within ±6px
        const tiltX = (-yPercent * 8).toFixed(2);
        const tiltY = (xPercent * 8).toFixed(2);
        const transX = (xPercent * 6).toFixed(2);
        const transY = (yPercent * 6).toFixed(2);

        artboard.style.transform = `perspective(900px) rotateX(${tiltX}deg) rotateY(${tiltY}deg) translate3d(${transX}px, ${transY}px, 0)`;
    });

    artboard.addEventListener('mouseleave', () => {
        artboard.style.transform = 'perspective(900px) rotateX(0deg) rotateY(0deg) translate3d(0, 0, 0)';
        bounds = null;
    });
}

/**
 * Restrained Scroll Reveals
 */
function initScrollReveal() {
    const elements = document.querySelectorAll('.reveal-on-scroll');
    if (!elements.length) return;

    if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        elements.forEach(el => el.classList.add('is-revealed'));
        return;
    }

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-revealed');
                obs.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.15,
        rootMargin: '0px 0px -40px 0px'
    });

    elements.forEach(el => observer.observe(el));
}

/**
 * Mobile Navigation Menu & Accessible Drawer
 */
function initMobileMenu() {
    const toggleBtn = document.getElementById('mobile-menu-toggle');
    const drawer = document.getElementById('mobile-menu-drawer');
    const iconOpen = document.getElementById('hamburger-icon-open');
    const iconClose = document.getElementById('hamburger-icon-close');

    if (!toggleBtn || !drawer) return;

    let isOpen = false;

    function openMenu() {
        isOpen = true;
        toggleBtn.setAttribute('aria-expanded', 'true');
        drawer.setAttribute('aria-hidden', 'false');
        drawer.classList.remove('opacity-0', 'pointer-events-none', '-translate-y-2');
        drawer.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
        if (iconOpen) iconOpen.classList.add('hidden');
        if (iconClose) iconClose.classList.remove('hidden');
        document.body.classList.add('overflow-hidden', 'lg:overflow-auto');

        const firstLink = drawer.querySelector('a, button');
        if (firstLink) {
            setTimeout(() => firstLink.focus(), 50);
        }
    }

    function closeMenu() {
        isOpen = false;
        toggleBtn.setAttribute('aria-expanded', 'false');
        drawer.setAttribute('aria-hidden', 'true');
        drawer.classList.add('opacity-0', 'pointer-events-none', '-translate-y-2');
        drawer.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
        if (iconOpen) iconOpen.classList.remove('hidden');
        if (iconClose) iconClose.classList.add('hidden');
        document.body.classList.remove('overflow-hidden', 'lg:overflow-auto');
    }

    toggleBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        if (isOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    drawer.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            closeMenu();
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && isOpen) {
            closeMenu();
            toggleBtn.focus();
        }
    });

    document.addEventListener('click', (e) => {
        if (isOpen && !drawer.contains(e.target) && !toggleBtn.contains(e.target)) {
            closeMenu();
        }
    });
}

/**
 * Sticky Header Scroll State
 */
function initStickyHeader() {
    const header = document.getElementById('masthead');
    if (!header) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
            header.classList.add('shadow-sm');
        } else {
            header.classList.remove('shadow-sm');
        }
    }, { passive: true });
}

/**
 * FAQ Accordion Disclosures
 */
function initFaqAccordion() {
    const accordion = document.getElementById('faq-accordion');
    if (!accordion) return;

    const toggles = accordion.querySelectorAll('.faq-toggle');

    toggles.forEach(btn => {
        btn.addEventListener('click', () => {
            const isExpanded = btn.getAttribute('aria-expanded') === 'true';
            const content = btn.nextElementSibling;
            const icon = btn.querySelector('.faq-icon');

            // Close all items for single disclosure focus
            toggles.forEach(otherBtn => {
                otherBtn.setAttribute('aria-expanded', 'false');
                if (otherBtn.nextElementSibling) {
                    otherBtn.nextElementSibling.classList.add('hidden');
                }
                const otherIcon = otherBtn.querySelector('.faq-icon');
                if (otherIcon) {
                    otherIcon.textContent = '+';
                }
            });

            // Toggle selected item
            if (!isExpanded && content) {
                btn.setAttribute('aria-expanded', 'true');
                content.classList.remove('hidden');
                if (icon) {
                    icon.textContent = '−';
                }
            }
        });
    });
}

/**
 * Copy Article Link to Clipboard
 */
function initCopyLink() {
    const copyBtn = document.getElementById('copy-article-link');
    if (!copyBtn) return;

    copyBtn.addEventListener('click', () => {
        const url = copyBtn.getAttribute('data-url') || window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            const originalText = copyBtn.innerHTML;
            copyBtn.innerHTML = `
                <svg class="w-3.5 h-3.5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>Copied to Clipboard</span>
            `;
            setTimeout(() => {
                copyBtn.innerHTML = originalText;
            }, 2500);
        }).catch(err => {
            console.error('Could not copy link: ', err);
        });
    });
}

/**
 * Back to Top
 */
function initBackToTop() {
    const btn = document.getElementById('back-to-top');
    if (!btn) return;

    btn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

/**
 * AJAX Contact Form Submission
 */
function initContactForm() {
    const form = document.getElementById('agency-contact-form');
    const alertBox = document.getElementById('contact-form-alert');
    const submitBtn = document.getElementById('contact-submit-btn');
    const submitSpinner = document.getElementById('submit-spinner');
    const submitText = document.getElementById('submit-text');

    if (!form || !alertBox) return;

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        // UI Loading State
        if (submitBtn) submitBtn.disabled = true;
        if (submitSpinner) submitSpinner.classList.remove('hidden');
        if (submitText) submitText.textContent = 'Submitting Request...';

        alertBox.className = 'hidden mb-6 p-4 border text-sm font-mono';
        alertBox.textContent = '';

        const formData = new FormData(form);

        const ajaxUrl = (typeof agencySiteData !== 'undefined' && agencySiteData.ajaxUrl)
            ? agencySiteData.ajaxUrl
            : form.getAttribute('action');

        fetch(ajaxUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertBox.className = 'mb-6 p-5 border border-emerald-500 bg-emerald-50 text-emerald-900 text-sm font-mono block';
                alertBox.textContent = (data.data && data.data.message) ? data.data.message : 'Thank you! Your message has been sent successfully.';
                form.reset();
            } else {
                alertBox.className = 'mb-6 p-5 border border-red-500 bg-red-50 text-red-900 text-sm font-mono block';
                alertBox.textContent = (data.data && data.data.message) ? data.data.message : 'Something went wrong. Please check your inputs and try again.';
            }
        })
        .catch(err => {
            console.error('Contact Form Error:', err);
            alertBox.className = 'mb-6 p-5 border border-red-500 bg-red-50 text-red-900 text-sm font-mono block';
            alertBox.textContent = (typeof agencySiteData !== 'undefined' && agencySiteData.errorMsg)
                ? agencySiteData.errorMsg
                : 'Network error. Please try reaching out directly via phone or email.';
        })
        .finally(() => {
            if (submitBtn) submitBtn.disabled = false;
            if (submitSpinner) submitSpinner.classList.add('hidden');
            if (submitText) submitText.textContent = 'Request Strategy Consultation';
        });
    });
}
