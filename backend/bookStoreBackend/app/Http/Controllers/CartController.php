<?php
namespace App\Http\Controllers;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller {
    public function index(Request $request) {
        $cart = $request->user()->cart()->with('items.book')->first();
        return response()->json($cart);
    }
    public function add(Request $request) {
        $request->validate(['book_id'=>'required|exists:books,id']);
        $cart = $request->user()->cart()->firstOrCreate(['user_id'=>$request->user()->id]);
        $item = $cart->items()->where('book_id',$request->book_id)->first();
        if ($item) { $item->increment('quantity'); } else { $cart->items()->create(['book_id'=>$request->book_id,'quantity'=>1]); }
        return response()->json($cart->load('items.book'));
    }
    public function remove(Request $request, $itemId) {
        $cart = $request->user()->cart;
        CartItem::where('id',$itemId)->where('cart_id',$cart->id)->delete();
        return response()->json($cart->load('items.book'));
    }
    public function clear(Request $request) {
        $request->user()->cart?->items()->delete();
        return response()->json(['message'=>'Cart cleared']);
    }
}
