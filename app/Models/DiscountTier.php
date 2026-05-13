<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountTier extends Model
{
    protected $fillable = ['label', 'min_order', 'discount', 'description'];

    // Ambil tier yang sesuai dengan total belanja
    public static function getApplicableTier(int $total): ?self
    {
        return self::where('min_order', '<=', $total)
                   ->orderBy('min_order', 'desc')
                   ->first();
    }

    // Hitung nominal diskon
    public function calculateDiscount(int $total): int
    {
        return (int) ($total * $this->discount / 100);
    }
}