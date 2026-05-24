<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;

class RazorpayController extends Controller
{
    /**
     * Display the professional modern payment page pre-populated with Razorpay Order ID.
     */
    public function showPaymentPage()
    {
        $keyId = config('razorpay.key_id');
        $keySecret = config('razorpay.key_secret');

        if (!$keyId || !$keySecret) {
            return view('razorpay.error', [
                'message' => 'Razorpay credentials not set! Please check your .env configuration.'
            ]);
        }

        $api = new Api($keyId, $keySecret);

        try {
            // Pre-generate Razorpay Order for ₹500
            $orderData = [
                'receipt'         => 'rcpt_' . time(),
                'amount'          => 500 * 100, // ₹500 in paise
                'currency'        => 'INR',
            ];
            
            $razorpayOrder = $api->order->create($orderData);
            $orderId = $razorpayOrder['id'];

            return view('razorpay.payment', compact('orderId', 'keyId'));
        } catch (\Exception $e) {
            Log::error('Razorpay Order Initialization failed: ' . $e->getMessage());
            return view('razorpay.error', [
                'message' => 'Failed to initialize payment gateway: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Handle Razorpay payment callback, capture status verification and secure signature checks.
     */
    public function paymentCallback(Request $request)
    {
        $input = $request->all();
        
        if (empty($input['razorpay_payment_id']) || empty($input['razorpay_signature'])) {
            return view('razorpay.error', [
                'message' => 'Payment failed, cancelled, or missing response parameters.'
            ]);
        }

        $keyId = config('razorpay.key_id');
        $keySecret = config('razorpay.key_secret');
        $api = new Api($keyId, $keySecret);

        try {
            // Verify signature
            $attributes = [
                'razorpay_order_id' => $input['razorpay_order_id'],
                'razorpay_payment_id' => $input['razorpay_payment_id'],
                'razorpay_signature' => $input['razorpay_signature']
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // Fetch payment details to verify status
            $payment = $api->payment->fetch($input['razorpay_payment_id']);

            // Capture payment if authorized manually (usually captured automatically)
            if ($payment->status === 'authorized') {
                $payment->capture(['amount' => $payment->amount]);
            }

            return view('razorpay.success', [
                'payment_id' => $input['razorpay_payment_id'],
                'order_id' => $input['razorpay_order_id'],
                'amount' => number_format($payment->amount / 100, 2),
                'method' => $payment->method,
                'email' => $payment->email,
            ]);

        } catch (\Exception $e) {
            Log::error('Razorpay Signature Verification failed: ' . $e->getMessage());
            return view('razorpay.error', [
                'message' => 'Signature verification failed! Transaction could not be verified securely: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * API: Create a Razorpay order securely after validating cart items and stock.
     */
    public function apiCreateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.book.id' => 'required|exists:books,id',
            'items.*.qty' => 'required|integer|min:1',
            'coupon_code' => 'nullable|string',
        ]);

        $items = $request->input('items', []);
        
        $total = 0;
        foreach ($items as $item) {
            $book = \App\Models\Book::find($item['book']['id']);
            if (!$book) {
                return response()->json(['message' => "Book not found."], 404);
            }
            if ($book->stock < $item['qty']) {
                return response()->json(['message' => "Sorry, '{$book->title}' has only {$book->stock} items in stock."], 400);
            }
            $total += $book->price * $item['qty'];
        }

        // Coupon calculation
        $coupon = null;
        if ($request->has('coupon_code') && !empty($request->coupon_code)) {
            $code = strtoupper(trim($request->coupon_code));
            $coupon = \App\Models\Coupon::where('code', $code)->first();
            if (!$coupon) {
                return response()->json(['message' => 'Invalid coupon code.'], 400);
            }

            // Check expiry date
            if ($coupon->expiry_date && \Carbon\Carbon::parse($coupon->expiry_date)->isPast() && !\Carbon\Carbon::parse($coupon->expiry_date)->isToday()) {
                return response()->json(['message' => 'This coupon has expired.'], 400);
            }

            // Check usage limits
            if ($coupon->max_uses !== null && $coupon->uses_count >= $coupon->max_uses) {
                return response()->json(['message' => 'This coupon usage limit has been reached.'], 400);
            }

            // Calculate discount
            $discount = 0;
            if ($coupon->discount_type === 'percent') {
                $discount = $total * ($coupon->discount_value / 100);
            } else {
                $discount = $coupon->discount_value;
            }

            $total = max(0, $total - $discount);
        }

        $keyId = config('razorpay.key_id');
        $keySecret = config('razorpay.key_secret');

        if (!$keyId || !$keySecret) {
            return response()->json(['message' => 'Razorpay credentials not set!'], 500);
        }

        $api = new Api($keyId, $keySecret);

        try {
            // Generate Razorpay Order
            $orderData = [
                'receipt'         => 'rcpt_' . time(),
                'amount'          => (int) round($total * 100), // In paise, must be cast to integer
                'currency'        => 'INR',
            ];
            
            $razorpayOrder = $api->order->create($orderData);
            
            return response()->json([
                'order_id' => $razorpayOrder['id'],
                'amount' => $total,
                'key_id' => $keyId,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Razorpay API Order creation failed: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to initialize payment gateway: ' . $e->getMessage()], 500);
        }
    }

    /**
     * API: Verify Razorpay signature, capture the payment, and securely commit order inside DB.
     */
    public function apiVerifyPayment(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
            'shipping_address' => 'required|string',
            'items' => 'required|array',
            'coupon_code' => 'nullable|string',
        ]);

        $input = $request->all();

        $keyId = config('razorpay.key_id');
        $keySecret = config('razorpay.key_secret');
        
        if (!$keyId || !$keySecret) {
            return response()->json(['message' => 'Razorpay credentials not set!'], 500);
        }

        $api = new Api($keyId, $keySecret);

        try {
            // Verify signature
            $attributes = [
                'razorpay_order_id' => $input['razorpay_order_id'],
                'razorpay_payment_id' => $input['razorpay_payment_id'],
                'razorpay_signature' => $input['razorpay_signature']
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // Fetch payment details to verify status
            $payment = $api->payment->fetch($input['razorpay_payment_id']);

            // Capture payment if authorized
            if ($payment->status === 'authorized') {
                $payment->capture(['amount' => $payment->amount]);
            }

            // Create official Order record in DB
            $user = $request->user();
            $items = $request->input('items', []);
            
            $total = 0;
            foreach ($items as $item) {
                $book = \App\Models\Book::find($item['book']['id']);
                if (!$book) {
                    return response()->json(['message' => "Book not found."], 404);
                }
                if ($book->stock < $item['qty']) {
                    return response()->json(['message' => "Sorry, '{$book->title}' has only {$book->stock} items in stock."], 400);
                }
                $total += $book->price * $item['qty'];
            }

            // Coupon calculation
            $coupon = null;
            if ($request->has('coupon_code') && !empty($request->coupon_code)) {
                $code = strtoupper(trim($request->coupon_code));
                $coupon = \App\Models\Coupon::where('code', $code)->first();
                if ($coupon) {
                    // Check expiry date
                    if ($coupon->expiry_date && \Carbon\Carbon::parse($coupon->expiry_date)->isPast() && !\Carbon\Carbon::parse($coupon->expiry_date)->isToday()) {
                        return response()->json(['message' => 'This coupon has expired.'], 400);
                    }

                    // Check usage limits
                    if ($coupon->max_uses !== null && $coupon->uses_count >= $coupon->max_uses) {
                        return response()->json(['message' => 'This coupon usage limit has been reached.'], 400);
                    }

                    // Calculate discount
                    $discount = 0;
                    if ($coupon->discount_type === 'percent') {
                        $discount = $total * ($coupon->discount_value / 100);
                    } else {
                        $discount = $coupon->discount_value;
                    }

                    $total = max(0, $total - $discount);
                }
            }

            $order = \App\Models\Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'shipping_address' => $request->shipping_address,
                'status' => 'processing' // Paid/Processing status
            ]);

            foreach ($items as $item) {
                $book = \App\Models\Book::find($item['book']['id']);
                $order->items()->create([
                    'book_id' => $book->id,
                    'quantity' => $item['qty'],
                    'unit_price' => $book->price
                ]);
                $book->decrement('stock', $item['qty']);
            }

            if ($coupon) {
                $coupon->increment('uses_count');
            }

            // Clear the DB cart if exists
            $cart = $user->cart()->first();
            if ($cart) {
                $cart->items()->delete();
            }

            return response()->json([
                'message' => 'Order placed and paid successfully',
                'order' => $order->load('items.book')
            ], 201);

        } catch (\Exception $e) {
            Log::error('Razorpay Secure Verification failed: ' . $e->getMessage());
            return response()->json(['message' => 'Signature verification failed! Transaction could not be verified securely: ' . $e->getMessage()], 400);
        }
    }
}
