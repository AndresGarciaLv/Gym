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
        $users = User::query()
            ->where('name', 'LIKE', '%' . $this->query . '%')
            ->orWhere('email', 'LIKE', '%' . $this->query . '%');

        // Adjust role search to be more specific
        if (!empty($this->query)) {
            $users = $users->orWhereHas('roles', function ($query) {
                // Adjust the query to exclude 'Super Administrador' when 'Administrador' is searched
                if (strtolower($this->query) === 'administrador') {
                    $query->where('name', 'Administrador');
                } elseif (strtolower($this->query) === 'super administrador') {
                    $query->where('name', 'Super Administrador');
                    
                } elseif (strtolower($this->query) === 'staff') {
                    $query->where('name', 'Staff');
                    
                } 
                elseif (strtolower($this->query) === 'cliente') {
                    $query->where('name', 'Cliente');
                    
                }                     
                 else {
                    $query->where('name', 'LIKE', '%' . $this->query . '%');
                }
            });
        }

        return view('livewire.admin.users-index', [
            'users' => $users->paginate(10)
        ]);
    }
}
