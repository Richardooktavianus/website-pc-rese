<?php

namespace App\Http\Controllers;

use App\Models\DiscountTier;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $tiers = DiscountTier::orderBy('min_order')->get();
        return view('promo', compact('tiers'));
    }
}