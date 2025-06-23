<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\stores;
use App\Models\seller_requests;
use App\Models\payments;

class DashboardContent extends Component
{
    public $storesCount;
    public $pendingSellerRequestsCount;
    public $paymentsCount;

    public function mount()
    {
        $this->storesCount = stores::count();

        $this->pendingSellerRequestsCount = seller_requests::where('status', 'pending')->count();

        $this->paymentsCount = payments::count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard-content')->layout('layouts.admin_layout');
    }
}
