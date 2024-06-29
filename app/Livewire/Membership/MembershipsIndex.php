<?php

namespace App\Livewire\Membership;

use App\Models\Membership;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class MembershipsIndex extends Component
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

        $memberships = Membership::query()
            ->where(function($query) {
                $query->where('name', 'LIKE', '%' . $this->query . '%')
                      ->orWhere('description', 'LIKE', '%' . $this->query . '%')
                      ->orWhereHas('gym', function($q) {
                          $q->where('name', 'LIKE', '%' . $this->query . '%');
                      });

                // Filtrar por precio (si el query es un número)
                if (is_numeric($this->query)) {
                    $query->orWhere('price', $this->query);
                }
            });

        // Filtrar por gimnasios a los que pertenece el administrador
        if ($user && $user->hasRole('Administrador')) {
            $gymIds = $user->gyms->pluck('id')->toArray(); // Obtener los IDs de los gimnasios del administrador
            $memberships->whereHas('gym', function ($query) use ($gymIds) {
                $query->whereIn('gyms.id', $gymIds);
            });
        }

        return view('livewire.membership.memberships-index', [
            'memberships' => $memberships->paginate(10)
        ]);
    }
}
