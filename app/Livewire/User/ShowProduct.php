<?php

namespace App\Livewire\User;

use App\Models\comments;
use App\Models\evaluations;
use App\Models\Product;
use Livewire\Component;
use App\Models\CartItem;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;



class ShowProduct extends Component
{
    public $product;
    public $comment;
    public $inWishlist = false;


    public $rating = 0 ;
    public function addToCart()
{
    $userId = Auth::id();

    if (!$userId) {
        session()->flash('message', ['type' => 'warning', 'text' => 'Please log in to add products to cart']);
        return;
    }

    // تحميل المنتج الحالي باستخدام الـ ID
    $product = Product::find($this->product->id);

    if (!$product) {
        $this->dispatch('return_operation_stopped');
        return;
    }

    $item = CartItem::where('user_id', $userId)
                    ->where('product_id', $product->id)
                    ->first();

    if ($item) {
        // التحقق إذا كانت الكمية الجديدة لا تتجاوز المخزون
        if ($item->quantity + 1 > $product->stock) {
            $this->dispatch('return_operation_stopped');
            return;
        }

        $item->increment('quantity');
    } else {
        // التحقق إذا كان هناك مخزون كافي قبل الإضافة
        if ($product->stock < 1) {
            $this->dispatch('return_operation_stopped');
            return;
        }

        CartItem::create([
            'user_id' => $userId,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    $this->dispatch('return_success');
}
    public function addToWishlist($productId)
{
    $wishlistItem = Wishlist::where('user_id', Auth::id())
        ->where('product_id', $productId)
        ->first();

    if ($wishlistItem) {
        $wishlistItem->delete();
        $this->inWishlist = false;
        session()->flash('message', 'Product removed from wishlist!');
    } else {
        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
        ]);
        $this->inWishlist = true;

        $this->dispatch('return_success');
    }
}




    public function submitRating($value)
    {
        $this->rating = $value;

        evaluations::updateOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $this->product->id],
            ['rating' => $value]
        );

        $this->dispatch('return_success');
    }

    public function submitComment()
    {
        $this->validate([
            'comment' => 'required|string|min:3',
        ]);

        comments::create([
            'user_id' => auth()->id(),
            'product_id' => $this->product->id,
            'comment' => $this->comment,
        ]);

        $this->comment = '';
        $this->product->load('comments');

        $this->dispatch('return_success');
    }
    public function mount($id)
    {
        $this->product = Product::with('categories', 'store' , 'comments.user')->findOrFail($id);
        $this->rating = auth()->user()
        ->evaluations()
        ->where('product_id', $id)
        ->value('rating') ?? 0;
        $this->inWishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $this->product->id)
            ->exists();
        $this->product->sub_images = is_string($this->product->sub_images)
            ? json_decode($this->product->sub_images, true)
            : $this->product->sub_images;

    }
    public function render()
    {
        return view('livewire.user.show-product')->layout('layouts.user_layout');
    }
}
