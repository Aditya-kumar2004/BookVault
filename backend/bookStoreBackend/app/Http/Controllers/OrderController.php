<?php
namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller {
    public function index(Request $request) {
        $user = $request->user();
        if ($user->role === 'admin') {
            return response()->json(Order::with(['items.book', 'user'])->latest()->get());
        }
        return response()->json($user->orders()->with('items.book')->latest()->get());
    }

    public function updateStatus(Request $request, $id) {
        $user = $request->user();
        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order = Order::with('items.book')->find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Restore stock if transitioning to cancelled from non-cancelled status
        if ($request->status === 'cancelled' && $order->status !== 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->book) {
                    $item->book->increment('stock', $item->quantity);
                }
            }
        }

        $order->update(['status' => $request->status]);
        return response()->json(['message' => 'Order status updated successfully', 'order' => $order->load('items.book', 'user')]);
    }

    public function store(Request $request) {
        $user = $request->user();
        
        // Support direct items array from Zustand frontend
        if ($request->has('items')) {
            $items = $request->input('items', []);
            if (empty($items)) return response()->json(['message' => 'Cart is empty'], 400);
            
            $total = 0;
            foreach ($items as $item) {
                $book = \App\Models\Book::find($item['book']['id']);
                if (!$book) return response()->json(['message' => "Book not found."], 404);
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
            
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'shipping_address' => $request->shipping_address ?? 'Default Address',
                'status' => 'pending'
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
            
            return response()->json(['message' => 'Order placed', 'order' => $order->load('items.book')], 201);
        }

        // Fallback to database cart tables
        $cart = $user->cart()->with('items.book')->first();
        if (!$cart || $cart->items->isEmpty()) return response()->json(['message'=>'Cart is empty'], 400);
        
        foreach ($cart->items as $item) {
            if ($item->book->stock < $item->quantity) {
                return response()->json(['message' => "Sorry, '{$item->book->title}' has only {$item->book->stock} items in stock."], 400);
            }
        }

        $total = $cart->items->sum(fn($item) => $item->book->price * $item->quantity);

        // Coupon calculation for fallback
        $coupon = null;
        if ($request->has('coupon_code') && !empty($request->coupon_code)) {
            $code = strtoupper(trim($request->coupon_code));
            $coupon = \App\Models\Coupon::where('code', $code)->first();
            if ($coupon) {
                $valid = true;
                if ($coupon->expiry_date && \Carbon\Carbon::parse($coupon->expiry_date)->isPast() && !\Carbon\Carbon::parse($coupon->expiry_date)->isToday()) {
                    $valid = false;
                }
                if ($coupon->max_uses !== null && $coupon->uses_count >= $coupon->max_uses) {
                    $valid = false;
                }

                if ($valid) {
                    $discount = 0;
                    if ($coupon->discount_type === 'percent') {
                        $discount = $total * ($coupon->discount_value / 100);
                    } else {
                        $discount = $coupon->discount_value;
                    }
                    $total = max(0, $total - $discount);
                }
            }
        }

        $order = Order::create(['user_id'=>$user->id,'total_amount'=>$total,'shipping_address'=>$request->shipping_address,'status'=>'pending']);
        foreach ($cart->items as $item) {
            $order->items()->create(['book_id'=>$item->book_id,'quantity'=>$item->quantity,'unit_price'=>$item->book->price]);
            $item->book->decrement('stock', $item->quantity);
        }
        $cart->items()->delete();

        if ($coupon && isset($valid) && $valid) {
            $coupon->increment('uses_count');
        }

        return response()->json(['message'=>'Order placed','order'=>$order->load('items.book')], 201);
    }

    public function cancelOrder(Request $request, $id) {
        $user = $request->user();
        
        $order = Order::where('id', $id)->where('user_id', $user->id)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        
        if (!in_array($order->status, ['pending', 'processing'])) {
            return response()->json(['message' => 'Cannot cancel an order that is already ' . $order->status . '.'], 400);
        }
        
        foreach ($order->items as $item) {
            if ($item->book) {
                $item->book->increment('stock', $item->quantity);
            }
        }
        
        $order->update(['status' => 'cancelled']);
        
        return response()->json([
            'message' => 'Order cancelled successfully',
            'order' => $order->load('items.book', 'user')
        ]);
    }
}
