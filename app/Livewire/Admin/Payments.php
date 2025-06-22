<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\payments as payment_info;

class Payments extends Component
{
    public $payments = [];

    public function mount()
    {
        $user = Auth::user();

        if ($user->user_state === 'seller' && $user->store) {
            // عرض المدفوعات الخاصة بالمتجر (البائع)
            $this->payments = payment_info::where('store_id', $user->store->id)->latest()->get();
        } else {
            // عرض المدفوعات الخاصة بالمستخدم (المشتري)
            $this->payments = payment_info::where('user_id', $user->id)->latest()->get();
        }
    }
    public function render()
    {
        return view('livewire.admin.payments')->layout('layouts.admin_layout');
    }
}
