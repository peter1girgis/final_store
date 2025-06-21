<?php

namespace App\Livewire\Admin\Users;

use App\Models\Notification;
use App\Models\stores;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class UsersList extends Component
{
    public $state = [];

	public $user;
    public $notificationData = [
        'user_id' => null,
        'title' => '',
        'message' => '',
        'type' => 'general',
    ];

	public $showEditModal = false;

	public $userIdBeingRemoved = null;

	public function addNew()
	{
		$this->state = [];

		$this->showEditModal = false;

		$this->dispatch('show-form');
	}

	public function createUser()
	{
		$validatedData = Validator::make($this->state, [
			'name' => 'required',
			'email' => 'required|email|unique:users',
			'password' => 'required|confirmed',
            'user_state' => 'required',
		])->validate();

		$validatedData['password'] = Hash::make($validatedData['password']);

		User::create($validatedData);

		// session()->flash('message', 'User added successfully!');
        $this->dispatch('hide-form', ['message' => 'User added successfully!']);
        }

	public function edit(User $user)
	{
		$this->showEditModal = true;

		$this->user = $user;

		$this->state = $user->toArray();

		$this->dispatch('show-form');
	}

	public function updateUser()
	{
		$validatedData = Validator::make($this->state, [
			'name' => 'required',
			'email' => 'required|email|unique:users,email,'.$this->user->id,
			'password' => 'sometimes|confirmed',
            'user_state' => 'required',
		])->validate();

		if(!empty($validatedData['password'])) {
			$validatedData['password'] = Hash::make($validatedData['password']);
		}

		$this->user->update($validatedData);
        $this->dispatch('hide-form', ['message' => 'User updated successfully!']);

	}
    public function send_notification($userId)
{

    $this->notificationData['user_id'] = $userId;
    $this->resetErrorBag();
    $this->dispatch('show-notification-form'); // JS to open modal
}

    public function submitNotification()
    {
        $validated = Validator::make($this->notificationData, [
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'nullable|string',
            'type' => 'required|in:seller_status,order,general',
        ])->validate();

        Notification::create([
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],
            'message' => $validated['message'],
            'type' => $validated['type'],
            'status' => 'unread',
        ]);

        $this->dispatch('hide-notification-form', ['message' => 'Notification sent successfully']);
        $this->reset('notificationData');
    }

	public function confirmUserRemoval($userId)
	{
		$this->userIdBeingRemoved = $userId;
        $this->dispatch('show-delete-modal');
	}

	public function deleteUser()
	{
		$user = User::findOrFail($this->userIdBeingRemoved);

		$user->delete();
        $this->dispatch('hide-delete-modal', ['message' => 'User deleted successfully!']);
	}

    public function render()
    {
    	$users = User::latest()->paginate();

        return view('livewire.admin.users.users-list', [
        	'users' => $users,
        ])->layout('layouts.admin_layout');
    }
}
