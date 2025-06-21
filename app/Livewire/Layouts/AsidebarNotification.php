<?php

namespace App\Livewire\Layouts;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AsidebarNotification extends Component
{
    public function render()
    {
        $notifications  = Notification::where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get()
            ->toArray();
        return view('livewire.layouts.asidebar-notification',
        ['notifications' => $notifications])->layout('layouts.seller_layout');
    }
}
