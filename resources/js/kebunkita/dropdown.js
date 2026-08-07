export function initDropdowns() {
    document.addEventListener('click', (e) => {
        const toggle = e.target.closest('[data-dropdown-toggle]');

        if (toggle) {
            e.stopPropagation();
            const wrap = toggle.closest('[data-dropdown]');
            const menu = wrap ? wrap.querySelector('[data-dropdown-menu]') : null;
            if (!menu) return;

            const isOpen = !menu.classList.contains('hidden');
            closeAllDropdowns();
            if (!isOpen) {
                menu.classList.remove('hidden');
                toggle.setAttribute('aria-expanded', 'true');
            }
            return;
        }

        if (!e.target.closest('[data-dropdown-menu]')) {
            closeAllDropdowns();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeAllDropdowns();
    });
}

export function closeAllDropdowns() {
    document.querySelectorAll('[data-dropdown-menu]').forEach((menu) => {
        menu.classList.add('hidden');
        const wrap = menu.closest('[data-dropdown]');
        const toggle = wrap ? wrap.querySelector('[data-dropdown-toggle]') : null;
        if (toggle) toggle.setAttribute('aria-expanded', 'false');
    });
}
