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
            ->where('name', 'LIKE', '%' . $this->query . '%')
            ->orWhere('location', 'LIKE', '%' . $this->query . '%');

        return view('livewire.gym.gyms-index', [
            'gyms' => $gyms->paginate(10)
        ]);

    }
}
