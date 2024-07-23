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
    public $status = ''; // Nueva propiedad para el estado de la membresía

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
            ->where('isActive', true)
            ->where(function ($query) {
                $query->whereHas('user', function ($userQuery) {
                    $userQuery->where('name', 'LIKE', '%' . $this->query . '%')
                              ->orWhere('email', 'LIKE', '%' . $this->query . '%')
                              ->orWhere('code', 'LIKE', '%' . $this->query . '%');

                    if ($this->role) {
                        $userQuery->whereHas('roles', function ($roleQuery) {
                            $roleQuery->where('name', $this->role);
                        });
                    }

                    if (!empty($this->query)) {
                        $userQuery->orWhereHas('roles', function ($roleQuery) {
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
                    }
                })
                ->orWhereHas('gym', function ($gymQuery) {
                    $gymQuery->where('name', 'LIKE', '%' . $this->query . '%');
                })
                ->orWhereHas('membership', function ($membershipQuery) {
                    $membershipQuery->where('name', 'LIKE', '%' . $this->query . '%');
                })
                ->orWhere('start_date', 'LIKE', '%' . $this->query . '%')
                ->orWhere('end_date', 'LIKE', '%' . $this->query . '%')
                ->orWhere(function ($statusQuery) {
                    if (strtolower($this->query) === 'activo') {
                        $statusQuery->where('isActive', 1);
                    } elseif (strtolower($this->query) === 'inactivo') {
                        $statusQuery->where('isActive', 0);
                    }
                });
            })
            ->orderBy('start_date', 'desc') // Ordenar por fecha de inicio de más reciente a más antigua
            ->paginate(10);

        // Filtrar por estado de la membresía
        $filteredMemberships = $userMemberships->getCollection()->filter(function ($membership) {
            return !$this->status || $membership->status === $this->status;
        });

        $userMemberships->setCollection($filteredMemberships);

        return view('livewire.user-membership.users-membership-index', [
            'userMemberships' => $userMemberships
        ]);
    }
}
