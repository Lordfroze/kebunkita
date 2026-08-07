import { icon, refreshIcons } from './icons';

let currentClose = null;

export function openModal({ title, subtitle = '', body, footer = '', size = 'md', closable = true }) {
    closeModal();

    const sizes = { sm: 'max-w-md', md: 'max-w-lg', lg: 'max-w-2xl' };
    const root = document.getElementById('modal-root');
    if (!root) return null;

    root.innerHTML = `
        <div class="modal-backdrop" data-modal-backdrop>
            <div class="modal-panel ${sizes[size] || sizes.md}">
                <div class="flex items-start justify-between gap-4 border-b border-slate-100 px-6 py-4">
                    <div>
                        <h2 class="font-display text-lg font-bold text-slate-800">${title}</h2>
                        ${subtitle ? `<p class="mt-0.5 text-sm text-slate-500">${subtitle}</p>` : ''}
                    </div>
                    ${closable ? `
                        <button type="button" data-modal-close class="icon-btn -mr-2 -mt-1 h-8 w-8 text-slate-400">
                            ${icon('x', 'h-4 w-4')}
                        </button>` : ''}
                </div>
                <div class="px-6 py-5">${body}</div>
                ${footer ? `<div class="flex flex-col-reverse gap-2 border-t border-slate-100 bg-slate-50/70 px-6 py-4 sm:flex-row sm:justify-end">${footer}</div>` : ''}
            </div>
        </div>
    `;
    refreshIcons();

    currentClose = () => {
        const backdrop = root.querySelector('[data-modal-backdrop]');
        if (backdrop) {
            backdrop.classList.add('opacity-0');
            backdrop.style.transition = 'opacity 0.2s';
            setTimeout(() => {
                if (root.querySelector('[data-modal-backdrop]') === backdrop) {
                    root.innerHTML = '';
                    currentClose = null;
                }
            }, 180);
        } else {
            root.innerHTML = '';
            currentClose = null;
        }
    };

    if (closable) {
        root.querySelector('[data-modal-close]')?.addEventListener('click', currentClose);
        root.querySelector('[data-modal-backdrop]').addEventListener('mousedown', (e) => {
            if (e.target === e.currentTarget) currentClose();
        });
    }

    document.addEventListener('keydown', onKeydown);

    return {
        close: currentClose,
        element: root.querySelector('.modal-panel'),
    };
}

function onKeydown(e) {
    if (e.key === 'Escape') closeModal();
}

export function closeModal() {
    if (currentClose) {
        document.removeEventListener('keydown', onKeydown);
        currentClose();
    }
}
