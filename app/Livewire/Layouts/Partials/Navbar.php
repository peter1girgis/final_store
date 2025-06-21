<?php

namespace App\Livewire\Layouts\Partials;

use App\Models\Product;
use Livewire\Component;

class Navbar extends Component
{
    public $search = '';  // بدل query بـ search
    public $results = [];

    public function search_for_products()
    {
        $this->dispatch('search_model_show'); // علشان تظهر المودال
    }
    // public function updatedSearch()
    // {
    //     $this->results = Product::where('name', 'like', '%' . $this->search . '%')
    //         ->orWhere('description', 'like', '%' . $this->search . '%')
    //         ->get()
    //         ->toArray();

    //     $this->dispatch('search_model_show');
    // }


    public function render()
    {
        $this->results = Product::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->get()
            ->toArray();
        return view('livewire.layouts.partials.navbar',['results' => $this->results])->layout('layouts.admin_layout');
    }
}
