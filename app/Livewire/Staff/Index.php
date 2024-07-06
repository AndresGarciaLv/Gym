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
    public $status = ''; // Nueva propiedad para el estado de la membresía

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Obtener el gimnasio del usuario staff autenticado
        $staff = Auth::user();
        $staff->load('gyms'); // Eager load gyms relationship
        $gym = $staff->gyms()->first();

        // Filtrar los registros de las membresías que pertenecen al gimnasio del staff
        $userMemberships = UserMembership::query()
            ->with(['user', 'gym', 'membership'])
            ->where('id_gym', $gym->id)
            ->where('isActive', true)
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
                ->orWhere(function ($query) {
                    if (strtolower($this->query) === 'activo') {
                        $query->where('isActive', 1);
                    } elseif (strtolower($this->query) === 'inactivo') {
                        $query->where('isActive', 0);
                    }
                });
            })
            ->paginate(10);

        // Filtrar por estado de la membresía
        $filteredMemberships = $userMemberships->getCollection()->filter(function ($membership) {
            return !$this->status || $membership->status === $this->status;
        });
        $userMemberships->setCollection($filteredMemberships);

        return view('livewire.staff.index', [
            'userMemberships' => $userMemberships
        ]);
    }
}
