<div class="mt-4">
    <form wire:submit.prevent="search">
        <div class="flex items-end align-middle mb-5">
            <!-- BOTÓN QUE DIRIGE AL CRUD -->
            <a href="{{ route('admin.memberships.create') }}"
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

            <!-- BOTÓN QUE NOS SIRVE PARA EXPORTAR LOS ARCHIVOS -->
            <div x-data="{ isActive: false }" class="relative ml-auto mr-6">
                <div class="inline-flex items-center overflow-hidden rounded-md border bg-white">
                    <a href="javascript:void(0);"
                        class="w-full border-e px-4 py-3 text-sm/none text-gray-600 hover:bg-gray-50 hover:text-gray-700"
                        x-on:click="isActive = !isActive">
                        Exportar
                    </a>
                    <button x-on:click="isActive = !isActive"
                        class="h-full p-2 text-gray-600 hover:bg-gray-50 hover:text-gray-500">
                        <span class="sr-only">Menu</span>
                        <i class='bx bxs-chevron-down'></i>
                    </button>
                </div>

                <div class="absolute right-0 z-10 mt-2 w-56 rounded-md border border-gray-100 bg-white shadow-lg"
                    role="menu" x-cloak x-transition x-show="isActive" x-on:click.away="isActive = false"
                    x-on:keydown.escape.window="isActive = false">
                    <div class="p-2">
                        <strong class="block p-2 text-xs font-medium uppercase text-gray-400"> Opciones </strong>
                        <label for="Option1" id="option1" class="flex cursor-pointer items-start gap-4 mb-1">
                            <div class="flex items-center">
                                &#8203;
                            </div>
                            <a href="">
                                <strong class="font-medium text-gray-900"> PDF </strong>
                            </a>
                        </label>

                        <label for="Option2" id="option2" class="flex cursor-pointer items-start gap-4 mb-1">
                            <div class="flex items-center">
                                &#8203;
                            </div>

                            <a href="">
                                <strong class="font-medium text-gray-900"> Excel </strong>
                            </a>
                        </label>

                    </div>
                </div>
            </div>
        </div>
    </form>

    @if($userMemberships->count())
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-600">
            <thead class="bg-[#545759] shadow-md">
                <tr>
                    <th scope="col"
                        class="px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                        Usuario
                    </th>
                    <th scope="col"
                        class="px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                        Gimnasio
                    </th>
                    <th scope="col"
                        class="px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                        Membresía
                    </th>
                    <th scope="col"
                        class="px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                        Fecha de Inicio
                    </th>
                    <th scope="col"
                        class="px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                        Fecha de Vencimiento
                    </th>
                    <th scope="col"
                        class="px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                        Estado
                    </th>
                    <th scope="col"
                        class="px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($userMemberships as $userMembership)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center align-middle">
                        {{ $userMembership->user->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center align-middle">
                        {{ $userMembership->gym->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center align-middle">
                        {{ $userMembership->membership->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center align-middle">
                        {{ $userMembership->start_date }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center align-middle">
                        {{ $userMembership->end_date }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center align-middle">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" style="background-color: {{ $userMembership->statusColor }}; color: white;">
                            {{ $userMembership->status }}
                        </span>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center align-middle">
                        <a href="{{ route('admin.user-memberships.edit', $userMembership) }}"
                           class="text-yellow-600 hover:text-yellow-900">
                            Editar
                        </a>
                        <form action="{{ route('admin.user-memberships.destroy', $userMembership) }}" method="POST" style="display:inline" onsubmit="return confirm('¿Estás seguro que deseas eliminar esta membresía?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 ml-2">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $userMemberships->links() }}
    </div>
    @else
    <div class="min-w-full divide-y divide-gray-200 text-center text-2xl text-gray-500">Sin resultados</div>
    @endif
</div>
