<?php

namespace App\Livewire\User;

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;


class ProductsList extends Component
{
    public $state = [];
    public function view_item(Product $item){
        $this->state = [];
		$this->state  = $item->toArray();
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
