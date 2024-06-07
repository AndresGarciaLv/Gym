<?php
namespace App\Livewire\UserMembership;

use App\Models\User;
use App\Models\UserMembership;
use Livewire\Component;

class HistoryIndex extends Component
{
    public $userId;
    public $query = '';
    public $gymId;
    public $activeMemberships;
    public $inactiveMemberships;

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->loadGymId();
        $this->loadMemberships();
    }

    public function loadGymId()
    {
        $user = User::with('gyms')->find($this->userId);
        $this->gymId = $user->gyms->first() ? $user->gyms->first()->id : null;
    }

    public function loadMemberships()
    {
        $this->activeMemberships = UserMembership::with(['gym', 'membership'])
            ->where('id_user', $this->userId)
            ->where('isActive', true)
            ->get();
        
        $this->inactiveMemberships = UserMembership::with(['gym', 'membership'])
            ->where('id_user', $this->userId)
            ->where('isActive', false)
            ->orderBy('end_date', 'desc')
            ->get();
    }

    public function search()
    {
        $this->resetPage();
        $this->loadMemberships();
    }

    public function render()
    {
        $user = User::with('roles')->findOrFail($this->userId);
        return view('livewire.user-membership.history-index', [
            'user' => $user,
            'activeMemberships' => $this->activeMemberships,
            'inactiveMemberships' => $this->inactiveMemberships,
            'gymId' => $this->gymId
        ]);
    }
}

