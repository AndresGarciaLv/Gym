<?php

namespace App\Livewire\UserMembership;

use App\Models\UserMembership;
use Livewire\Component;
use Livewire\WithPagination;

class UsersMembershipIndex extends Component
{
    use WithPagination;

    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $userMemberships = UserMembership::query()
            ->with(['user', 'gym', 'membership'])
            ->whereHas('user', function ($query) {
                $query->where('name', 'LIKE', '%' . $this->query . '%')
                      ->orWhere('email', 'LIKE', '%' . $this->query . '%');
            })
            ->orWhereHas('gym', function ($query) {
                $query->where('name', 'LIKE', '%' . $this->query . '%');
            })
            ->orWhereHas('membership', function ($query) {
                $query->where('name', 'LIKE', '%' . $this->query . '%');
            })
            ->orWhere('start_date', 'LIKE', '%' . $this->query . '%')
            ->orWhere('end_date', 'LIKE', '%' . $this->query . '%')
            ->orWhere(function ($query) {
                if (strtolower($this->query) === 'activo') {
                    $query->where('isActive', 1);
                } elseif (strtolower($this->query) === 'inactivo') {
                    $query->where('isActive', 0);
                }
            })
            ->paginate(10);

        return view('livewire.user-membership.users-membership-index', [
            'userMemberships' => $userMemberships
        ]);
    }
}
