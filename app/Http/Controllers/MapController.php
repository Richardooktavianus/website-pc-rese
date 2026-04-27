<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function getMarkers()
    {
        $initialMarkers = [
            [
                'position' => [
                    'lat' => -6.895497,
                    'lng' => 107.613289
                ],
                'label' => 'PC Rakit Store - Bandung',
                'draggable' => false
            ],
            // Tambahkan lokasi cabang lain jika ada
        ];
        
        return response()->json($initialMarkers);
    }
}