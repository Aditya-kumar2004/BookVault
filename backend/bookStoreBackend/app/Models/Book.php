<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Book extends Model {
    protected $fillable = ['title','author','description','price','original_price','cover_image','genre','isbn','rating','pages','publisher','stock','is_featured','is_deal'];
    public function cartItems() { return $this->hasMany(CartItem::class); }
    public function wishlists() { return $this->hasMany(Wishlist::class); }
}
