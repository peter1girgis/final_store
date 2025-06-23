<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\payments as payment_info;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class Payments extends Component
{
    public $payments = [];


public function exportToPdf()
        {
            $user = Auth::user();

            if ($user->user_state === 'admin') {
    // لو أدمن، هيرجع كل المدفوعات بدون فلترة
                $payments = payment_info::latest()->get();
            } elseif ($user->user_state === 'seller' && $user->store) {
                // لو بائع، هيرجع المدفوعات الخاصة بمتجره
                $payments = payment_info::where('store_id', $user->store->id)->latest()->get();
            } else {
                // لو مشتري، هيرجع المدفوعات الخاصة به فقط
                $payments = payment_info::where('user_id', $user->id)->latest()->get();
                }


            $pdf = Pdf::loadView('complex-table', ['payments' => $payments]);

            return response()->streamDownload(
                fn () => print($pdf->output()),
                'payments_report.pdf'
            );
        }
    public function mount()
    {
        $user = Auth::user();

        if ($user->user_state === 'admin') {
    // لو أدمن، هيرجع كل المدفوعات بدون فلترة
        $this->payments = payment_info::latest()->get();
    } elseif ($user->user_state === 'seller' && $user->store) {
        // لو بائع، هيرجع المدفوعات الخاصة بمتجره
        $this->payments = payment_info::where('store_id', $user->store->id)->latest()->get();
    } else {
        // لو مشتري، هيرجع المدفوعات الخاصة به فقط
        $this->payments = payment_info::where('user_id', $user->id)->latest()->get();
        }
    }
    public function render()
    {
        return view('livewire.admin.payments')->layout('layouts.admin_layout');
    }
}
