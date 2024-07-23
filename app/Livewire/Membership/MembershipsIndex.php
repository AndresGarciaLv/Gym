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
    public $perPage = 10;

    // Esto asegura que los cambios en estas propiedades actualicen la URL
    protected $queryString = ['query', 'perPage'];

    public function updatingQuery()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    // Asegúrate de que el método search sea público
    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();

        $memberships = Membership::with('gym')
            ->where(function($query) {
                $query->where('name', 'LIKE', '%' . $this->query . '%')
                      ->orWhere('description', 'LIKE', '%' . $this->query . '%')
                      ->orWhereHas('gym', function($q) {
                          $q->where('name', 'LIKE', '%' . $this->query . '%');
                      });

                if (is_numeric($this->query)) {
                    $query->orWhere('price', $this->query);
                }
            });

        if ($user && $user->hasRole('Administrador')) {
            $user->load('gyms');
            $gymIds = $user->gyms->pluck('id')->toArray();
            $memberships->whereHas('gym', function ($query) use ($gymIds) {
                $query->whereIn('gyms.id', $gymIds);
            });
        }

        return view('livewire.membership.memberships-index', [
            'memberships' => $memberships->paginate($this->perPage)
        ]);
    }
}
