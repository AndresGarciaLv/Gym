<?php
namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
        $userRole = Auth::user()->getRoleNames()->first();

        $homeRoute = $this->getHomeRouteByRole($userRole);

        $this->items = [
            ['name' => 'Home', 'url' => route($homeRoute)],
        ];

        $names = [
            'Dashboard-Adm' => ['name' => 'Dashboard', 'roles' => ['Administrador']],
            'Dashboard-SupAdm' => ['name' => 'Dashboard', 'roles' => ['Super Administrador']],
            'Dashboard-St' => ['name' => 'Dashboard', 'roles' => ['Staff']],

            //USUARIOS
            'admin.users.index' => ['name' => 'Lista de Usuarios', 'roles' => ['Administrador', 'Super Administrador']],
            'admin.users.create' => ['name' => 'Crear Usuario', 'roles' => ['Administrador', 'Super Administrador']],
            'admin.users.edit' => ['name' => 'Editar Usuario', 'roles' => ['Administrador', 'Super Administrador', 'Staff']],
            'admin.user-memberships.history' => ['name' => 'Historial de Membresías', 'roles' => ['Administrador', 'Super Administrador', 'Staff']],


            //GIMNASIOS
            'admin.gyms.index' => ['name' => 'Lista de Gimnasios', 'roles' => ['Administrador', 'Super Administrador']],
            'admin.gyms.users' => ['name' => 'Usuarios', 'roles' => ['Administrador', 'Super Administrador']],
            'admin.gyms.create' => ['name' => 'Crear Gimnasio', 'roles' => ['Super Administrador']],
            'admin.gyms.edit' => ['name' => 'Editar Gimnasio', 'roles' => ['Administrador', 'Super Administrador']],
            'admin.memberships.gyms' => ['name' => 'Membresías', 'roles' => ['Administrador', 'Super Administrador']],

            //MEMBRESIAS
            'admin.memberships.index' => ['name' => 'Lista de Membresías', 'roles' => ['Administrador', 'Super Administrador']],
            'admin.memberships.create' => ['name' => 'Crear Membresía', 'roles' => ['Administrador', 'Super Administrador']],
            'admin.memberships.edit' => ['name' => 'Editar Membresía', 'roles' => ['Administrador', 'Super Administrador']],
            'admin.gyms.user-memberships' => ['name' => 'Membresías Activas', 'roles' => ['Administrador', 'Super Administrador']],
            'admin.user-memberships.edit' => ['name' => 'Editar Membresía Activa', 'roles' => ['Administrador', 'Super Administrador', 'Staff']],
            'admin.user-memberships.create' => ['name' => 'Asignar Membresía', 'roles' => ['Administrador', 'Super Administrador', 'Staff']],

            //STAFF
            'staffs.clients' => ['name' => 'Lista de Clientes', 'roles' => ['Staff']],
            'staffs.index' => ['name' => 'Membresías Activas', 'roles' => ['Staff']],
            'staffs.create' => ['name' => 'Nuevo Cliente', 'roles' => ['Staff']],


        ];

        $hierarchy = [
            'Administrador' => [
                'admin.users.create' => 'admin.users.index',
                'admin.users.show' => 'admin.users.index',
                'admin.users.edit' => 'admin.users.index',
                'admin.user-memberships.history' => 'admin.users.index',

                'admin.gyms.users' =>'admin.gyms.index',
                'admin.memberships.gyms' =>'admin.gyms.index',
                'admin.gyms.edit' => 'admin.gyms.index',

                'admin.memberships.create' => 'admin.memberships.index',
                'admin.memberships.edit' => 'admin.memberships.index',

                'admin.user-memberships.edit' => 'admin.gyms.user-memberships',
            ],
            'Staff' => [
                'admin.users.edit' => 'staffs.clients',
                'admin.user-memberships.history' => 'staffs.clients',
                'admin.user-memberships.edit' => 'staffs.index',
            ],
            'Super Administrador' => [
                'admin.users.create' => 'admin.users.index',
                'admin.users.show' => 'admin.users.index',
                'admin.users.edit' => 'admin.users.index',
                'admin.user-memberships.history' => 'admin.users.index',

                'admin.gyms.users' =>'admin.gyms.index',
                'admin.gyms.create' => 'admin.gyms.index',
                'admin.gyms.edit' => 'admin.gyms.index',
                'admin.memberships.gyms' =>'admin.gyms.index',


                'admin.memberships.gyms' => 'admin.gyms.index',
                'admin.memberships.create' => 'admin.memberships.index',
                'admin.memberships.edit' => 'admin.memberships.index',
                'admin.user-memberships.edit' => 'admin.gyms.user-memberships',
            ],
        ];

        $accumulatedRoute = '';
        $visitedRoutes = [];

        foreach ($routeParts as $part) {
            $accumulatedRoute .= ($accumulatedRoute ? '.' : '') . $part;
            if (isset($names[$accumulatedRoute])) {
                $route = $names[$accumulatedRoute];
                if (in_array($userRole, $route['roles'])) {
                    $name = $route['name'];
                    try {
                        $url = route($accumulatedRoute, $routeParameters);
                    } catch (\Exception $e) {
                        $url = null;
                    }

                    $this->items[] = [
                        'name' => $name,
                        'url' => $url,
                    ];
                    $visitedRoutes[] = $accumulatedRoute;
                }
            }

            if (isset($hierarchy[$userRole][$accumulatedRoute]) && !in_array($hierarchy[$userRole][$accumulatedRoute], $visitedRoutes)) {
                $parentRoute = $hierarchy[$userRole][$accumulatedRoute];
                if (isset($names[$parentRoute])) {
                    $route = $names[$parentRoute];
                    if (in_array($userRole, $route['roles'])) {
                        $name = $route['name'];
                        try {
                            $url = route($parentRoute, $routeParameters);
                        } catch (\Exception $e) {
                            $url = null;
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
    }

    private function getHomeRouteByRole($role)
    {
        switch ($role) {
            case 'Super Administrador':
                return 'Dashboard-SupAdm';
            case 'Administrador':
                return 'Dashboard-Adm';
            case 'Staff':
                return 'Dashboard-St';
            default:
                return 'Dashboard-Adm';
        }
    }

    public function render()
    {
        return view('livewire.breadcrumb');
    }
}
