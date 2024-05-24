<?php

namespace App\Livewire\Gym;

use App\Models\Gym;
use Livewire\Component;
use Livewire\WithPagination;

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

        return view('livewire.gym.gyms-index', [
            'gyms' => $gyms->paginate(10)
        ]);
    }
}
