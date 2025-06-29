<?php

namespace App\Livewire\Admin;

use App\Models\Orders;
use App\Models\Product;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ManageOrders extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $selectedOrder;
    public $editedPhone;
    public $editedProducts = [];
    public $editedState;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function viewOrder($orderId)
    {
        $this->selectedOrder = Orders::with('store', 'user')->findOrFail($orderId);
        $this->editedPhone = $this->selectedOrder->user_phone_number;
        $this->editedState = $this->selectedOrder->state_of_order;
        $this->editedProducts = collect(json_decode($this->selectedOrder->products, true));
        $this->dispatch('show_order_modal');
    }

    public function updateOrder()
    {
        $totalQty = collect($this->editedProducts)->sum('quantity');

        $this->selectedOrder->update([
            'user_phone_number' => $this->editedPhone,
            'state_of_order' => $this->editedState,
            'products' => $this->editedProducts->toJson(),
            'total_quantity' => $totalQty, // 🆕 تحديث الإجمالي
        ]);
        $this->dispatch('hide_order_modal');
    }

    public function render()
    {
        $orders = Orders::with(['store', 'user'])
                    ->when($this->search, function ($query) {
                        $query->whereHas('user', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%');
                        });
                    })
                    ->latest()
                    ->paginate(10);

        return view('livewire.admin.manage-orders', [
            'orders' => $orders,
        ])->layout('layouts.admin_layout');
    }
}
