<div class="mt-4">
    <form wire:submit.prevent="search">
        <div class="flex items-end align-middle mb-5">
            <a href="{{ route('admin.user-memberships.create', $gymId) }}"
               class="relative bg-[#34AD3C] text-white px-4 py-2 ml-5 mr-6 rounded hover:bg-[#3D7A41] transition-colors h-full">Agregar</a>
            <div x-data="{ isActive: false }" class="relative ml-auto mr-6">
                <div class="inline-flex items-center overflow-hidden rounded-md border bg-white">
                    <a href="javascript:void(0);"
                       class="w-full border-e px-4 py-3 text-sm/none text-gray-600 hover:bg-gray-50 hover:text-gray-700"
                       x-on:click="isActive = !isActive">Exportar</a>
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
                            <div class="flex items-center">&#8203;</div>
                            <a href="">
                                <strong class="font-medium text-gray-900"> PDF </strong>
                            </a>
                        </label>
                        <label for="Option2" id="option2" class="flex cursor-pointer items-start gap-4 mb-1">
                            <div class="flex items-center">&#8203;</div>
                            <a href="">
                                <strong class="font-medium text-gray-900"> Excel </strong>
                            </a>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @if($activeMemberships->count() || $inactiveMemberships->count())
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-600">
            <thead class="bg-[#545759] shadow-md">
                <tr>
                    <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Usuario</th>
                    <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Rol</th>
                    <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Gimnasio</th>
                    <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Membresía</th>
                    <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Fecha de Inicio</th>
                    <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Fecha de Vencimiento</th>
                    <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Estado</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($activeMemberships as $activeMembership)
                <tr class="bg-green-100">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center align-middle">{{ $user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center align-middle">
                        @foreach($user->roles as $role)
                            {{ $role->name }}<br>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center align-middle">{{ $activeMembership->gym->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center align-middle">{{ $activeMembership->membership->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center align-middle">{{ $activeMembership->start_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center align-middle">{{ $activeMembership->end_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center align-middle">
                        <span class="px-2 inline-flex text-xs bg-green-600 leading-5 font-semibold rounded-full" style="background-color: {{ $activeMembership->statusColor }}; color: white;">
                            {{ $activeMembership->status }}
                        </span>
                    </td>
                </tr>
                @endforeach

                @foreach($inactiveMemberships as $inactiveMembership)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center align-middle">{{ $user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center align-middle">
                        @foreach($user->roles as $role)
                            {{ $role->name }}<br>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center align-middle">{{ $inactiveMembership->gym->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center align-middle">{{ $inactiveMembership->membership->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center align-middle">{{ $inactiveMembership->start_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center align-middle">{{ $inactiveMembership->end_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center align-middle">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" style="background-color: {{ $inactiveMembership->statusColor }}; color: white;">
                            {{ $inactiveMembership->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
            title: '¿Estás seguro que deseas eliminar la Membresía?',
            text: "¡No podrás revertir esta acción!",
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
