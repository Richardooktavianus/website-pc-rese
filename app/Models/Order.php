<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_id','component','product_name','price'];

    // ✅ default status biar aman
    protected $attributes = [
        'status' => 'pending',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // 🔹 RELASI USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔹 RELASI ITEM (produk di dalam order)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // 🔹 TOTAL FORMAT (helper)
    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    // 🔹 STATUS LABEL (biar gampang di Filament)
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'paid' => 'Paid',
            'process' => 'Diproses',
            'shipped' => 'Dikirim',
            'done' => 'Selesai',
            'cancel' => 'Dibatalkan',
            default => 'Unknown',
        };
    }
}