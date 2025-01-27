<?php

namespace App\Livewire\Membership;

use App\Models\Membership;
use Livewire\Component;
use Livewire\WithPagination;

class GymsMembership extends Component
{
    use WithPagination;

    public $gymId;
    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $memberships = Membership::where('id_gym', $this->gymId)
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

        return view('livewire.membership.gyms-membership', [
            'memberships' => $memberships->paginate(10)
        ]);
    }
}
