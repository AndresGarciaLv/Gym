<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Route;

class Breadcrumb extends Component
{
    public $items = [];

    public function mount()
    {
        $this->generateBreadcrumb();
    }

    public function generateBreadcrumb()
    {
        $routeName = Route::currentRouteName();
        $routeParameters = Route::current()->parameters();
        $routeParts = explode('.', $routeName);

        // Inicializamos el breadcrumb con el home
        $this->items = [
            ['name' => 'Home', 'url' => route('Dashboard-Adm')],
        ];

        // Definimos los nombres personalizados y jerarquía de rutas
        $names = [
            /*  USERS */
            'Dashboard-Adm' => 'Home',
            'admin.users.index' => 'Usuarios',
            'admin.users.create' => 'Crear Usuario',
            'admin.users.edit' => 'Editar Usuario',
            'admin.users.show' => 'Detalles Usuario',
            'profile.edit' => 'Editar Perfil',

           /*  GYMS */
           'admin.gyms.index' => 'Gimnasios',
           'admin.gyms.create' => 'Crear Gimnasio',
           'admin.gyms.edit' => 'Editar Gimnasio',
           'admin.gyms.users' => 'Usuarios',

           /*  MEMBERSHIPS */
           'admin.memberships.index' => 'Membresias',
           'admin.memberships.create' => 'Crear Membresia',
           'admin.memberships.gyms' => 'Membresias'


        ];

        // Definimos la jerarquía de rutas
        $hierarchy = [
            /*  USERS */
            'admin.users.create' => 'admin.users.index',
            'admin.users.edit' => 'admin.users.index',
            'admin.users.show' => 'admin.users.index',

            /*  GYMS */
            'admin.gyms.users' =>'admin.gyms.index',
            'admin.gyms.create' => 'admin.gyms.index',
            'admin.gyms.edit' => 'admin.gyms.index',
            'admin.memberships.gyms' => 'admin.gyms.index',

            /*  MEMBERSHIPS */
           'admin.memberships.create' => 'admin.memberships.index',
        ];

        $accumulatedRoute = '';
        $visitedRoutes = [];

        foreach ($routeParts as $part) {
            $accumulatedRoute .= ($accumulatedRoute ? '.' : '') . $part;
            if (isset($names[$accumulatedRoute])) {
                $name = $names[$accumulatedRoute];
                try {
                    $url = route($accumulatedRoute, $routeParameters);
                } catch (\Exception $e) {
                    $url = null; // Catch any route generation exceptions
                }

                $this->items[] = [
                    'name' => $name,
                    'url' => $url,
                ];
                $visitedRoutes[] = $accumulatedRoute;
            }

            // Verificar si hay una ruta padre en la jerarquía
            if (isset($hierarchy[$accumulatedRoute]) && !in_array($hierarchy[$accumulatedRoute], $visitedRoutes)) {
                $parentRoute = $hierarchy[$accumulatedRoute];
                if (isset($names[$parentRoute])) {
                    $name = $names[$parentRoute];
                    try {
                        $url = route($parentRoute, $routeParameters);
                    } catch (\Exception $e) {
                        $url = null; // Catch any route generation exceptions
                    }

                    array_splice($this->items, -1, 0, [
                        [
                            'name' => $name,
                            'url' => $url,
                        ]
                    ]);
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.breadcrumb');
    }
}