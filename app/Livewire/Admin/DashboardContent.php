<?php

namespace App\Livewire\Admin;

use App\Models\Orders;
use Livewire\Component;
use App\Models\stores;
use App\Models\seller_requests;
use App\Models\payments;
use App\Models\Product;

class DashboardContent extends Component
{
    public $storesCount;
    public $pendingSellerRequestsCount;
    public $paymentsCount;
    public $waitingOrdersCount ;
    public $deliveredOrdersCount ;
    public $productcount ;
    public $inProcessingOrdersCount ;

    public function mount()
    {
        $this->storesCount = stores::count();
        $this->productcount = Product::count();

        $this->pendingSellerRequestsCount = seller_requests::where('status', 'pending')->count();

        $this->paymentsCount = payments::count();
        $this->waitingOrdersCount = Orders::where('state_of_order','waiting')->count();
        $this->deliveredOrdersCount = Orders::where('state_of_order','Delivered')->count();
        $this->inProcessingOrdersCount = Orders::where('state_of_order','in_processing')->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard-content')->layout('layouts.admin_layout');
    }
}
