<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Items;


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

        $items = Items::orderBy('created_at', 'desc')->paginate(10);


        return view('dashboard.perdagangan.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // show kalkulator
    public function kalkulator(Request $request)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $items = Items::orderBy('nama_barang', 'asc')->get();
        return view('dashboard.perdagangan.kalkulator', compact('items'));
    }

    // hitung kalkulator
    public function calculate(Request $request)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

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
                    'total' => $total
                ];
            }
        }

        if (empty($results)) {
            return redirect()->back()->with('error', 'No valid quantities were submitted. Please enter at least one quantity greater than zero.');
        }

        return view('dashboard.perdagangan.hasil_kalkulator', compact('results'));
    }
}
