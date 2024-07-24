<?php
namespace App\Livewire\Notices;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Notice;
use App\Models\Gym;
use Illuminate\Support\Facades\Auth;

class NoticeList extends Component
{
    use WithPagination;

    public $query = '';
    public $gymId = '';
    public $isActive = '';
    public $perPage = 10;

    protected $updatesQueryString = ['query', 'gymId', 'isActive', 'perPage'];

    public function updatingQuery()
    {
        $this->resetPage();
    }

    public function updatingGymId()
    {
        $this->resetPage();
    }

    public function updatingIsActive()
    {
        $this->resetPage();
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = Auth::user();
        $noticesQuery = Notice::query()->with(['gym', 'user']);

        // Filtrar por rol del usuario
        if ($user->hasRole('Super Administrador')) {
            // Ver todos los avisos
        } elseif ($user->hasRole('Administrador') || $user->hasRole('Staff')) {
            // Ver avisos de los gimnasios a los que pertenece el usuario
            $gymIds = $user->gyms->pluck('id')->toArray();
            $noticesQuery->whereIn('id_gym', $gymIds);
        }

        $notices = $noticesQuery
            ->when($this->query, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('title', 'like', '%' . $this->query . '%')
                             ->orWhere('content', 'like', '%' . $this->query . '%')
                             ->orWhereHas('gym', function ($gymQuery) {
                                 $gymQuery->where('name', 'like', '%' . $this->query . '%');
                             })
                             ->orWhereHas('user', function ($userQuery) {
                                 $userQuery->where('name', 'like', '%' . $this->query . '%');
                             });
                });
            })
            ->when($this->gymId, function ($query) {
                $query->where('id_gym', $this->gymId);
            })
            ->when($this->isActive !== '', function ($query) {
                $query->where('isActive', $this->isActive);
            })
            ->paginate($this->perPage);

        $gyms = Gym::all();

        return view('livewire.notices.notice-list', [
            'notices' => $notices,
            'gyms' => $gyms,
        ]);
    }
}
