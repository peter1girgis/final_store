<?php

namespace App\Livewire\Admin;

use App\Models\Notification;
use App\Models\seller_requests;
use Livewire\Component;

class SellerRequests extends Component
{
    public $state = [];
    public function show_request(seller_requests $request)
	{
        $this->state = [];
		$this->state  = $request->toArray();

		// $this->showEditModal = false;

		$this->dispatch('show-form_requests');
	}
    public function rejected (){
        $request = seller_requests::findOrFail($this->state['id'])   ;
        $request->update(['status' => 'rejected']);
        Notification::create([
            'user_id' => $request->user_id,
            'title' => 'Seller Request Rejected',
            'body' => 'Your request to become a seller has been rejected by the admin.',
            'status' => 'unread',
            'type' => 'seller_status',
        ]);
        $this->dispatch('form_requests_hide', ['message' => 'Request rejected successfully!']);
        $this->state = [];

    }
    public function approved(){
        $request = seller_requests::findOrFail($this->state['id'])   ;
        $request->update(['status' => 'approved']);
        Notification::create([
            'user_id' => $request->user_id,
            'title' => 'Seller Request Approved',
            'message' => 'Congratulations! Your request to become a seller has been approved.',
            'status' => 'unread',
            'type' => 'seller_status',
        ]);
        $this->dispatch('form_requests_hide', ['message' => 'Request approved successfully!']);
        $this->state = [];

    }
    public function render()
    {
        $requests = seller_requests::with('user')->latest()->paginate();
        return view('livewire.admin.seller-requests',[
            'requests' => $requests ,
        ])->layout('layouts.admin_layout');
    }
}
