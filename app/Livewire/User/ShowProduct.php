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
    public function addToCart($productId)
    {
        CartItem::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $productId,
            ],
            [
                'quantity' => \DB::raw('quantity + 1'),
            ]
        );

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
        $this->product->sub_images = json_decode($this->product->sub_images, true);
    }
    public function render()
    {
        return view('livewire.user.show-product')->layout('layouts.user_layout');
    }
}
