<?php

namespace App\Livewire\Layouts\Partials;

use App\Models\seller_requests;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Aside extends Component
{
    use WithFileUploads;

        // public $store_name, $store_description, $phone, $address, $store_logo;
        public $state = [];

    public function show_form_request (){
		$this->dispatch('open-become-seller');
    }


    public function submitRequest()
    {
        $rules = [
            'state.store_name' => 'required|string|max:255',
            'state.store_description' => 'required|string',
            'state.phone' => 'required|numeric',
            'state.address' => 'required|string',
            'state.store_logo' => 'nullable|image|max:2048',
        ];
        $this->validate($rules);
        seller_requests::create([
            'user_id' => auth()->user()->id , // أو 1 مؤقتًا
            'store_name' => $this->state['store_name'],
            'store_description' => $this->state['store_description'],
            'phone' => $this->state['phone'],
            'address' => $this->state['address'],
            'store_logo' => $this->state['store_logo']
                ? $this->state['store_logo']->store('store_logos', 'public')
                : null,
        ]);

        // حفظ الطلب في قاعدة البيانات

        $this->dispatch('hide-open-become-seller', ['message' => 'Request submitted successfully!']);
        $this->state = [];
    }
    public function render()
    {
        return view('livewire.layouts.partials.aside');
    }
}
