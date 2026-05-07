<?php

namespace App\Http\Controllers;

use App\Models\Promotion;

class HomeController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->get();

        return view('home', compact('promotions'));
    }

    public function livePromotions()
    {
        $promotions = Promotion::latest()->get()->map(function ($promotion) {
            return [
                'promo_code' => $promotion->promo_code,
                'discount_type' => $promotion->discount_type,
                'discount_value' => $promotion->discount_value,
                'route' => $promotion->route,
            ];
        });

        return response()->json($promotions);
    }
}
