<?php

namespace App\Livewire\Admin;

use App\Models\Notification;
use App\Models\seller_requests;
use App\Models\User;
use App\Models\stores;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class SellerRequests extends Component
{
    public $state = [];
    public $store_logo ;
    public function show_request(seller_requests $request)
	{
        $this->state = [];
        $this->store_logo = $request->store_logo ;
        // dd(Storage::disk('public')->exists('store_logos/K79O2GXAGT2tRz8sWVeuvXGkxnt9WGCMmMMeCpYi.jpg'));

		$this->state  = $request->toArray();

		// $this->showEditModal = false;

		$this->dispatch('show-form_requests');
	}
    public function rejected (){
        $request = seller_requests::findOrFail($this->state['id'])   ;
        $request->update(['status' => 'rejected']);

        $store = stores::where('user_id', $request->user_id)->first();
        if ($store) {
            // احذف المنتجات واحدة واحدة علشان ينفذ deleting event
            foreach ($store->products as $product) {
                $product->delete(); // هنا `detach()` في الـ model هيتنفذ
            }

            $store->delete();
        }
        $user = User::where('id',$request->user_id)->first();
        $user->update(['user_state' => 'normal']);

        Notification::create([
            'user_id' => $request->user_id,
            'title' => 'Seller Request Rejected',
            'message' => 'Your request to become a seller has been rejected by the admin.',
            'status' => 'unread',
            'type' => 'alert',
        ]);

        $this->dispatch('form_requests_hide', ['message' => 'Request rejected successfully!']);
        $this->state = [];

    }
    public function approved(){
        $request = seller_requests::findOrFail($this->state['id'])   ;
        $request->update(['status' => 'approved']);

        $user = User::where('id',$request->user_id)->first();
        $user->update(['user_state' => 'seller']);

        stores::create([
            'user_id' => $request->user_id,
            'store_name' => $request->store_name,
            'store_description' => $request->store_description,
            'stripe_account_id' => $request->stripe_account_id,
            'store_logo' => $request->store_logo,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        Notification::create([
            'user_id' => $request->user_id,
            'title' => 'Seller Request Approved',
            'message' => 'Congratulations! Your request to become a seller has been approved.',
            'status' => 'unread',
            'type' => 'general',
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
