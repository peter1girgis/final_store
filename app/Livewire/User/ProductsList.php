<?php

namespace App\Livewire\User;

use App\Models\Product;
use Livewire\Component;


class ProductsList extends Component
{
    public $state = [];
    public function view_item(Product $item){
        $this->state = [];
		$this->state  = $item->toArray();

		// $this->showEditModal = false;

		$this->dispatch('show_product');
    }
    public function render()
    {
        $products = Product::latest()->paginate();
        return view('livewire.user.products-list',
        ['products' => $products ])
        ->layout('layouts.user_layout');
    }
}
