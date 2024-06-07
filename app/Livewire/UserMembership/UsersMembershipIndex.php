<?php

namespace App\Livewire\UserMembership;

use App\Models\UserMembership;
use Livewire\Component;
use Livewire\WithPagination;

class UsersMembershipIndex extends Component
{
    use WithPagination;

    public $query = '';
    public $gymId;
    public $role = '';

    public function mount($gymId)
    {
        $this->gymId = $gymId;
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $userMemberships = UserMembership::query()
            ->with(['user.roles', 'gym', 'membership'])
            ->where('id_gym', $this->gymId)
            ->where('isActive', true)  // Añadir condición para membresías activas
            ->where(function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->where('name', 'LIKE', '%' . $this->query . '%')
                          ->orWhere('email', 'LIKE', '%' . $this->query . '%');

                    // Filtro por rol
                    if ($this->role) {
                        $query->whereHas('roles', function ($roleQuery) {
                            $roleQuery->where('name', $this->role);
                        });
                    }

                    // Búsqueda específica por roles
                    if (!empty($this->query)) {
                        $query->orWhereHas('roles', function ($query) {
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
                })
                ->orWhereHas('gym', function ($query) {
                    $query->where('name', 'LIKE', '%' . $this->query . '%');
                })
                ->orWhereHas('membership', function ($query) {
                    $query->where('name', 'LIKE', '%' . $this->query . '%');
                })
                ->orWhere('start_date', 'LIKE', '%' . $this->query . '%')
                ->orWhere('end_date', 'LIKE', '%' . $this->query . '%')
                ->orWhere(function ($query) {
                    if (strtolower($this->query) === 'activo') {
                        $query->where('isActive', 1);
                    } elseif (strtolower($this->query) === 'inactivo') {
                        $query->where('isActive', 0);
                    }
                });
            })
            ->paginate(10);

        return view('livewire.user-membership.users-membership-index', [
            'userMemberships' => $userMemberships
        ]);
    }
}
