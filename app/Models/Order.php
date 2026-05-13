<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

        protected $fillable = [
        'user_id',
        'status',
        'total_price',
        'nama_penerima',
        'no_telepon',
        'alamat',
        'kota',
        'kode_pos',
        'provinsi',
        'kurir',
        'pembayaran',
        'catatan',
        'ongkir',
        'discount',
    ];

    // Penting: Memastikan tipe data benar saat ditarik dari database
    protected $casts = [
        'total_price' => 'float',
        'created_at' => 'datetime',
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

    // Accessor untuk tampilan di Blade
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