<?php

namespace App\Livewire\User;

use App\Models\MainCategories as ModelsMainCategories;
use Livewire\Component;

class MainCategories extends Component
{
     public $mainCategories;

    public function mount()
    {
        $this->mainCategories = ModelsMainCategories::withCount('categories')->get();
    }
    public function render()
    {
        return view('livewire.user.main-categories')->layout('layouts.user_layout');
    }
}
