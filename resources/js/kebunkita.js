import './bootstrap';
import { Chart } from 'chart.js/auto';
import { refreshIcons } from './kebunkita/icons';
import { initDropdowns } from './kebunkita/dropdown';
import { toast } from './kebunkita/toast';
import { openModal, closeModal } from './kebunkita/modal';
import { initDataTable, destroyAllTables } from './kebunkita/dataTable';
import { chartColors, registerChart } from './kebunkita/charts';

/* ------------------------------------------------------------------
   Sidebar (drawer mobile + collapse desktop)
   ------------------------------------------------------------------ */
function initSidebar() {
    const toggle = document.getElementById('sidebar-toggle');
    if (toggle) {
        toggle.addEventListener('click', () => {
            document.body.classList.add('sidebar-open');
        });
    }

    const backdrop = document.getElementById('sidebar-backdrop');
    if (backdrop) {
        backdrop.addEventListener('click', () => {
            document.body.classList.remove('sidebar-open');
        });
    }

    const collapseBtn = document.getElementById('sidebar-collapse-btn');
    if (collapseBtn) {
        collapseBtn.addEventListener('click', () => {
            const collapsed = document.body.classList.toggle('sidebar-collapsed');
            try {
                localStorage.setItem('kebunkita-collapsed', collapsed ? '1' : '0');
            } catch (e) {
                // storage unavailable
            }
        });
        const saved = (() => {
            try {
                return localStorage.getItem('kebunkita-collapsed') === '1';
            } catch (e) {
                return false;
            }
        })();
        if (saved) document.body.classList.add('sidebar-collapsed');
    }

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) document.body.classList.remove('sidebar-open');
    });
}

/* ------------------------------------------------------------------
   Topbar global search (filters the active DataTable, if any)
   ------------------------------------------------------------------ */
let activeTable = null;

function initTopbar() {
    const searchEl = document.getElementById('global-search');
    if (searchEl) {
        searchEl.addEventListener('input', (e) => {
            if (activeTable) activeTable.search(e.target.value).draw();
        });
    }
}

function setActiveTable(table) {
    activeTable = table;
}

/* ------------------------------------------------------------------
   Global delete-confirmation modal for form[data-confirm-delete]
   ------------------------------------------------------------------ */
function initDeleteConfirm() {
    document.addEventListener('submit', (e) => {
        const form = e.target.closest('form[data-confirm-delete]');
        if (!form) return;
        e.preventDefault();
        const message = form.dataset.confirmDelete || 'Yakin ingin menghapus data ini?';

        openModal({
            title: 'Hapus Data',
            subtitle: 'Tindakan ini tidak dapat dibatalkan.',
            size: 'sm',
            body: `
                <div class="flex items-start gap-4">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600">
                        <i data-lucide="circle-alert" class="h-5 w-5"></i>
                    </span>
                    <p class="text-sm text-slate-600">
                        Anda yakin ingin menghapus <span class="font-semibold text-slate-800">${message}</span>?
                    </p>
                </div>
            `,
            footer: `
                <button type="button" data-modal-batal class="btn-secondary">Batal</button>
                <button type="button" data-confirm-ok class="btn-danger"><i data-lucide="trash-2" class="h-4 w-4"></i> Ya, Hapus</button>
            `,
        });
        document.querySelector('[data-modal-batal]')?.addEventListener('click', () => closeModal());
        document.querySelector('[data-confirm-ok]')?.addEventListener('click', () => {
            closeModal();
            form.submit();
        });
        refreshIcons();
    });
}

/* ------------------------------------------------------------------
   Auto init DataTables marked with [data-datatable]
   ------------------------------------------------------------------ */
function autoInitTables() {
    document.querySelectorAll('[data-datatable]').forEach((el) => {
        const name = el.dataset.datatable;
        const handler = window.KebunKita && window.KebunKita.tables && window.KebunKita.tables[name];
        if (typeof handler === 'function') {
            setActiveTable(handler(el));
        }
    });
}

/* ------------------------------------------------------------------
   Public API exposed to Blade pages
   ------------------------------------------------------------------ */
window.Chart = Chart;

window.KebunKita = {
    refreshIcons,
    toast,
    openModal,
    closeModal,
    initDataTable,
    destroyAllTables,
    chartColors,
    registerChart,
    setActiveTable,
    tables: {},
    ready(fn) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn);
        } else {
            fn();
        }
    },
};

document.addEventListener('DOMContentLoaded', () => {
    refreshIcons();
    initDropdowns();
    initSidebar();
    initTopbar();
    initDeleteConfirm();
    autoInitTables();
});
