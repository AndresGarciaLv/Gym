<?php

namespace App\Livewire\Dashboard\SuperAdmin;

use App\Models\User;
use App\Models\Membership;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NewUsers extends Component
{
    use WithPagination;

    public $query = '';
    public $membershipFilter = ''; // Nuevo campo para el filtro de membresías

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user(); // Obtener el usuario autenticado
        $startDate = Carbon::now()->subDays(60); // Fecha de inicio hace 30 días
        $endDate = Carbon::now(); // Fecha de hoy

        $users = User::with(['roles', 'gyms', 'creator', 'userMemberships' => function($query) {
            $query->where('isActive', true)->with('membership');
        }]) // Eager load roles, gyms, creator, and active memberships
        ->whereBetween('created_at', [$startDate, $endDate]) // Filtrar por fecha de creación
        ->where(function($query) {
            $query->where('name', 'LIKE', '%' . $this->query . '%')
                  ->orWhere('email', 'LIKE', '%' . $this->query . '%')
                  ->orWhere('code', 'LIKE', '%' . $this->query . '%')
                  ->orWhereHas('userMemberships.membership', function ($query) {
                      $query->where('name', 'LIKE', '%' . $this->query . '%');
                  });

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

        // Filtrar por membresía por nombre
        if (!empty($this->membershipFilter)) {
            $users->whereHas('userMemberships', function ($query) {
                $query->where('isActive', true)->whereHas('membership', function ($query) {
                    $query->where('name', 'LIKE', '%' . $this->membershipFilter . '%');
                });
            });
        }

        // Filtrar por gimnasios a los que pertenece el administrador
        if ($user && $user->hasRole('Administrador')) {
            $gymIds = $user->gyms->pluck('id')->toArray(); // Obtener los IDs de los gimnasios del administrador
            $users->whereHas('gyms', function ($query) use ($gymIds) {
                $query->whereIn('gyms.id', $gymIds);
            });
        }

        // Ordenar por fecha de creación, desde la más reciente hasta la más antigua
        $users->orderBy('created_at', 'desc');

        return view('livewire.dashboard.super-admin.new-users', [
            'users' => $users->paginate(10),
            'memberships' => Membership::all() // Pasar todas las membresías a la vista
        ]);
    }
}
