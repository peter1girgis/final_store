<?php



namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class WishlistProducts extends Component
{
    public $wishlistProducts = [];

    public function mount()
    {
        $this->loadWishlist();
    }

    public function loadWishlist()
    {
        $this->wishlistProducts = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->get()
            ->pluck('product')
            ->filter(); // in case product was deleted

    }

    public function toggleWishlist($productId)
    {
        $item = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($item) {
            $item->delete();
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
            ]);
        }

        $this->loadWishlist();
        $this->dispatch('return_success');
    }

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

    public function render()
    {
        return view('livewire.user.wishlist-products')->layout('layouts.user_layout');
    }
}
