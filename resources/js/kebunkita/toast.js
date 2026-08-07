import { icon, refreshIcons } from './icons';

const variants = {
    success: {
        wrapper: 'toast-success',
        iconName: 'circle-check',
        iconClass: 'text-emerald-600',
    },
    error: {
        wrapper: 'toast-error',
        iconName: 'circle-alert',
        iconClass: 'text-red-600',
    },
    info: {
        wrapper: 'toast-info',
        iconName: 'info',
        iconClass: 'text-sky-600',
    },
};

let counter = 0;

export function toast(message, type = 'success', title = '') {
    const v = variants[type] || variants.success;
    const id = `toast-${++counter}`;
    const root = document.getElementById('toast-root');
    if (!root) return;

    const el = document.createElement('div');
    el.id = id;
    el.setAttribute('role', 'status');
    el.className = `toast ${v.wrapper}`;
    el.innerHTML = `
        <span class="mt-0.5 shrink-0 ${v.iconClass}">${icon(v.iconName, 'h-5 w-5')}</span>
        <div class="min-w-0 flex-1">
            ${title ? `<p class="text-sm font-semibold text-slate-800">${title}</p>` : ''}
            <p class="text-sm text-slate-600">${message}</p>
        </div>
        <button type="button" data-toast-close class="shrink-0 text-slate-400 transition-colors hover:text-slate-600">
            ${icon('x', 'h-4 w-4')}
        </button>
    `;

    root.appendChild(el);
    refreshIcons();

    const remove = () => {
        el.classList.add('toast-leave');
        setTimeout(() => el.remove(), 350);
    };

    el.querySelector('[data-toast-close]').addEventListener('click', remove);
    setTimeout(remove, 4200);
}
