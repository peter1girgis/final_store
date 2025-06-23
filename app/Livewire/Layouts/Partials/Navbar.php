<?php

namespace App\Livewire\Layouts\Partials;

use App\Models\categories;
use App\Models\Notification;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Navbar extends Component
{
    public $search = '';  // بدل query بـ search
    public $results = [];
    public $selectedCategories = [];
    public $notificationData = [
        'user_id' => null,
        'title' => '',
        'message' => '',
        'type' => 'general',
    ];

    public function search_for_products()
    {
        $this->dispatch('search_model_show'); // علشان تظهر المودال
    }
    public function contact()
    {

    $this->notificationData['user_id'] = User::whereName('admin@gmail.com')->first()?->id;
    $this->resetErrorBag();
    $this->dispatch('show-notification_admin-form'); // JS to open modal
 // علشان تظهر المودال
    }
    public function submitAdminNotification()
    {
        $validated = Validator::make($this->notificationData, [
            'title' => 'required|string|max:255',
            'message' => 'nullable|string',
            'type' => 'required|in:order,general,payment,alert,warning',
        ])->validate();

        Notification::create([
            'user_id' => User::whereName('admin@gmail.com')->first()?->id,
            'title' => $validated['title'],
            'message' => $validated['message'],
            'type' => 'order',
            'status' => 'unread',
        ]);

        $this->dispatch('hide-notification_admin-form', ['message' => 'Notification sent successfully']);
        $this->reset('notificationData');
    }

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
