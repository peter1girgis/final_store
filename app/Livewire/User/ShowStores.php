<?php

namespace App\Livewire\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;
use App\Models\stores as ModelsStores;
use Livewire\Component;

class ShowStores extends Component
{
    public $state = [];

    public $store_products = []; // للمنتجات
    public $store_owner_name = '';
    public $notificationData = [
        'user_id' => null,
        'title' => '',
        'message' => '',
        'type' => 'general',
    ];
    public function show_store (ModelsStores $store){
        $this->state = [];
		$this->state  = $store->toArray();
        $this->store_owner_name = $store->user->name ?? 'Unknown';

        $this->store_products = $store->products()->get()->toArray();
        // dd($this->store_products);
        $this->dispatch('show_store');
    }
    public function send_notification($storeId)
{
    $store = ModelsStores::findOrFail($storeId);
    $this->notificationData['user_id'] = $store->user_id;
    $this->resetErrorBag();
    $this->dispatch('show-notification-form'); // JS to open modal
}

    public function submitNotification()
    {
        $validated = Validator::make($this->notificationData, [
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'nullable|string',
            'type' => 'required|in:seller_status,order,general',
        ])->validate();

        Notification::create([
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],
            'message' => $validated['message'],
            'type' => $validated['type'],
            'status' => 'unread',
        ]);

        $this->dispatch('hide-notification-form', ['message' => 'Notification sent successfully']);
        $this->reset('notificationData');
    }
    public function render()
    {
        $stores = ModelsStores::latest()->paginate();
        return view('livewire.user.show-stores',
        ['stores' => $stores])->layout('layouts.user_layout');
    }
}
