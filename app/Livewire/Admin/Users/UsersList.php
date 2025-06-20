<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class UsersList extends Component
{
    public $state = [];

	public $user;

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
		])->validate();

		if(!empty($validatedData['password'])) {
			$validatedData['password'] = Hash::make($validatedData['password']);
		}

		$this->user->update($validatedData);
        $this->dispatch('hide-form', ['message' => 'User updated successfully!']);

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
