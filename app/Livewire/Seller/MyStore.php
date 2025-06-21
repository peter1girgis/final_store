<?php

namespace App\Livewire\Seller;

use App\Models\Notification;
use App\Models\stores;
use Livewire\Component;

class MyStore extends Component
{
    public $state = [];

    public $store_products = [];
    public function save_changes (){
        $store = stores::where('user_id', auth()->user()->id)->firstOrFail();

        $store->update([
            'store_name' =>  $this->state['store_name'],
            'store_description' =>  $this->state['store_description'],
            'store_logo' =>  $this->state['store_logo'],
            'phone' =>  $this->state['phone'],
            'address' =>  $this->state['address'],
        ]);

        Notification::create([
            'user_id' => auth()->user()->id,
            'title' => 'Store updated successfully',
            'message' => 'Congratulations! Your store has been updated successfully.',
            'status' => 'unread',
            'type' => 'seller_status',
        ]);
        $this->dispatch('store_updated', ['message' => 'Request approved successfully!']);
        $this->state = [];
    }
    public function render()
    {
        $this->state = [];
		$this->state  = auth()->user()->store->toArray();
        $this->store_products = auth()->user()->store->products()->get()->toArray();
        $product_count = auth()->user()->store->products->count();
        return view('livewire.seller.my-store',['product_count' => $product_count])->layout('layouts.seller_layout');
    }
}
