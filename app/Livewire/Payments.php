<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\payments as payment_info;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;

class Payments extends Component
{
    public $payments = [];
    public function exportToPdf()
        {
            $user = Auth::user();

            if ($user->user_state === 'seller' && $user->store) {
                $payments = payment_info::where('store_id', $user->store->id)->latest()->get();
            } else {
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
        return view('livewire.payments')->layout('layouts.user_layout');
    }
}
