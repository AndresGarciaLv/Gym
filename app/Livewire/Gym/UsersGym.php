<?php

namespace App\Livewire\Gym;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UsersGym extends Component
{
    use WithPagination;

    public $query = '';
    public $gymId; // Propiedad para almacenar el ID del gimnasio

    public function mount($gymId)
    {
        $this->gymId = $gymId; // Asigna el ID del gimnasio a la propiedad
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::query()
            ->whereHas('gyms', function($query) {
                $query->where('gyms.id', $this->gymId); // Filtra por gimnasio
            })
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

                // Añadir el filtrado por roles
                $query->orWhereHas('roles', function ($roleQuery) {
                    // Ajustar la consulta para distinguir entre "Administrador" y "Super Administrador"
                    $roleQuery->where(function ($roleQuery) {
                        if (strtolower($this->query) === 'administrador') {
                            $roleQuery->where('name', 'Administrador');
                        } elseif (strtolower($this->query) === 'super administrador') {
                            $roleQuery->where('name', 'Super Administrador');
                        } elseif (strtolower($this->query) === 'staff') {
                            $roleQuery->where('name', 'Staff');
                        } elseif (strtolower($this->query) === 'cliente') {
                            $roleQuery->where('name', 'Cliente');
                        } else {
                            $roleQuery->where('name', 'LIKE', '%' . $this->query . '%');
                        }
                    });
                });
            });

        return view('livewire.gym.users-gym', [
            'users' => $users->paginate(10)
        ]);
    }
}
