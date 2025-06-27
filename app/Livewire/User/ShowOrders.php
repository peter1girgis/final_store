<?php

namespace App\Livewire\User;

use App\Models\Orders;
use Livewire\Component;
use Livewire\WithPagination;

class ShowOrders extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $selectedOrder;
    

    public function viewOrder($orderId)
    {
        $this->selectedOrder = Orders::findOrFail($orderId);

        $this->dispatch('show_order_modal');
    }

    public function render()
    {
        $orders = Orders::with('store')
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->paginate(10);

        return view('livewire.user.show-orders', [
            'orders' => $orders
        ])->layout('layouts.user_layout');
    }
}
