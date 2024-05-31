<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Gym;

class GymComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $allGyms  = Gym::all();
        $view->with('allGyms', $allGyms);
    }
}
