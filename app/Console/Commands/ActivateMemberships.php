<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserMembership;
use Carbon\Carbon;

class ActivateMemberships extends Command
{
    protected $signature = 'memberships:activate';
    protected $description = 'Activate new memberships if the old ones have expired';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        $memberships = UserMembership::where('isActive', false)
            ->where('start_date', '<=', $now)
            ->get();

        foreach ($memberships as $membership) {
            $oldMembership = UserMembership::where('id_user', $membership->id_user)
                ->where('isActive', true)
                ->where('end_date', '<=', $now)
                ->first();

            if ($oldMembership) {
                $oldMembership->update(['isActive' => false, 'is_renewal' => true]);
                $membership->update(['isActive' => true]);
            }
        }

        $this->info('Memberships activated successfully.');
    }
}
