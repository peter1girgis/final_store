<?php


namespace App\Livewire\Admin;

use App\Models\categories as ModelsCategories;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $state = [];
    public $Category;
    public $showEditModal = false;
    public $CategoryIdBeingRemoved = null;
    public $newImage;

    public function addNew()
    {
        $this->reset(['state', 'newImage']);
        $this->showEditModal = false;
        $this->dispatch('showCategory-form');
    }

    public function createCategory()
    {
        $validated = Validator::make($this->state, [
            'name' => 'required|string|max:255',
        ])->validate();

        if ($this->newImage) {
            $validated['image'] = $this->newImage->store('categories', 'public');
        }

        ModelsCategories::create($validated);

        $this->dispatch('hideCategory-form', ['message' => 'Category added successfully!']);
    }

    public function edit(ModelsCategories $Category)
    {
        $this->showEditModal = true;
        $this->Category = $Category;
        $this->state = $Category->only('name', 'image'); // استخدم only بدلاً من toArray
        $this->newImage = null;
        $this->dispatch('showCategory-form');
    }

    public function updateCategory()
    {
        $validated = Validator::make($this->state, [
            'name' => 'required|string|max:255',
        ])->validate();

        if ($this->newImage) {
            if ($this->Category->image) {
                Storage::disk('public')->delete($this->Category->image);
            }

            $validated['image'] = $this->newImage->store('categories', 'public');
        }

        $this->Category->update($validated);

        $this->dispatch('hideCategory-form', ['message' => 'Category updated successfully!']);
    }

    public function confirmCategoryRemoval($CategoryId)
    {
        $this->CategoryIdBeingRemoved = $CategoryId;
        $this->dispatch('show-deleteCategory-modal');
    }

    public function deleteCategory()
    {
        $Category = ModelsCategories::findOrFail($this->CategoryIdBeingRemoved);

        if ($Category->image) {
            Storage::disk('public')->delete($Category->image);
        }

        $Category->delete();

        $this->dispatch('hide-deleteCategory-modal', ['message' => 'Category deleted successfully!']);
    }

    public function render()
    {
        $Categories = ModelsCategories::latest()->paginate();

        return view('livewire.admin.categories', [
            'categories' => $Categories,
        ])->layout('layouts.admin_layout');
    }
}


