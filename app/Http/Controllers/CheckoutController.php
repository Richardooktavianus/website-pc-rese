<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\DiscountTier;

class CheckoutController extends Controller
{
    public function index()
    {
        $checkoutItems   = session()->get('checkout_items', []);
        $checkoutIndexes = session()->get('checkout_indexes', []);

        if (empty($checkoutItems)) {
            $subtotal = 0;
        }

        $subtotal = 0;
        foreach ($checkoutItems as $entry) {
            $subtotal += $entry['total'] ?? 0;
        }

        // ✅ Hitung diskon otomatis berdasarkan tier
        $discountTier   = DiscountTier::getApplicableTier($subtotal);
        $discountAmount = $discountTier ? $discountTier->calculateDiscount($subtotal) : 0;
        $subtotalAfterDiscount = $subtotal - $discountAmount;

        return view('checkout', compact(
            'checkoutItems',
            'checkoutIndexes',
            'subtotal',
            'discountTier',
            'discountAmount',
            'subtotalAfterDiscount'
        ));
    }

    public function prepare(Request $request)
    {
        $selectedIndexes = $request->input('selected', []);

        if (empty($selectedIndexes)) {
            return redirect('/cart')->with('error', 'Pilih minimal 1 item untuk checkout.');
        }

        $cart          = session()->get('cart', []);
        $checkoutItems = [];

        foreach ($selectedIndexes as $idx) {
            if (isset($cart[(int)$idx])) {
                $checkoutItems[] = $cart[(int)$idx];
            }
        }

        if (empty($checkoutItems)) {
            return redirect('/cart')->with('error', 'Item tidak ditemukan.');
        }

        session()->put('checkout_items', $checkoutItems);
        session()->put('checkout_indexes', array_map('intval', $selectedIndexes));

        return redirect('/transaksi');
    }

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

        $ongkirMap = [
            'JNE - REG'          => 18000,
            'J&T - Regular'      => 15000,
            'SiCepat - HALU'     => 20000,
            'AnterAja - Regular' => 13000,
            'Pos Indonesia'      => 10000,
            'GoSend - SameDay'   => 35000,
        ];
        $ongkir = $ongkirMap[$request->kurir] ?? 0;

        // Hitung subtotal
        $subtotal = 0;
        foreach ($checkoutItems as $entry) {
            $subtotal += $entry['total'] ?? 0;
        }

        // ✅ Hitung diskon otomatis
        $discountTier   = DiscountTier::getApplicableTier($subtotal);
        $discountAmount = $discountTier ? $discountTier->calculateDiscount($subtotal) : 0;

        $grandTotal = $subtotal - $discountAmount + $ongkir;

        $order = Order::create([
            'user_id'       => auth()->check() ? auth()->id() : null,
            'total_price'   => $grandTotal,
            'status'        => 'pending',
            'nama_penerima' => $request->nama_penerima,
            'no_telepon'    => $request->no_telepon,
            'alamat'        => $request->alamat,
            'kota'          => $request->kota,
            'kode_pos'      => $request->kode_pos,
            'provinsi'      => $request->provinsi,
            'kurir'         => $request->kurir,
            'pembayaran'    => $request->pembayaran,
            'catatan'       => $request->catatan,
            'ongkir'        => $ongkir,
            'discount'      => $discountAmount, // ✅ simpan nominal diskon
        ]);

        foreach ($checkoutItems as $entry) {
            if (!isset($entry['items']) || !is_array($entry['items'])) {
                continue;
            }

            foreach ($entry['items'] as $item) {
                OrderItem::create([

    'order_id'     => $order->id,

    'product_id'   => $entry['product_id'] ?? null,

    'component'    => $entry['name'] ?? 'Produk',

    'product_name' => $entry['name'] ?? 'Produk',

    'price'        => $entry['price'] ?? 0,

    'quantity'     => $entry['quantity'] ?? 1,

]);
            }
        }

        // Hapus item yang sudah dibayar dari cart
        $cart = session()->get('cart', []);
        rsort($checkoutIndexes);
        foreach ($checkoutIndexes as $idx) {
            if (isset($cart[$idx])) {
                unset($cart[$idx]);
            }
        }
        session()->put('cart', array_values($cart));
        session()->forget(['checkout_items', 'checkout_indexes']);

        return redirect('/cart')->with('success', '✅ Pembayaran berhasil! Order #' . $order->id . ' sedang diproses.');
    }
}