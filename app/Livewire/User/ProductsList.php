<?php

namespace App\Livewire\User;

use App\Models\CartItem;
use App\Models\categories;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;


class ProductsList extends Component
{
    public $state = [];
    public $selected_categories = [];
    public $all_categories = [];
    public function addToCart()
    {
        $userId = Auth::id();

        if (!$userId) {
            session()->flash('message', ['type' => 'warning', 'text' => 'Please log in to add products to cart']);
            return;
        }

        $item = CartItem::where('user_id', $userId)
                        ->where('product_id', $this->state['id'])
                        ->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $this->state['id'],
                'quantity' => 1,
            ]);
        }
        session()->flash('message', ['type' => 'success', 'text' => 'Product added to cart']);
    }

    public function view_item(Product $item){
        $this->state = [];
		$this->state  = $item->toArray();
        $this->all_categories = categories::select('id', 'name')->get();
        $this->selected_categories = $item->categories->pluck('id')->toArray();
        $this->state['sub_images'] = json_decode($item->sub_images, true);


		// $this->showEditModal = false;

		$this->dispatch('show_product');
    }


    // #[On('open-seller-request')]
    // public function openForm()
    // {

    //     $this->dispatch('show_form_request_seller');
    // }

    public function render()
    {
        $products = Product::latest()->paginate();

        return view('livewire.user.products-list',
        ['products' => $products ])
        ->layout('layouts.user_layout');
    }
}
