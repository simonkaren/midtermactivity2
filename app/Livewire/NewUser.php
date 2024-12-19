<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash; 
use Livewire\Component;
use Livewire\WithPagination;

class NewUser extends Component
{
    use WithPagination;

    public $name;
    public $email;
    public $password;


    public $isEditModalOpen = false;
    public $editUserId;
    public $editName;
    public $editEmail;


    public $isDeleteModalOpen= false;
    public $deleteUserId;

    protected $rules = [
        'name' => 'required|string|max:50',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
    ];


 public function editUser($userId)
{
    $this->editUserId = $userId;
    $user = User::find($userId);
    $this->editName = $user->name;
    $this->editEmail = $user->email;
    $this->isEditModalOpen = true;
}

public function closeEditModal()
{
    $this->isEditModalOpen = false;
    $this->resetEditForm();
}

public function updateUser()
{
    $this->validate([
        'editName' => 'required|min:2',
        'editEmail' => 'required|email|unique:users,email,' . $this->editUserId,
    ]);

    $user = User::find($this->editUserId);
    $user->update([
        'name' => $this->editName,
        'email' => $this->editEmail,
]);

$this->closeEditModal();
session()->flash('message', 'User updated successfully');
}


public function confirmDelete($userId)
{
    $this->deleteUserId = $userId;
    $this->isDeleteModalOpen = true;
}

public function deleteUser()
{
    // Check if deleteUserId is set
    if (!$this->deleteUserId) {
        session()->flash('error', 'No user ID provided for deletion.');
        return;
    }

    // Find the user and check if it exists
    $user = User::find($this->deleteUserId);

    if ($user) {
        $user->delete();
        session()->flash('message', 'User deleted successfully');
    } else {
        session()->flash('error', 'User not found or already deleted.');
    }

    // Close the delete modal and reset the ID
    $this->closeDeleteModal();
    $this->deleteUserId = null;
}

public function closeDeleteModal()
{
    $this->isDeleteModalOpen = false;
}


private function resetEditForm()
{
    $this->editUserId = null;
    $this->editName = '';
    $this->editEmail = '';
}


    public function submit()
    {
        sleep(2);
        
        // Validate the input data
        $this->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        // Create a new user with hashed password
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password), // Hash the password
        ]);

        // Reset the form fields after creating the user
        $this->reset(['name', 'email', 'password']);

        // Flash a success message
        session()->flash('message', 'User successfully created!');
    }

    public function render()
    {
        return view('livewire.new-user',
    [
        'users'=> User::paginate(5),
    ]);
        
    }
}