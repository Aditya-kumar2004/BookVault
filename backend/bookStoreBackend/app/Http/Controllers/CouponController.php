<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        return response()->json(Coupon::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'discount_type' => 'required|string|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'max_uses' => 'nullable|integer|min:1',
        ]);

        $coupon = Coupon::create($request->all());

        return response()->json([
            'message' => 'Coupon created successfully! 🎉',
            'coupon' => $coupon
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $coupon->id,
            'discount_type' => 'required|string|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'max_uses' => 'nullable|integer|min:1',
        ]);

        $coupon->update($request->all());

        return response()->json([
            'message' => 'Coupon updated successfully! ✏️',
            'coupon' => $coupon
        ]);
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return response()->json([
            'message' => 'Coupon deleted successfully! 🗑️'
        ]);
    }

    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $code = strtoupper(trim($request->code));
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid coupon code. 😢'
            ], 404);
        }

        // Check expiry date
        if ($coupon->expiry_date && \Carbon\Carbon::parse($coupon->expiry_date)->isPast() && !\Carbon\Carbon::parse($coupon->expiry_date)->isToday()) {
            return response()->json([
                'valid' => false,
                'message' => 'This coupon has expired. ⏳'
            ], 400);
        }

        // Check usage limits
        if ($coupon->max_uses !== null && $coupon->uses_count >= $coupon->max_uses) {
            return response()->json([
                'valid' => false,
                'message' => 'This coupon usage limit has been reached. 🛑'
            ], 400);
        }

        return response()->json([
            'valid' => true,
            'message' => 'Coupon applied successfully! 🎉',
            'coupon' => $coupon
        ]);
    }
}
