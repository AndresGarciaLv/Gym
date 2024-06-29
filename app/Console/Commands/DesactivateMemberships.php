<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserMembership;
use Carbon\Carbon;

class DesactivateMemberships extends Command
{
    protected $signature = 'memberships:desactivate';
    protected $description = 'Desactivar membresías vencidas que no han sido renovadas después de 3 días';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        $threeDaysAgo = $now->subDays(3);

        $memberships = UserMembership::where('isActive', true)
            ->where('is_renewal', false)
            ->where('end_date', '<', $threeDaysAgo)
            ->get();

        foreach ($memberships as $membership) {
            $membership->update(['isActive' => false]);
        }

        $this->info('Membresías vencidas desactivadas exitosamente.');
    }
}
