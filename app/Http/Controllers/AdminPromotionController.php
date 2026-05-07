<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminPromotionController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'promo_code' => [
                'required',
                'string',
                'max:20',
                'unique:promotions,promo_code',
            ],
            'discount_type' => [
                'required',
                Rule::in(['Percentage', 'Fixed Amount']),
            ],
            'discount_value' => [
                'required',
                'numeric',
                'min:0.01',
            ],
            'route' => [
                'required',
                'string',
                'max:255',
            ],
        ], [
            'promo_code.required' => 'Promo code is required.',
            'promo_code.max' => 'Promo code must be 20 characters or less.',
            'promo_code.unique' => 'This promo code already exists.',
            'discount_type.required' => 'Discount type is required.',
            'discount_value.required' => 'Discount value is required.',
            'discount_value.numeric' => 'Discount value must be a number.',
            'discount_value.min' => 'Discount value must be greater than 0.',
            'route.required' => 'Applicable route is required.',
        ]);

        $validator->after(function ($validator) use ($request) {
            if (
                $request->discount_type === 'Percentage'
                && (float) $request->discount_value > 100
            ) {
                $validator->errors()->add(
                    'discount_value',
                    'Percentage discount cannot be more than 100.'
                );
            }
        });

        if ($validator->fails()) {
            return redirect()
                ->route('admin.dashboard')
                ->withErrors($validator)
                ->withInput()
                ->with('active_section', 'discounts');
        }

        Promotion::create([
            'promo_code' => strtoupper($request->promo_code),
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'route' => $request->route,
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('active_section', 'discounts')
            ->with('promotion_success', 'Promotion added successfully!');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('active_section', 'discounts')
            ->with('promotion_success', 'Promotion deleted successfully!');
    }
}
