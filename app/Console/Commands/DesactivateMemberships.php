<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserMembership;
use Carbon\Carbon;

class DesactivateMemberships extends Command
{
    protected $signature = 'memberships:desactivate';
    protected $description = 'Desactivar membresías vencidas y membresías diarias a las 00:00:00 HRS de todos los días';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();

        // Desactivar membresías vencidas que no han sido renovadas después de 3 días
        $threeDaysAgo = $now->copy()->subDays(3);

        $expiredMemberships = UserMembership::where('isActive', true)
            ->where('is_renewal', false)
            ->where('end_date', '<', $threeDaysAgo)
            ->get();

        foreach ($expiredMemberships as $membership) {
            $membership->update(['isActive' => false]);
        }

        // Desactivar membresías diarias a las 00:00:00 HRS
        $today = $now->copy()->startOfDay();

        $dailyMemberships = UserMembership::where('isActive', true)
            ->whereHas('membership', function ($query) {
                $query->where('duration_type', 'Diaria');
            })
            ->where('end_date', '<', $today)
            ->get();

        foreach ($dailyMemberships as $membership) {
            $membership->update(['isActive' => false]);
        }

        $this->info('Membresías vencidas y membresías diarias desactivadas exitosamente.');
    }
}
