<?php

namespace App\Livewire\Staff;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Clients extends Component
{
    use WithPagination;

    public $query = '';
    public $sortField = 'name'; // Campo por el cual ordenar
    public $sortDirection = 'asc'; // Dirección del ordenamiento

    public function search()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        // Obtener el gimnasio del usuario staff autenticado con eager loading
        $staff = Auth::user();
        $staff->load('gyms'); // Eager load gyms relationship
        $gym = $staff->gyms->first();

        // Filtrar los usuarios clientes que pertenecen al gimnasio del staff
        $users = User::query()
            ->whereHas('gyms', function ($query) use ($gym) {
                $query->where('gyms.id', $gym->id);
            })
            ->where(function ($query) {
                $query->where('name', 'LIKE', '%' . $this->query . '%')
                    ->orWhere('email', 'LIKE', '%' . $this->query . '%')
                    ->orWhere('code', 'LIKE', '%' . $this->query . '%')
                    ->orWhere('phone_number', 'LIKE', '%' . $this->query . '%')
                    ->orWhere(function ($subQuery) {
                        if (strtolower($this->query) === 'activo') {
                            $subQuery->where('isActive', 1);
                        } elseif (strtolower($this->query) === 'inactivo') {
                            $subQuery->where('isActive', 0);
                        }
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection) // Ordenar por el campo y la dirección seleccionados
            ->paginate(10);

        return view('livewire.staff.clients', [
            'users' => $users,
            'gym' => $gym
        ]);
    }
}
