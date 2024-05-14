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
    @vite('resources/css/app.css')
    @vite('resources/js/sidebar.js')
    @vite('resources/css/sidebar.css')
    @vite('resources/css/loader/loader.css')
    <title>@yield('titulo')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
        <div class="relative sidebar fixed left-0 top-0 h-full bg-[#5E0409] p-4 z-50 transition-transform">
            <div class="">
                <a href="/" class="flex justify-center items-center border-b border-b-white">
                    <img class="w-[100px]" id="imagen" src="{{ asset('images/Gym-logo.png') }}" alt="">
                    <h2 id="gym" class="text-xl text-[#fff] font-bold mb-2">GYM</h2>
                </a>
            </div>
            <ul class="mt-4 scroll2 overflow-y-scroll" id="lista-side">
                <!-- ADMIN Section -->
                <li class="mb-1 group">
                    @if (Auth::check())
                    @if (Auth::user()->hasRole('Staff'))
                    <a href="/panel-staff"
                        class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#7F0001] hover:text-gray-100 rounded-md">
                        <i class='bx bxs-dashboard mr-3 text-lg'></i>
                        <span class="nav-text text-sm">Dashboard</span>
                    </a>
                    
                    @elseif (Auth::user()->hasAnyRole('Super Administrador', 'Administrador'))
                    <a href="/"
                        class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#7F0001] hover:text-gray-100 rounded-md">
                        <i class='bx bxs-dashboard mr-3 text-lg'></i>
                        <span class="nav-text text-sm">Dashboard</span>
                    </a>
                    @endif
                    @endif

                </li>


                @if (Auth::check() &&
                Auth::user()->hasAnyRole(['Staff']))
                @else
                <li class="mb-1 group relative z-2">
                    <a href=""
                        class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#7F0001] sidebar-dropdown-toggle rounded-md">
                        <i class='bx bx-building-house mr-3 text-lg'></i>
                        <span class="nav-text text-sm">Administración</span>
                        <i
                            class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90 transition-transform hidden md:block"></i>
                    </a>
                    <ul class="hidden absolute z-20 left-full top-0 w-48  text-white submenu rounded-md">
                        @if (Auth::check() &&
                        Auth::user()->hasAnyRole([
                        'Staff',
                        ]))
                        @else
                        <li>
                            <a href="{{ route('admin.users.index') }}"
                                class=" text-white text-sm flex items-center  p-1 rounded-md">
                                <i class='bx bx-user mr-3 text-lg'></i>
                                <span>Usuarios</span>
                            </a>
                        </li>
                        @endif
                        <li>
                            <a href="/roles-permisos"
                                class=" text-white text-sm flex items-center hover:bg-[#2F4050] p-1 rounded-md ">
                                <i class='bx bx-lock-open mr-3 text-lg'></i>
                                <span>Roles y Permisos</span>
                            </a>
                        </li>

                    </ul>
                </li>
                @endif


                <li class="mb-1 group relative z-2">
                    @if (auth()->user()->hasRole(['Super Administrador', 'Administrador de División']))
                    <a href=""
                        class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#394C5F] sidebar-dropdown-toggle rounded-md">
                        <i class='bx bxs-graduation mr-3 text-lg'></i>
                        <span class="nav-text text-sm">Académico</span>
                        <i
                            class="ri-arrow-right-s-line ml-auto  group-[.selected]:rotate-90 transition-transform  hidden md:block"></i>
                    </a>
                    @endif

                    <ul class="hidden absolute right-2 top-0 w-48 bg-[#394C5F] text-white submenu rounded-md">
                        @if (auth()->user()->hasRole(['Super Administrador', 'Administrador de División']))
                        <li>

                            <a href=""
                                class=" text-white text-sm flex items-center hover:bg-[#2F4050] p-1 rounded-md "><i
                                    class='bx bx-folder-plus mr-3 text-lg'></i><span
                                    class="text-sm">Proyectos</span></a>
                        </li>
                        @endif



                        <li class="">
                            @if (Auth::check() &&
                            Auth::user()->hasAnyRole([
                            'Administrador de División',
                            'Asesor Académico',
                            'Estudiante',
                            'Presidente Académico',
                            'Asistente de Dirección',
                            ]))
                            @else
                            <a href=""
                                class=" text-white text-sm flex items-center hover:bg-[#2F4050] p-1 rounded-md "><i
                                    class='bx bx-buildings mr-3 text-lg'></i><span
                                    class=" text-sm">Divisiones</span></a>

                        </li>
                        @endif
                        @if (Auth::check() && Auth::user()->hasAnyRole(['Presidente Académico', 'Asistente de
                        Dirección', 'Super Administrador']))
                        @else
                        <li class="">
                            <a href=""
                                class="text-white text-sm flex items-center hover:bg-[#2F4050] p-1 rounded-md "><i
                                    class=' bx bxs-school mr-3 text-lg'></i><span class="text-sm">Academia</span></a>
                        </li>
                        <li class="">

                            <a href=""
                                class="text-white text-sm flex items-center hover:bg-[#2F4050] p-1 rounded-md "><i
                                    class=' bx bx-book-open mr-3 text-lg'></i><span class="text-sm">Carreras</span></a>
                        </li>
                        <li class="">

                            <a href=""
                                class="text-white text-sm flex items-center hover:bg-[#2F4050] p-1 rounded-md "><i
                                    class=' bx bx-group mr-3 text-lg'></i><span class="text-sm">Grupos</span></a>
                        </li>
                        @endif
                    </ul>
                </li>


                <!-- EMPRESAS Section -->
                @role(['Super Administrador', 'Administrador de División', 'Asesor Académico'])
                <span class="text-[#fff] nav-text font-bold">EMPRESAS</span>

                <li class="mb-1 group">
                    <a href=""
                        class="flex hover:text-[#d0d3d4] font-semibold items-center py-2 px-4 text-white hover:bg-[#394C5F] hover:text-gray-100 rounded-md">
                        <i class='  bx bx-buildings mr-3 text-lg'></i>
                        <span class="nav-text text-sm">Empresas Afiliadas</span>
                    </a>
                </li>
                @endrole

                @role(['Asistente de Dirección'])
                <!-- RECURSOS Section -->
                <span class="text-gray-400 nav-text font-bold">RECURSOS</span>
                <li class="mb-1 group">
                    <a href="/libros"
                        class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#394C5F] hover:text-gray-100 rounded-md">
                        <i class='bx bx-book mr-3 text-lg'></i>
                        <span class="nav-text text-sm">Libros</span>
                    </a>
                </li>
                @endrole


                <!-- PERSONAL Section -->
                <span class="text-gray-400 font-bold nav-text">PERSONAL</span>
                <li class="mb-1 group">
                    <a href="/admin/notificaciones"
                        class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#7F0001] hover:text-gray-100 rounded-md">
                        <i class='bx bx-bell mr-3 text-lg'></i>
                        <span class="nav-text text-sm">Notificaciones</span>
                    </a>
                </li>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button href="{{ route('logout') }}"
                        class="flex font-semibold items-center py-2 px-4 text-white hover:bg-[#7F0001] hover:text-gray-100 rounded-md w-full">
                        <i class='bx bx-log-out mr-3 text-xl'></i>
                        <span class="nav-text text-sm">Cerrar sesion</span>
                    </button>
                </form>
            </ul>



        </div>
        <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay" id="overlay"></div>
        <!-- end sidenav -->


        <main class="main-content w-full bg-gray-200 h-screen min-h-[500px] overflow-y-scroll transition-all" id="main">
            <!-- navbar -->
            <div class="py-2 px-6 bg-[#f8f4f3] flex items-center shadow-md shadow-black/5 sticky top-0 left-0 z-30">

                <button type="button" class="text-lg text-white font-semibold sidebar-toggle">
                    <i class=" bg-gray-gym rounded-md p-2 ri-menu-line"></i>
                </button>

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
                                    <img class="w-8 h-8 rounded-full" src="{{ asset(auth()->user()->photo) }}" alt="" />
                                    @else
                                    <!-- Si el usuario no tiene foto de perfil, muestra un icono de usuario predeterminado -->
                                    <img id="preview" class="w-8 h-8 rounded-full"
                                        src="{{ asset('fotos/avatar.webp') }}"
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
                                    class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-[#f84525] hover:bg-gray-50">Ver
                                    Perfil</a>
                            </li>
                            <li>
                                <a href=""
                                    class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-[#f84525] hover:bg-gray-50">Configurar
                                    Cuenta</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="">
                                    @csrf
                                    <a href="{{ route('logout') }}" role="menuitem"
                                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-[#f84525] hover:bg-gray-50 cursor-pointer"
                                        onclick="event.preventDefault();
                                  this.closest('form').submit();">
                                        Cerrar Sesión
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <main class="contenido relative">
                @yield('contenido')
            </main>
            <footer>
                <div class="w-full md:w-4/12 px-4 mx-auto text-center mb-5">
                    <div class="text-sm text-blueGray-500 font-semibold py-1">
                      Copyright © <span id="get-current-year">2024</span><a href="https://www.facebook.com/profile.php?id=61558455937047" class="hover:underline text-blueGray-500 hover:text-gray-800" target="_blank"> Erick's GYM </a>
                      <span>by</span>
                      <a href="https://www.firenow.com" class="text-blueGray-500 hover:text-blueGray-800 hover:underline">Firenow Solutions</a>.
                    </div>
                  </div>
            </footer>
        </main>

    </section>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="{{ asset('scripts/sidebar.js') }}"></script>
    <script src="{{ asset('resources/js/divisions.js') }}"></script>
    @yield('scripts')
    <link href="{{ asset('css/projectstyle.css') }}" rel="stylesheet">
    @livewireScripts
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

</body>

</html>