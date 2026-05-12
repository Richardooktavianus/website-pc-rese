<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    /**
     * Halaman checkout — hanya tampilkan item yang dipilih (dari session 'checkout_items')
     */
    public function index()
    {
        // Item terpilih dikirim dari cart via POST, lalu disimpan ke session sementara
        $checkoutItems  = session()->get('checkout_items', []);   // item yg dipilih
        $checkoutIndexes = session()->get('checkout_indexes', []); // index asli di cart

        if (empty($checkoutItems)) {
    $checkoutItems = [];
    $subtotal = 0;
}

        // Hitung subtotal dari item terpilih saja
        $subtotal = 0;
        foreach ($checkoutItems as $entry) {
            $subtotal += $entry['total'] ?? 0;
        }

        return view('checkout', compact('checkoutItems', 'checkoutIndexes', 'subtotal'));
    }

    /**
     * Simpan item terpilih ke session lalu redirect ke halaman checkout
     * Dipanggil via POST dari halaman cart
     */
    public function prepare(Request $request)
    {
        $selectedIndexes = $request->input('selected', []);

        if (empty($selectedIndexes)) {
            return redirect('/cart')->with('error', 'Pilih minimal 1 item untuk checkout.');
        }

        $cart = session()->get('cart', []);
        $checkoutItems = [];

        foreach ($selectedIndexes as $idx) {
            if (isset($cart[(int)$idx])) {
                $checkoutItems[] = $cart[(int)$idx];
            }
        }

        if (empty($checkoutItems)) {
            return redirect('/cart')->with('error', 'Item tidak ditemukan.');
        }

        // Simpan item terpilih & index aslinya ke session sementara
        session()->put('checkout_items', $checkoutItems);
        session()->put('checkout_indexes', array_map('intval', $selectedIndexes));

        return redirect('/transaksi');
    }

    /**
     * Proses pembayaran — simpan order, hapus item terpilih dari cart
     */
    public function process(Request $request)
    {
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'no_telepon'    => 'required|string|max:20',
            'alamat'        => 'required|string',
            'kota'          => 'required|string',
            'kode_pos'      => 'required|string|max:10',
            'provinsi'      => 'required|string',
            'kurir'         => 'required|string',
            'pembayaran'    => 'required|string',
        ]);

        $checkoutItems   = session()->get('checkout_items', []);
        $checkoutIndexes = session()->get('checkout_indexes', []);

        if (empty($checkoutItems)) {
            return redirect('/cart')->with('error', 'Sesi checkout habis, silakan ulangi.');
        }

        // Hitung ongkir dari kurir yang dipilih
        $ongkirMap = [
            'JNE - REG'          => 18000,
            'J&T - Regular'      => 15000,
            'SiCepat - HALU'     => 20000,
            'AnterAja - Regular' => 13000,
            'Pos Indonesia'      => 10000,
            'GoSend - SameDay'   => 35000,
        ];
        $ongkir = $ongkirMap[$request->kurir] ?? 0;

        // Hitung total dari item terpilih + ongkir
        $subtotal = 0;
        foreach ($checkoutItems as $entry) {
            $subtotal += $entry['total'] ?? 0;
        }
        $grandTotal = $subtotal + $ongkir;

        // Buat satu Order untuk semua item terpilih
        $order = Order::create([
            'user_id'        => auth()->id(),
            'total_price'    => $grandTotal,
            'status'         => 'pending',
            'nama_penerima'  => $request->nama_penerima,
            'no_telepon'     => $request->no_telepon,
            'alamat'         => $request->alamat,
            'kota'           => $request->kota,
            'kode_pos'       => $request->kode_pos,
            'provinsi'       => $request->provinsi,
            'kurir'          => $request->kurir,
            'pembayaran'     => $request->pembayaran,
            'catatan'        => $request->catatan,
            'ongkir'         => $ongkir,
        ]);

        // Simpan setiap produk sebagai OrderItem
        foreach ($checkoutItems as $entry) {

    if (!isset($entry['items']) || !is_array($entry['items'])) {
        continue;
    }

    foreach ($entry['items'] as $item) {

        OrderItem::create([
            'order_id'     => $order->id,
            'product_id'   => $entry['product_id'] ?? null,
            'component'    => $item['name'] ?? 'Unknown',
            'product_name' => $item['name'] ?? 'Unknown',
            'price'        => $item['price'] ?? 0,
            'quantity'     => $item['quantity'] ?? 1,
        ]);
    }
}

        // ✅ Hapus HANYA item yang sudah dibayar dari cart
        $cart = session()->get('cart', []);
        rsort($checkoutIndexes); // hapus dari belakang agar index tidak bergeser
        foreach ($checkoutIndexes as $idx) {
            if (isset($cart[$idx])) {
                unset($cart[$idx]);
            }
        }
        session()->put('cart', array_values($cart));

        // Bersihkan session checkout sementara
        session()->forget(['checkout_items', 'checkout_indexes']);

        return redirect('/cart')->with('success', '✅ Pembayaran berhasil! Order #' . $order->id . ' sedang diproses.');
    }
}