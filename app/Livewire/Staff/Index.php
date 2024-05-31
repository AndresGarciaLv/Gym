<?php

namespace App\Livewire\Staff;

use App\Models\UserMembership;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Obtener el gimnasio del usuario staff autenticado
        $staff = Auth::user();
        $gym = $staff->gyms()->first();

        // Filtrar los registros de las membresías de clientes que pertenecen al gimnasio del staff
        $userMemberships = UserMembership::query()
            ->with(['user', 'gym', 'membership'])
            ->where('id_gym', $gym->id)
            ->whereHas('user', function ($query) {
                $query->whereHas('roles', function ($roleQuery) {
                    $roleQuery->where('name', 'Cliente');
                });
            })
            ->where(function ($query) {
                $query->whereHas('user', function ($userQuery) {
                    $userQuery->where('name', 'LIKE', '%' . $this->query . '%')
                              ->orWhere('email', 'LIKE', '%' . $this->query . '%');
                })
                ->orWhereHas('membership', function ($subQuery) {
                    $subQuery->where('name', 'LIKE', '%' . $this->query . '%');
                })
                ->orWhere('start_date', 'LIKE', '%' . $this->query . '%')
                ->orWhere('end_date', 'LIKE', '%' . $this->query . '%')
                ->orWhere(function ($subQuery) {
                    if (strtolower($this->query) === 'activo') {
                        $subQuery->where('isActive', 1);
                    } elseif (strtolower($this->query) === 'inactivo') {
                        $subQuery->where('isActive', 0);
                    }
                });
            })
            ->paginate(10);

        return view('livewire.staff.index', [
            'userMemberships' => $userMemberships
        ]);
    }
}
