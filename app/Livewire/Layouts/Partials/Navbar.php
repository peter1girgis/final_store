<?php

namespace App\Livewire\Layouts\Partials;

use App\Models\categories;
use App\Models\Product;
use Livewire\Component;

class Navbar extends Component
{
    public $search = '';  // بدل query بـ search
    public $results = [];
    public $selectedCategories = [];
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
    public function toggleCategory($categoryId)
{
    if (in_array($categoryId, $this->selectedCategories)) {
        // Remove if already selected
        $this->selectedCategories = array_diff($this->selectedCategories, [$categoryId]);
    } else {
        // Add if not already selected
        $this->selectedCategories[] = $categoryId;
    }
}


    public function render()
    {
        $query = Product::query();

    if ($this->search) {
        $query->where(function ($q) {
            $q->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%');
        });
    }

    if (!empty($this->selectedCategories)) {
        $query->whereHas('categories', function ($q) {
            $q->whereIn('categories.id', $this->selectedCategories);
        });
    }
    $categories = categories::whereHas('products')->get();

    $this->results = $query->get()->toArray();

        return view('livewire.layouts.partials.navbar',['results' => $this->results , 'categories' => $categories])->layout('layouts.admin_layout');
    }
}
