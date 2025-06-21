<?php

namespace App\Livewire\Seller;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddProduct extends Component
{
    use WithFileUploads ;

    public $main_image, $sub_images = [], $state = [];
     // Collection of all stores


    public function addNewProduct (){
        $this->reset(['state', 'main_image', 'sub_images']);
        $this->dispatch('addProductModal');
    }
    public function view_item(Product $item){
        $this->state = [];
		$this->state  = $item->toArray();
        $this->state['sub_images'] = json_decode($item->sub_images, true);


		// $this->showEditModal = false;

		$this->dispatch('show_product');
    }
    public function submitProduct()
    {
        $this->validate([
            'state.name' => 'required|string|max:255',
            'state.description' => 'nullable|string',
            'state.price' => 'required|numeric',
            'state.old_price' => 'nullable|numeric',
            'state.stock' => 'required|integer|min:0',
            'main_image' => 'required|image|max:2048',
            'sub_images.*' => 'image|max:2048'
        ]);



        $this->state['store_id'] = 5 ;
        $mainImagePath = $this->main_image->store('product_images', 'public');
        $subImagePaths = collect($this->sub_images)->map(function ($img) {
            return $img->store('product_sub_images', 'public');
        });


        Product::create([
            'store_id' => $this->state['store_id'] ,
            'name' => $this->state['name'],
            'description' => $this->state['description'],
            'price' => $this->state['price'],
            'old_price' => $this->state['old_price'],
            'stock' => $this->state['stock'],
            'main_image' => $mainImagePath,
            'sub_images' => $subImagePaths->toJson(),
        ]);

        $this->reset(['state', 'main_image', 'sub_images']);
        $this->dispatch('hide-add-product-modal', ['message' => 'Product added successfully!']);
    }

    public function render()
    {
        $products = Product::where('store_id',5)->latest()->paginate();
        return view('livewire.seller.add-product',
        ['products' => $products ])
        ->layout('layouts.seller_layout');
    }
}
