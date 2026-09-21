/**
 * Agency Site Main Vanilla JavaScript
 *
 * Handles:
 * - Responsive Mobile Drawer Navigation
 * - Sticky Header Scroll States
 * - FAQ Accordion Interactions
 * - Copy Article Link to Clipboard
 * - Back to Top Action
 * - AJAX Contact Form Submission
 */

document.addEventListener('DOMContentLoaded', () => {
    initMobileMenu();
    initStickyHeader();
    initFaqAccordion();
    initCopyLink();
    initBackToTop();
    initContactForm();
});

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

        // Focus first navigation link for accessibility
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

    // Close when clicking a link inside the drawer
    drawer.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            closeMenu();
        });
    });

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && isOpen) {
            closeMenu();
            toggleBtn.focus();
        }
    });

    // Close when clicking outside
    document.addEventListener('click', (e) => {
        if (isOpen && !drawer.contains(e.target) && !toggleBtn.contains(e.target)) {
            closeMenu();
        }
    });
}

/**
 * Sticky Header Scroll Shadow
 */
function initStickyHeader() {
    const header = document.getElementById('masthead');
    if (!header) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
            header.classList.add('shadow-md');
        } else {
            header.classList.remove('shadow-md');
        }
    }, { passive: true });
}

/**
 * FAQ Accordion
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

            // Close all items
            toggles.forEach(otherBtn => {
                otherBtn.setAttribute('aria-expanded', 'false');
                if (otherBtn.nextElementSibling) {
                    otherBtn.nextElementSibling.classList.add('hidden');
                }
                const otherIcon = otherBtn.querySelector('.faq-icon');
                if (otherIcon) otherIcon.classList.remove('rotate-180');
            });

            // Toggle current if it was closed
            if (!isExpanded && content) {
                btn.setAttribute('aria-expanded', 'true');
                content.classList.remove('hidden');
                if (icon) icon.classList.add('rotate-180');
            }
        });
    });
}

/**
 * Copy Link to Clipboard
 */
function initCopyLink() {
    const copyBtn = document.getElementById('copy-article-link');
    if (!copyBtn) return;

    copyBtn.addEventListener('click', () => {
        const url = copyBtn.getAttribute('data-url') || window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            const originalText = copyBtn.innerHTML;
            copyBtn.innerHTML = `
                <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>Copied!</span>
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

        alertBox.className = 'hidden mb-6 p-4 rounded-2xl text-sm';
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
                alertBox.className = 'mb-6 p-5 rounded-2xl text-sm font-medium bg-emerald-50 text-emerald-800 border border-emerald-200 block shadow-xs';
                alertBox.textContent = (data.data && data.data.message) ? data.data.message : 'Thank you! Your message has been sent successfully.';
                form.reset();
            } else {
                alertBox.className = 'mb-6 p-5 rounded-2xl text-sm font-medium bg-red-50 text-red-800 border border-red-200 block shadow-xs';
                alertBox.textContent = (data.data && data.data.message) ? data.data.message : 'Something went wrong. Please check your inputs and try again.';
            }
        })
        .catch(err => {
            console.error('Contact Form Error:', err);
            alertBox.className = 'mb-6 p-5 rounded-2xl text-sm font-medium bg-red-50 text-red-800 border border-red-200 block shadow-xs';
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

