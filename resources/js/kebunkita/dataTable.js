import DataTable from 'datatables.net';
import { refreshIcons } from './icons';

const instances = new Set();

const indonesianLanguage = {
    emptyTable: 'Belum ada data yang tersedia',
    info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
    infoEmpty: 'Menampilkan 0–0 dari 0 data',
    infoFiltered: '(disaring dari _MAX_ total data)',
    infoThousands: '.',
    lengthMenu: 'Tampilkan _MENU_ baris',
    loadingRecords: 'Memuat data...',
    processing: 'Memproses data...',
    search: '',
    searchPlaceholder: 'Cari data…',
    zeroRecords: 'Tidak ditemukan data yang cocok',
    paginate: {
        first: '«',
        last: '»',
        next: '›',
        previous: '‹',
    },
    aria: {
        orderable: ': klik untuk mengurutkan',
        orderableRemove: ': klik untuk menghapus urutan',
        orderableReverse: ': klik untuk urutan terbalik',
        paginate: {
            first: 'Halaman pertama',
            last: 'Halaman terakhir',
            next: 'Halaman berikutnya',
            previous: 'Halaman sebelumnya',
        },
    },
};

export function initDataTable(selector, options = {}) {
    const opts = { ...options };
    const userDraw = opts.drawCallback;
    delete opts.drawCallback;

    const defaults = {
        autoWidth: false,
        searchDelay: 300,
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'Semua'],
        ],
        order: [],
        language: indonesianLanguage,
        layout: {
            topStart: 'pageLength',
            topEnd: { search: { placeholder: 'Cari data…' } },
            bottomStart: 'info',
            bottomEnd: 'paging',
        },
        drawCallback(settings) {
            if (typeof userDraw === 'function') userDraw(settings);
            refreshIcons();
        },
    };

    const table = new DataTable(selector, { ...defaults, ...opts });
    instances.add(table);
    return table;
}

export function destroyAllTables() {
    instances.forEach((table) => {
        try {
            table.destroy();
        } catch (e) {
            // ignore teardown errors
        }
    });
    instances.clear();
}
