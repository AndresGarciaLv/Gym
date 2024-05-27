<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
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
            ->where(function($query) {
                $query->where('name', 'LIKE', '%' . $this->query . '%')
                      ->orWhere('email', 'LIKE', '%' . $this->query . '%')
                      ->orWhere('code', 'LIKE', '%' . $this->query . '%');

                        // Filtrar por estado (isActive)
                if (strtolower($this->query) === 'activo') {
                    $query->orWhere('isActive', 1);
                } elseif (strtolower($this->query) === 'inactivo') {
                    $query->orWhere('isActive', 0);
                }
            });



        // Filtrar por rol
        if (!empty($this->query)) {
            $users->orWhereHas('roles', function ($query) {
                if (strtolower($this->query) === 'administrador') {
                    $query->where('name', 'Administrador');
                } elseif (strtolower($this->query) === 'super administrador') {
                    $query->where('name', 'Super Administrador');
                } elseif (strtolower($this->query) === 'staff') {
                    $query->where('name', 'Staff');
                } elseif (strtolower($this->query) === 'cliente') {
                    $query->where('name', 'Cliente');
                } else {
                    $query->where('name', 'LIKE', '%' . $this->query . '%');
                }
            });
        }

      

        // Filtrar por gimnasio
        if (!empty($this->query)) {
            $users->orWhereHas('gyms', function ($query) {
                $query->where('name', 'LIKE', '%' . $this->query . '%');
            });
        }

        return view('livewire.admin.users-index', [
            'users' => $users->paginate(10)
        ]);
    }
}