<?php
namespace App\Http\Controllers;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller {
    public function index(Request $request) {
        return response()->json($request->user()->wishlists()->with('book')->get());
    }
    public function toggle(Request $request) {
        $request->validate(['book_id'=>'required|exists:books,id']);
        $item = Wishlist::where('user_id',$request->user()->id)->where('book_id',$request->book_id)->first();
        if ($item) { $item->delete(); return response()->json(['wishlisted'=>false]); }
        Wishlist::create(['user_id'=>$request->user()->id,'book_id'=>$request->book_id]);
        return response()->json(['wishlisted'=>true]);
    }
}
