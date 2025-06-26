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

    public function addToCart()
{
    $userId = Auth::id();

    if (!$userId) {
        session()->flash('message', ['type' => 'warning', 'text' => 'Please log in to add products to cart']);
        return;
    }

    // تحميل المنتج الحالي باستخدام الـ ID
    $product = Product::find($this->state['id']);

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

    public function render()
    {
        return view('livewire.user.wishlist-products')->layout('layouts.user_layout');
    }
}
