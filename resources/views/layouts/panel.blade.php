<!-- component -->
<!DOCTYPE html>
<html lang="es">

<head>
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="">
    <link rel="icon" href="{{ asset('images/Gym-logo.png') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @vite('resources/css/app.css')
    @vite('resources/js/sidebar.js')
    @vite('resources/css/sidebar.css')
    @vite('resources/css/loader/loader.css')
    <title>@yield('titulo')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




</head>

<body class="text-gray-800 font-inter">
    <!--sidenav-->
    <div class="container-loader" id="loader">
        <div class="loader">
            <div class="circle">
                <div class="dot"></div>
                <div class="outline"></div>
            </div>
            <div class="circle">
                <div class="dot"></div>
                <div class="outline"></div>
            </div>
            <div class="circle">
                <div class="dot"></div>
                <div class="outline"></div>
            </div>
            <div class="circle">
                <div class="dot"></div>
                <div class="outline"></div>
            </div>
        </div>
    </div>
    <section class="flex">
        <div class="relative sidebar fixed left-0 top-0 h-full bg-[#5E0409] p-4 z-50 transition-transform ">
            <div class="">

                @php
                    $user = auth()->user();
                    $roles = $user->getRoleNames();
                @endphp
                @if ($roles->contains('Staff'))
                @php
                    $gym = $user->gyms()->first();
                @endphp
                <a href="/panel-staff" class="flex justify-center items-center border-b border-b-white">
                    @if ($gym && $gym->photo)
                        <img class="w-[80px] mb-2" id="imagen" src="{{asset('storage/' . $gym->photo) }}">
                        <h2 id="gym" class="text-xl text-[#fff] font-bold mb-2">GYM</h2>
                    @else
                        <h2 id="imagen" class="text-xl text-[#fff] font-bold mb-2">{{ $gym ? $gym->name : 'GYM' }}</h2>
                        <h2 id="gym" class="text-xl text-[#fff] font-bold mb-2">GYM</h2>
                    @endif
                </a>
            @else
                <a href="/" class="flex justify-center items-center border-b border-b-white">
                    <img class="w-[80px] mb-2" id="imagen" src="{{ asset('fotos/Gym-logo.png') }}" alt="">
                    <h2 id="gym" class="text-xl text-[#fff] font-bold mb-2">GYM</h2>
                </a>
            @endif


            </div>
            <ul class="mt-4 scroll2 overflow-y-scroll" id="lista-side">
                <!-- ADMIN Section -->
                <li class="mb-1 group">
                    @if (Auth::check())
                        @if (Auth::user()->hasRole('Staff'))
                            <a href="/panel-staff"
                                class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#7F0001] hover:text-gray-100 rounded-md transition-colors">
                                <i class='bx bxs-dashboard mr-3 text-lg'></i>
                                <span class="nav-text text-sm">Dashboard</span>
                            </a>
                <li class="mb-1 group">
                    <a href="{{ route('staffs.create') }}"
                        class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#7F0001] hover:text-gray-100 rounded-md transition-colors">
                        <i class='bx bx-money-withdraw mr-3 text-lg'>+</i>
                        <span class="nav-text text-sm">Nuevo Cliente</span>
                    </a>
                </li>
                <li class="mb-1 group">
                    <a href="{{ route('staffs.clients') }}"
                        class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#7F0001] hover:text-gray-100 rounded-md transition-colors">
                        <i class='bx bxs-user-detail mr-3 text-lg'></i>
                        <span class="nav-text text-sm">Lista de Clientes</span>
                    </a>
                </li>
                <li class="mb-1 group">
                    <a href="{{ route('admin.user-memberships.create', $gym->id) }}"
                        class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#7F0001] hover:text-gray-100 rounded-md transition-colors"
                        title="Asignar membresías a los usuarios que pertenecen a esta sucursal.">
                        <i class='bx bx-calendar-plus mr-3 text-lg'></i>
                        <span class="nav-text text-sm">Asignar Membresía</span>
                    </a>
                </li>
                <li class="mb-1 group">
                    <a href="{{ route('staffs.index') }}"
                        class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#7F0001] hover:text-gray-100 rounded-md transition-colors">
                        <i class='bx bx-list-ul mr-3 text-lg'></i>
                        <span class="nav-text text-sm">Membresías Activas</span>
                    </a>
                </li>
                <li class="mb-1 group">
                    <a href="{{ route('admin.gym-log.index', $gym->id) }}"
                        class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#7F0001] hover:text-gray-100 rounded-md transition-colors"
                        title="Realizar Check-in/Check-out en esta sucursal."
                        target="_blank">
                        <i class='bx bx-barcode-reader mr-3 text-lg'></i>
                        <span class="nav-text text-sm">Check-in/Check-out</span>
                    </a>
                </li>

                </li>




            @elseif (Auth::user()->hasAnyRole('Super Administrador', 'Administrador'))
            @if (Auth::user()->hasAnyRole('Super Administrador'))
            <a href="/dashboard"
            class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#7F0001] hover:text-gray-100 rounded-md transition-colors">
            <i class='bx bxs-dashboard mr-3 text-lg'></i>
            <span class="nav-text text-sm">Dashboard</span>
        </a>
            @endif

            @if (Auth::user()->hasRole('Administrador'))
                <a href="/"
                class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#7F0001] hover:text-gray-100 rounded-md transition-colors">
                <i class='bx bxs-dashboard mr-3 text-lg'></i>
                <span class="nav-text text-sm">Dashboard</span>
            </a>
                @endif
                @endif
                @endif



                @if (Auth::check() && Auth::user()->hasAnyRole(['Staff']))
                @else
                    <li id="group-usuarios" class="mb-1 group relative z-2 transition-all">
                        <a href=""
                            class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#7F0001] sidebar-dropdown-toggle rounded-md transition-colors">
                            <i class='bx bx-sitemap mr-3 text-lg'></i>
                            <span class="nav-text text-sm">Administración</span>
                            <i
                                class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90 transition-transform hidden md:block"></i>
                        </a>
                        <ul class="hidden absolute z-20 left-full top-0 w-48  text-white submenu rounded-md">
                            @if (Auth::check() && Auth::user()->hasAnyRole(['Staff']))
                            @else
                                <li>
                                    <a href="{{ route('admin.users.index') }}"
                                        class=" text-white text-sm flex items-center  p-1 rounded-md">
                                        <i class='bx bxs-user-detail mr-3 text-xl'></i>
                                        <span>Lista de Usuarios</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.users.create') }}"
                                        class=" text-white text-sm flex items-center  p-1 rounded-md">
                                        <i class='bx bx-user-plus  mr-3 text-xl'></i>
                                        <span>Crear Usuario</span>
                                    </a>
                                </li>
                            @endif
                            {{--    <li>
                            <a href="/roles-permisos"
                                class=" text-white text-sm flex items-center hover:bg-[#2F4050] p-1 rounded-md ">
                                <i class='bx bx-lock-open mr-3 text-lg'></i>
                                <span>Roles y Permisos</span>
                            </a>
                        </li> --}}

                        </ul>
                    </li>
                @endif

                @if (Auth::check() && Auth::user()->hasAnyRole(['Staff']))
                @else
                    <li id="group-gyms" class="mb-1 group relative z-2 transition-all">
                        <a href=""
                            class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#7F0001] sidebar-dropdown-toggle rounded-md transition-colors">
                            <i class='bx bx-building-house mr-3 text-lg'></i>
                            <span class="nav-text text-sm">Gimnasios</span>
                            <i
                                class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90 transition-transform hidden md:block"></i>
                        </a>
                        <ul class="hidden absolute z-20 left-full top-0 w-48  text-white submenu rounded-md">
                            @if (Auth::check() && Auth::user()->hasAnyRole(['Staff']))
                            @else
                                <li>
                                    <a href="{{ route('admin.gyms.index') }}"
                                        class=" text-white text-sm flex items-center  p-1 rounded-md">
                                        <i class='bx bx-dumbbell mr-3 text-lg'></i>
                                        <span>Lista de Gimnasios</span>
                                    </a>
                                </li>
                                @if (Auth::user()->hasAnyRole('Super Administrador'))
                                    <li>
                                        <a href="{{ route('admin.gyms.create') }}"
                                            class=" text-white text-sm flex items-center  p-1 rounded-md">
                                            <i class='bx bx-list-plus mr-3 text-lg'></i>
                                            <span>Crear Gimnasio</span>
                                        </a>
                                    </li>
                                @endif
                            @endif
                        </ul>
                    </li>
                @endif

                @if (Auth::check() && Auth::user()->hasAnyRole(['Staff']))
                @else
                    <li id="group-membresias" class="mb-1 group relative z-2 transition-all">
                        <a href=""
                            class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#7F0001] sidebar-dropdown-toggle rounded-md transition-colors">
                            <i class='bx bx-credit-card-front mr-3 text-lg'></i>
                            <span class="nav-text text-sm">Membresias</span>
                            <i
                                class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90 transition-transform hidden md:block"></i>
                        </a>
                        <ul class="hidden absolute z-20 left-full top-0 w-48  text-white submenu rounded-md">
                            @if (Auth::check() && Auth::user()->hasAnyRole(['Staff']))
                            @else
                                <li>
                                    <a href="{{ route('admin.memberships.index') }}"
                                        class=" text-white text-sm flex items-center  p-1 rounded-md">
                                        <i class='bx bx-list-ul mr-3 text-lg'></i>
                                        <span>Lista de Membresias</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.memberships.create') }}"
                                        class=" text-white text-sm flex items-center  p-1 rounded-md">
                                        <i class='bx bx-list-plus mr-3 text-lg'></i>
                                        <span>Crear Membresia</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif



                @if (Auth::user()->hasAnyRole('Staff'))
                @else
                    <span class="text-white font-bold nav-text">SUCURSALES</span>
                @endif

                @if (Auth::check() && !Auth::user()->hasAnyRole(['Staff']))
                    @foreach ($allGyms as $gym)
                        <li id="group-sucursales-{{ $gym->id }}" class="mb-1 group relative z-2 transition-all">
                            <a href="#"
                                class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#7F0001] sidebar-dropdown-toggle rounded-md transition-colors">
                                <img class="w-[20px] mr-3" id="imagen" src="{{ asset('icons/gimnasio.png') }}"
                                    alt="">
                                <span class="nav-text text-sm">{{ $gym->name }}</span>
                                <i
                                    class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90 transition-transform hidden md:block"></i>
                            </a>
                            <ul class="hidden absolute z-20 left-full top-0 w-48 text-white submenu rounded-md">
                                <li>
                                    <a href="{{ route('admin.gyms.users', $gym->id) }}"
                                        class="text-white text-sm flex items-center p-1 rounded-md"
                                        title="Ver todos los usuarios de esta sucursal.">
                                        <i class='bx bx-group mr-3 text-xl'></i>
                                        <span>Ver Usuarios</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.memberships.gyms', $gym->id) }}"
                                        class="text-white text-sm flex items-center hover:bg-[#2F4050] p-1 rounded-md"
                                        title="Ver todas las membresías disponibles en esta sucursal.">
                                        <i class='bx bx-list-ul mr-3 text-xl'></i>
                                        <span>Ver Membresías</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.gyms.user-memberships', $gym->id) }}"
                                        class="text-white text-sm flex items-center hover:bg-[#2F4050] p-1 rounded-md"
                                        title="Ver todas las membresías asignadas a clientes y usuarios de esta sucursal.">
                                        <i class='bx bxs-collection mr-3 text-xl'></i>
                                        <span>Membresías Activas</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.user-memberships.create', $gym->id) }}"
                                        class="text-white text-sm flex items-center hover:bg-[#2F4050] p-1 rounded-md"
                                        title="Asignar membresías a los usuarios que pertenecen a esta sucursal.">
                                        <i class='bx bx-calendar-plus mr-3 text-xl'></i>
                                        <span>Asignar Membresía</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.gym-log.index', $gym->id) }}"
                                        class="text-white text-sm flex items-center hover:bg-[#2F4050] p-1 rounded-md"
                                        title="Realizar Check-in/Check-out en esta sucursal."
                                        target="_blank">
                                        <i class='bx bx-barcode-reader mr-3 text-xl'></i>
                                        <span>Check-in/Check-out</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endforeach
                @endif
            </ul>

            <ul>
                <li class="mt-1">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                  localStorage.clear();
                                                  this.closest('form').submit();"
                            class="flex font-semibold items-center py-1 px-1 text-white hover:bg-[#7F0001] hover:text-gray-100 rounded-md w-full transition-colors">
                            <i class='bx bx-log-out mr-3 text-xl'></i>
                            <span class="nav-text text-sm">Cerrar sesion</span>
                        </a>
                    </form>
                </li>
            </ul>


        </div>

        <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay" id="overlay"></div>
        <!-- end sidenav -->


        <main class="main-content w-full bg-gray-200 h-screen min-h-[500px] overflow-y-scroll transition-all"
            id="main">
            <!-- navbar -->
            <div class="py-2 px-6 bg-[#f8f4f3] flex items-center shadow-md shadow-black/5 sticky top-0 left-0 z-20">

                <button type="button" class="text-lg text-white font-semibold sidebar-toggle">
                    <i class=" bg-gray-gym rounded-md p-2 ri-menu-line"></i>
                </button>
                <livewire:breadcrumb />

                <ul class="ml-auto flex items-center ">
                    <li class="dropdown  hidden md:block">
                        <button type="button"
                            class="dropdown-toggle text-gray-400 mr-4 w-8 h-8 rounded flex items-center justify-center  hover:text-gray-600 relative">
                        </button>
                        <div
                            class="dropdown-menu shadow-md shadow-black/5 z-30 hidden max-w-xs w-full bg-white rounded-md border border-gray-100">
                            <div class="flex items-center px-4 pt-4 border-b border-b-gray-100 notification-tab">


                            </div>

                            {{-- @if ($notification->type === 'App\\Notifications\\ProjectNotification')
                            <p>este</p>

                            @endif --}}


                    <li class="dropdown ml-3">
                        <button type="button" class="dropdown-toggle flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 relative">
                                <div class="p-1 bg-white rounded-full focus:outline-none focus:ring">
                                    @if (auth()->user()->photo)
                                        <img class="w-8 h-8 rounded-full"
                                            src="{{ asset('storage/' . auth()->user()->photo) }}"
                                            alt="Foto de perfil" />
                                    @else
                                        @php
                                            $avatar = 'fotos/avatar.webp';
                                            if (auth()->user()->gender == 'male') {
                                                $avatar = 'fotos/avatar.webp';
                                            } elseif (auth()->user()->gender == 'female') {
                                                $avatar = 'fotos/avatar-female.webp';
                                            } elseif (auth()->user()->gender == 'undefined') {
                                                $avatar = 'fotos/indefinido.webp';
                                            }
                                        @endphp
                                        <!-- Si el usuario no tiene foto de perfil, muestra un icono de usuario predeterminado según su género -->
                                        <img id="preview" class="w-8 h-8 rounded-full"
                                            src="{{ asset($avatar) }}"
                                            alt="Ícono de usuario predeterminado">
                                    @endif

                                    <div
                                        class="connection-status-dot top-0 left-7 absolute w-3 h-3 bg-lime-500 border-2 border-white rounded-full animate-ping">
                                    </div>
                                    <div
                                        class="connection-status-dot top-0 left-7 absolute w-3 h-3 bg-lime-500 border-2 border-white rounded-full">
                                    </div>
                                </div>

                            </div>
                            <div class="p-2 hidden md:block text-left">
                                <h2 class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</h2>
                                @php
                                    $user = auth()->user();
                                    $roles = $user->getRoleNames();
                                @endphp

                                @if ($roles->isNotEmpty())
                                    <p class="text-xs text-gray-500">{{ $roles->first() }}</p>
                                @else
                                    <p class="text-xs text-gray-500">Invitado</p>
                                @endif
                            </div>

                        </button>
                        <ul
                            class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                            <li>
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-[#7F0001] hover:bg-gray-50">Ver
                                    Perfil</a>
                            </li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="">
                                    @csrf
                                    <a href="{{ route('logout') }}" role="menuitem"
                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-[#7F0001] hover:bg-gray-50 cursor-pointer"
                                        onclick="event.preventDefault();
                                                  localStorage.clear();
                                                  this.closest('form').submit();">
                                        Cerrar Sesión
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <main class="relative bg-gradient-to-r from-gray-200 via-red-100 to-gray-300 min-h-screen w-full pt-3">
                @yield('contenido')
            </main>

            <footer class= "bg-gradient-to-r from-gray-200 via-red-100 to-gray-300  p-5 ">
                <div class="w-full px-4 mx-auto text-center mb-5">
                    <div class="text-sm text-blueGray-500 font-semibold py-1">
                        Copyright © <span id="get-current-year">2024</span><a
                            href="https://www.facebook.com/profile.php?id=61558455937047"
                            class="hover:underline text-blueGray-500 hover:text-gray-800" target="_blank"> Erick's GYM
                        </a>
                        <span>by</span>
                        <a href="https://www.firenow.com"
                            class="text-blueGray-500 hover:text-blueGray-800 hover:underline">Firenow Solutions</a>.
                    </div>
                </div>
            </footer>
        </main>

    </section>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="{{ asset('scripts/sidebar.js') }}"></script>
    @yield('scripts')
    @livewireScripts
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            function updateConnectionStatus() {
                const connectionStatusDots = document.querySelectorAll('.connection-status-dot');
                if (navigator.onLine) {
                    connectionStatusDots.forEach(function(dot) {
                        dot.classList.remove('bg-red-500');
                        dot.classList.add('bg-lime-500');
                    });
                } else {
                    connectionStatusDots.forEach(function(dot) {
                        dot.classList.remove('bg-lime-500');
                        dot.classList.add('bg-red-500');
                    });
                }

                console.log('The connection status has changed:', navigator.onLine ? 'Online' : 'Offline');
            }

            window.addEventListener('online', updateConnectionStatus);
            window.addEventListener('offline', updateConnectionStatus);

            // Ejecutar inmediatamente al cargar
            updateConnectionStatus();
        });
    </script>

    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if ($errors->has('inactive'))
            toastr.error("{{ $errors->first('inactive') }}");
        @endif
    </script>
</body>

</html>
