<?php

namespace Database\Seeders;

use App\Models\Gym;
use App\Models\Membership;
use App\Models\User;
use App\Models\UserMembership;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserMembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       /*  $users = User::all();
        $gyms = Gym::all();
        $memberships = Membership::all();

        foreach ($users as $user) {
            foreach ($gyms as $gym) {
                $membership = $memberships->where('id_gym', $gym->id)->random();

                UserMembership::create([
                    'id_user' => $user->id,
                    'id_gym' => $gym->id,
                    'membership_id' => $membership->id,
                    'start_date' => Carbon::now(),
                    'end_date' => Carbon::now()->addDays($membership->duration_days),
                    'is_active' => true,
                ]);
            }
        } */
    }
}
