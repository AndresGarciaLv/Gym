<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\Features\SupportPagination\PaginationUrl;
use Livewire\WithPagination;

class UsersIndex extends Component
{
    use WithPagination;

    public $query = '';
 
    public function search()
    {
        $this->resetPage();
    }
    public function render()
    {
        return view('livewire.admin.users-index', [
            'users' => User::where('name', 'LIKE', '%'.$this->query.'%')->
            orwhere('email', 'LIKE', '%'.$this->query.'%')->Paginate(10),
        ]);
    }
}
