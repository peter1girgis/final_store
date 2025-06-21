<?php

namespace App\Livewire\Seller;

use App\Models\Notification;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AddProduct extends Component
{
    use WithFileUploads ;
    use WithPagination ;


    protected $paginationTheme = 'bootstrap';

    
    public $main_image, $sub_images = [], $state = [];
     // Collection of all stores


    public function addNewProduct (){
        $this->reset(['state', 'main_image', 'sub_images']);
        $this->dispatch('addProductModal');
    }
    public function save_changes (){
        $this->validate([
            'state.name' => 'required|string|max:255',
            'state.description' => 'nullable|string',
            'state.price' => 'required|numeric',
            'state.old_price' => 'nullable|numeric',
            'state.stock' => 'required|integer|min:0',
        ]);
        $this->state['store_id'] = 5 ;
        $product = Product::findOrFail($this->state['id']); // تأكد إن id موجود في $state

        $product->update([
            'store_id' => $this->state['store_id'],
            'name' => $this->state['name'],
            'description' => $this->state['description'],
            'price' => $this->state['price'],
            'old_price' => $this->state['old_price'],
            'stock' => $this->state['stock'],
        ]);

        $this->reset(['state', 'main_image', 'sub_images']);
        $this->dispatch('view_product_hide', ['message' => 'Product added successfully!']);
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
        Notification::create([
            'user_id' => auth()->user()->id,
            'title' => 'Product Created',
            'message' => 'Your new product has been successfully added to your store.',
            'status' => 'unread',
            'type' => 'general',
        ]);

        $this->reset(['state', 'main_image', 'sub_images']);
        $this->dispatch('hide-add-product-modal', ['message' => 'Product added successfully!']);
    }

    public function render()
    {
        $products = Product::where('store_id',5)->latest()->paginate(6);
        return view('livewire.seller.add-product',
        ['products' => $products ])
        ->layout('layouts.seller_layout');
    }
}
