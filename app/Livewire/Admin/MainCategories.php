<?php

namespace App\Livewire\Admin;


use App\Models\MainCategories as AminMainCategories;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class MainCategories extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $state = [];
    public $mainCategory;
    public $showEditModal = false;
    public $mainCategoryIdBeingRemoved = null;
    public $newImage;

    public function addNew()
    {
        $this->reset(['state', 'newImage']);
        $this->showEditModal = false;
        $this->dispatch('showCategory-form');
    }

    public function createMainCategory()
    {
        $validated = Validator::make($this->state, [
            'name' => 'required|string|max:255',
        ])->validate();

        if ($this->newImage) {
            $validated['image'] = $this->newImage->store('main_categories', 'public');
        }

        AminMainCategories::create($validated);

        $this->dispatch('hideCategory-form', ['message' => 'Main Category added successfully!']);
    }

    public function edit(AminMainCategories $mainCategory)
    {
        $this->showEditModal = true;
        $this->mainCategory = $mainCategory;
        $this->state = $mainCategory->only('name', 'image');
        $this->newImage = null;
        $this->dispatch('showCategory-form');
    }

    public function updateMainCategory()
    {
        $validated = Validator::make($this->state, [
            'name' => 'required|string|max:255',
        ])->validate();

        if ($this->newImage) {
            if ($this->mainCategory->image) {
                Storage::disk('public')->delete($this->mainCategory->image);
            }

            $validated['image'] = $this->newImage->store('main_categories', 'public');
        }

        $this->mainCategory->update($validated);

        $this->dispatch('hideCategory-form', ['message' => 'Main Category updated successfully!']);
    }

    public function confirmMainCategoryRemoval($mainCategoryId)
    {
        $this->mainCategoryIdBeingRemoved = $mainCategoryId;
        $this->dispatch('show-deleteCategory-modal');
    }

    public function deleteMainCategory()
    {
        $mainCategory = AminMainCategories::findOrFail($this->mainCategoryIdBeingRemoved);

        if ($mainCategory->image) {
            Storage::disk('public')->delete($mainCategory->image);
        }

        $mainCategory->delete();

        $this->dispatch('hide-deleteCategory-modal', ['message' => 'Main Category deleted successfully!']);
    }

    public function render()
    {
        $mainCategories = AminMainCategories::latest()->paginate();

        return view('livewire.admin.main-categories', [
            'mainCategories' => $mainCategories,
        ])->layout('layouts.admin_layout');
    }
}
