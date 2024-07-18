
@php
    $authenticatedUserId = auth()->user()->id;
    $authenticatedUserRole = auth()->user()->roles->pluck('name')->first();
@endphp
<div class="mt-4">
    <form wire:submit.prevent="search">
        <div class="flex items-end align-middle mb-5">
            <!-- BOTÓN QUE DIRIGE AL CRUD -->
            <a href="{{ route('admin.users.create') }}"
                class="relative bg-[#34AD3C] text-white px-4 py-2 ml-5 mr-6 rounded hover:bg-[#3D7A41] transition-colors h-full">Agregar</a>

            <!-- SE AÑADE EL BÚSCADOR -->
            <div class="relative ml-5 w-[600px] z-10 flex items-center">
                <label for="Search" class="sr-only">Search</label>
                <input wire:model="query" placeholder="Buscar"
                    class="w-full rounded border border-gray-300 py-2.5 px-4 sm:text-sm h-full outline-gray-400" />
                <span
                    class="absolute rounded inset-y-0 end-0 grid w-10 place-content-center bg-[#5E0409] hover:bg-[#7F0001] text-white h-full">
                    <button type="submit" class="text-gray-500 hover:text-gray-700 h-full">
                        <span class="sr-only bg-white text-white">Search</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-6 w-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                </span>
            </div>


        </div>
    </form>

    @if($users->count())
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-600">
            <thead class="bg-[#545759] shadow-md">
                <tr>
                    <th scope="col"
                        class="px-8 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                        Nombre
                    </th>
                    <th scope="col"
                        class="px-2 py-2  text-left  text-xs font-medium text-white uppercase tracking-wider">
                        Rol
                    </th>
                    <th scope="col"
                        class="px-2 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                        Membresía
                    </th>
                    <th scope="col"
                        class="px-2 py-2  text-left text-xs font-medium text-white uppercase tracking-wider">
                        Gimnasio (s)
                    </th>
                    <th scope="col"
                    class="px-2 py-2  text-left text-xs font-medium text-white uppercase tracking-wider">
                    Creado por
                </th>
                <th scope="col"
                        class="px-2 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                        Fecha de creación
                    </th>
                    <th scope="col"
                        class="px-2 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">
                        Actualizado por
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr>
                    <td class="px-2 py-2  whitespace-nowrap text-sm text-gray-500 text-left align-middle">
                        <div class="flex">
                            <img id="image" class="mr-2 w-6 h-6 object-cover rounded-full" src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('fotos/avatar.webp') }}" />
                            {{ $user->code}} - {{ $user->name}}
                        </div>

                    </td>

                    <td class="px-2 py-2  whitespace-nowrap text-sm text-gray-500 text-left align-middle">

                        @php
                        $roleNames = $user->roles->pluck('name');
                        @endphp

                        {{ $roleNames->isNotEmpty() ? $roleNames->join(', ') : 'Sin Rol' }}
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 text-left align-middle">
                        @if ($user->userMemberships->isNotEmpty())
                            @php
                            $membership = $user->userMemberships->first();
                            @endphp
                            {{ $membership->membership->name }}
                        @else
                        <span>Sin Membresía</span>
                        @endif
                    </td>
                    <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-500 text-left align-middle">
                        @php
                        $gymNames = $user->gyms->pluck('name');
                        @endphp

                        @if ($gymNames->isNotEmpty())
                            <ul>
                                @foreach ($gymNames as $gymName)
                                    <li>{{ $gymName }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span>Sin Gimnasios</span>
                        @endif
                    </td>

                    <td class="px-2 py-2  whitespace-nowrap text-sm text-gray-500 text-left align-middle">
                        {{ $user->creator ? $user->creator->name : '' }}
                    </td>
                    <td class="px-2 py-2  whitespace-nowrap text-sm text-gray-500 text-left align-middle">
                        {{ $user->created_at }}
                    </td>
                    <td class="px-2 py-2  whitespace-nowrap text-sm text-gray-500 text-left align-middle">
                        {{ $user->updater ? $user->updater->name : '' }}
                    </td>


                  {{--   <td class="grid grid-cols-3 gap-1 mt-2 mb-2 px-6 text-sm text-gray-500 min-w-[265px] w-full">
                        <div class="col-span-3">
                            <a href="{{ route('admin.user-memberships.history', $user) }}"
                               class="block text-center text-teal-600 hover:text-teal-900 px-3 py-1 rounded-md bg-teal-100 hover:bg-teal-200">
                               <i class='bx bx-history'></i>
                               Ver Historial Membresias
                            </a>
                        </div>
                        <div class="col-span-3 grid grid-cols-2 gap-1">
                            @if($authenticatedUserRole !== 'Administrador' || !$roleNames->contains('Super Administrador'))
                            <div class="col-span-1">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="block text-center text-yellow-600 hover:text-yellow-900 px-3 py-1 rounded-md bg-yellow-100 hover:bg-yellow-200">
                                   <i class='bx bxs-edit'></i>
                                   Editar
                                </a>
                            </div>
                            @endif

                            @if($user->id != $authenticatedUserId && !$roleNames->contains('Super Administrador'))
                            <div class="col-span-1">
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirmDeletion(event);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full block text-center text-red-600 hover:text-red-900 px-3 py-1 rounded-md bg-red-100 hover:bg-red-200">
                                        <i class='bx bx-trash'></i>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                        <div class="col-span-3">
                            <a href="{{ route('admin.users.generate-credential.pdf', $user) }}"
                               class="block text-center text-blue-600 hover:text-blue-900 px-3 py-1 rounded-md bg-blue-100 hover:bg-blue-200">
                               <i class='bx bxs-id-card'></i>
                               Generar Credencial
                            </a>
                        </div>
                    </td> --}}

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $users->links() }}
    </div>
    @else
    <div class="min-w-full divide-y divide-gray-200 text-center text-2xl text-gray-500">Sin resultados</div>
    @endif
</div>

<script>
    function confirmDeletion(event) {
        event.preventDefault();
        const form = event.target;

        Swal.fire({
            title: '¿Estás seguro que deseas eliminar el Usuario?',
            text: "¡No podrás revertir está acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, Eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
