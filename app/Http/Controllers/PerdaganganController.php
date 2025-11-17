<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Items;
use Illuminate\Support\Facades\Http;


class PerdaganganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // otentikasi jika user belum login
        if (!Auth::check()) {
            return redirect('login');
        }

        // menampilkan halaman index
        $items = Items::where('active', "=", true)
            ->orderBy('nama_barang', 'desc')
            ->paginate(10);

        // hitung jumlah items
        $items_count = Items::count();

        // hitung jumlah stock
        $stock_count = Items::sum('stock');

        $view_data = [
            'items' => $items,
            'items_count' => $items_count,
            'stock_count' => $stock_count,

        ];


        return view('dashboard.perdagangan.index', $view_data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // menampilkan halaman tambah items
        if (!Auth::check()) {
            return redirect('login');
        }

        return view('dashboard.perdagangan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // otentikasi user
        if (!Auth::check()) {
            return redirect('login');
        }

        // menerima data dari form
        $tanggal = $request->input('tanggal') ?? now()->toDateString();  //Set tanggal to current date if not provided
        $nama_barang = $request->input('nama_barang');
        $harga_beli = $request->input('harga_beli');
        $harga_jual = $request->input('harga_jual');
        $stock = $request->input('stock');

        // simpan data ke database
        $items = Items::create([
            'nama_barang' => $nama_barang,
            'harga_beli' => $harga_beli,
            'harga_jual' => $harga_jual,
            'stock' => $stock,
            'created_at' => $tanggal,
            'updated_at' => $tanggal,
        ]);

        // kirim telegram setelah menyimpan data
        // $this->notify_telegram($items);  // agar tidak terlalu panjang dipisah ke fungsi notify_telegram dibawah

        return redirect('/dashboard/perdagangan')->with('success', 'Data Sukses Ditambahkan');
    }

    private function notify_telegram($items)
    {
        // fungsi untuk mengirimkan notifikasi ke telegram
        $api_token = "7356494066:AAE1knM0q6coNEbitf27Xxl8pgeJl3xYcoI";
        $url = "https://api.telegram.org/bot{$api_token}/sendMessage";
        $chat_id = -1002381690269;
        $content =
            "Ada kegiatan terbaru : <strong> \"{$items->nama_barang}\" </strong>
        \nLokasi : <strong> \"{$items->harga_jual}\" </strong>
        \nTanggal : <strong> \"{$items->stock}\" </strong>";


        $data = [
            'chat_id' => $chat_id,
            'text' => $content,
            'parse_mode' => 'html',
        ];

        Http::Post($url, $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // otentikasi user
        if (!Auth::check()) {
            return redirect('login');
        }
        // menampilkan halaman detail items
        $items = Items::findOrFail($id);
        return view('dashboard.perdagangan.show', compact('items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //otentikasi user
        if (!Auth::check()) {
            return redirect('login');
        }

        // menampilkan halaman edit items
        $items = Items::findOrFail($id);
        return view('dashboard.perdagangan.edit', compact('items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //otentikasi user
        if (!Auth::check()) {
            return redirect('login');
        }

        // menerima data dari form
        $tanggal = $request->input('tanggal') ?? now()->toDateString();  //Set tanggal to current date if not provided
        $nama_barang = $request->input('nama_barang');
        $harga_beli = $request->input('harga_beli');
        $harga_jual = $request->input('harga_jual');

        // update data
        Items::where('id', $id)->update([
            'updated_at' => $tanggal,
            'nama_barang' => $nama_barang,
            'harga_beli' => $harga_beli,
            'harga_jual' => $harga_jual,
        ]);

        return redirect('/dashboard/perdagangan')->with('success', 'Data Sukses Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // ontentikasi user
        if (!Auth::check()) {
            return redirect('login');
        }

        // delete data
        $items = Items::findOrFail($id);
        $items->delete();
        return redirect('/dashboard/perdagangan')->with('error', 'Data Sukses Dihapus');
    }

    // show kalkulator
    public function kalkulator(Request $request)
    {
        // if (!Auth::check()) {
        //     return redirect('login');
        // }

        $items = Items::orderBy('nama_barang', 'asc')->get();
        return view('dashboard.perdagangan.kalkulator', compact('items'));
    }

    // hitung kalkulator
    public function calculate(Request $request)
    {
        // if (!Auth::check()) {
        //     return redirect('login');
        // }

        $tanggal = now()->format('d-m-Y H:i:s');
        $jumlah_terjual = $request->input('jumlah_terjual', []);
        $results = [];

        if (empty($jumlah_terjual)) {
            return redirect()->back()->with('error', 'No quantities were submitted. Please enter at least one quantity.');
        }

        foreach ($jumlah_terjual as $item_id => $quantity) { // $item_id adalah id dari item yang diinputkan, dan $quantity adalah jumlah yang diinputkan
            $item = Items::find($item_id);
            if ($item && $quantity > 0) {
                $total = $item->harga_jual * $quantity;
                $results[] = [
                    'name' => $item->nama_barang,  // Assuming the column name is 'nama_barang'
                    'quantity' => $quantity,
                    'price' => $item->harga_jual,
                    'total' => $total,
                    'tanggal' => $tanggal
                ];
            }
        }

        if (empty($results)) {
            return redirect()->back()->with('error', 'No valid quantities were submitted. Please enter at least one quantity greater than zero.');
        }

        return view('dashboard.perdagangan.hasil_kalkulator', compact('results', 'tanggal'));
    }

    // download pdf
    public function downloadPdf(Request $request)
    {
        $results = json_decode($request->results, true);

        $tanggal = now()->format('d-m-Y H:i:s');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'dashboard.perdagangan.pdf_kalkulator',
            [
                'results' => $results,
                'tanggal' => $tanggal
            ]
        )->setPaper('a4', 'portrait');

        return $pdf->download("hasil_kalkulator_{$tanggal}.pdf");
    }
}
