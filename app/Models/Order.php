<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',      // ← ini yang menyebabkan error
        'total_price',
        'status',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending'  => 'Pending',
            'paid'     => 'Paid',
            'process'  => 'Diproses',
            'shipped'  => 'Dikirim',
            'done'     => 'Selesai',
            'cancel'   => 'Dibatalkan',
            default    => 'Unknown',
        };
    }
}