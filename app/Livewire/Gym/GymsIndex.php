<?php

namespace App\Livewire\Gym;

use App\Models\Gym;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class GymsIndex extends Component
{
    use WithPagination;

    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user(); // Obtener el usuario autenticado

        // Eager load the gyms relationship for the authenticated user
        if ($user && $user->hasRole('Administrador')) {
            $user->load('gyms'); // Eager load gyms relationship
        }

        $gyms = Gym::query()
            ->where(function($query) {
                $query->where('name', 'LIKE', '%' . $this->query . '%')
                      ->orWhere('location', 'LIKE', '%' . $this->query . '%');

                // Filtrar por estado (isActive)
                if (strtolower($this->query) === 'activo') {
                    $query->orWhere('isActive', 1);
                } elseif (strtolower($this->query) === 'inactivo') {
                    $query->orWhere('isActive', 0);
                }
            });

        // Filtrar por gimnasios a los que pertenece el administrador
        if ($user && $user->hasRole('Administrador')) {
            $gymIds = $user->gyms->pluck('id')->toArray(); // Obtener los IDs de los gimnasios del administrador
            $gyms->whereIn('id', $gymIds);
        }

        return view('livewire.gym.gyms-index', [
            'gyms' => $gyms->paginate(10)
        ]);
    }
}
