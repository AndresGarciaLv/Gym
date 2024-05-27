<?php

namespace App\Livewire\Membership;

use App\Models\Membership;
use Livewire\Component;
use Livewire\WithPagination;

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

        return view('livewire.membership.memberships-index', [
            'memberships' => $memberships->paginate(10)
        ]);
    }
}
