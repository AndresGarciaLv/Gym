@extends('layouts.panel')

@section('titulo')
   Editar Usuario
@endsection

@section('contenido')
<h1 class="text-3xl font-bold text-center uppercase">Editar Usuario</h1>
<div class="mt-5">
    <div class="w-[600px] mx-auto sm:px-6 lg:px-8">

        <div class="overflow-hidden shadow-sm sm:rounded-lg ">
            <div class="p-6 bg-white border-b border-gray-200 flex flex-col items-center  justify-center w-full">
                 {{-- Alerta SUCCESS --}}
                @if(session('success'))
                <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 mb-4 mt-1 py-3 rounded relative"
                    role="alert">
                    <i class='bx bxs-check-shield'></i> <strong class="font-bold">{{ session('success') }}</strong>
                </div>
                @endif

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')

 <!-- Foto de Perfil -->
 <div class="mb-5 text-center">
    <div class="mx-auto w-32 h-32 mb-2 border rounded-full relative bg-gray-100 mb-4 shadow-inset">
        <img id="image" class="object-cover w-full h-32 rounded-full" src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('fotos/Avatar.webp') }}" />
    </div>

    <label
        for="fileInput"
        type="button"
        class="cursor-pointer border border-gray-400 py-2 px-4 mr-2 rounded-lg shadow-sm text-left text-gray-600 bg-white hover:bg-gray-400  hover:text-white transition-colors font-medium"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="inline-flex flex-shrink-0 w-6 h-6 -mt-1 mr-1" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
            <path d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
            <circle cx="12" cy="13" r="3" />
        </svg>
        Subir Foto
    </label>
    @if($user->photo)
    <button type="button" id="removePhotoButton" class="rounded-lg border border-red-600 text-red-600 py-2 px-4  hover:bg-red-600 hover:text-white transition-colors">Eliminar Foto</button>
    @endif

    <input type="hidden" name="remove_photo" id="removePhotoInput" value="0">

    <div class="mx-auto w-48 text-gray-500 text-xs text-center mt-2">Haz Click para agregar una foto</div>

    <input name="photo" id="fileInput" accept="image/*" class="hidden" type="file"
           onchange="let file = document.getElementById('fileInput').files[0];
                     var reader = new FileReader();
                     reader.onload = (e) => document.getElementById('image').src = e.target.result;
                     reader.readAsDataURL(file);">
    @error('photo')
        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
    @enderror
</div>

                    <label for="name" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">Nombre</label>
                    <input class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] mb-4"
                    type="text" name="name" placeholder="Nombre" value="{{ $user->name }}">
                    @error('name')
                    <div style="color:red">
                        {{ $message }}
                    </div>
                    @enderror

                    <label for="email" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">Correo Electrónico</label>
                    <input class="shadow-sm rounded-md w-full px-3 py-2 border  border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] mb-4"
                    type="email" name="email" placeholder="correo electrónico" value="{{ $user->email }}">
                    @error('email')
                    <div style="color:red">
                        {{ $message }}
                    </div>
                    @enderror

                    <label for="phone_number" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">Número de Telefono</label>
                    <input class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] mb-4"
                    type="text" name="phone_number" maxlength="10" pattern="\d{0,10}" placeholder="Numero de telefono" value="{{ $user->phone_number }}">
                    @error('phone_number')
                    <div style="color:red">
                        {{ $message }}
                    </div>
                    @enderror

                    <div class="mb-4 w-full">
                        <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Nacimiento</label>
                        <div class="relative">
                            <input
                                type="text"
                                name="birthdate"
                                id="birthdate"
                                placeholder="Selecciona una fecha"
                                class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] pl-10"
                                value="{{ $user->birthdate }}"
                            >
                            <i class="absolute left-3 top-2 text-gray-500 bx bxs-calendar text-xl"></i>
                        </div>
                        @error('birthdate')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    @if (auth()->user()->hasRole('Administrador') && auth()->user()->id == $user->id)
                        <!-- Si el administrador está editando sus propios datos, no mostrar campos de gimnasios y roles -->
                    @elseif (auth()->user()->hasRole('Super Administrador') || (auth()->user()->hasRole('Administrador') && auth()->user()->id != $user->id))
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5" for="role">Rol:</label>
                        <select class="shadow-sm rounded-md w-full px-3 py-2 border cursor-pointer border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] mb-4"
                        name="role" id="role" required>
                            @foreach ($roles as $role)
                                @if ($role->name != 'Super Administrador' || auth()->user()->hasRole('Super Administrador'))
                                    <option value="{{ $role->name }}" {{ $userRole && $userRole->name == $role->name ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('role')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror

                        <div id="multiGymSelection" class="mb-4 w-full" style="display: none;">
                            <label for="gyms" class="block text-sm font-medium text-gray-700 mb-2">Selecciona uno o más Gimnasios <b class="text-[#FF0104]">*</b></label>
                            <div class="flex flex-col space-y-2">
                                @foreach ($gyms as $gym)
                                    @if (auth()->user()->hasRole('Super Administrador') || auth()->user()->gyms->contains($gym->id))
                                        <div class="flex items-center">
                                            <input
                                                type="checkbox"
                                                name="gyms[]"
                                                id="gym-{{ $gym->id }}"
                                                value="{{ $gym->id }}"
                                                {{ in_array($gym->id, $user->gyms->pluck('id')->toArray()) ? 'checked' : '' }}
                                                class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
                                            >
                                            <label for="gym-{{ $gym->id }}" class="ml-2 block text-sm text-gray-700">{{ $gym->name }}</label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            @error('gyms')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="singleGymSelection" class="mb-4 w-full" style="display: none;">
                            <label for="single_gym" class="block text-sm font-medium text-gray-700 mb-2">Selecciona un Gimnasio <b class="text-[#FF0104]">*</b></label>
                            <select
                                name="single_gym"
                                id="single_gym"
                                class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            >
                                <option value="" disabled selected>Selecciona un Gimnasio</option>
                                @foreach ($gyms as $gym)
                                    @if (auth()->user()->hasRole('Super Administrador') || auth()->user()->gyms->contains($gym->id))
                                        <option value="{{ $gym->id }}" {{ $user->gyms->pluck('id')->contains($gym->id) ? 'selected' : '' }}>
                                            {{ $gym->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('single_gym')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <label for="isActive" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">Estado</label>
                    <select class="shadow-sm rounded-md w-full px-3 py-2 border cursor-pointer border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] mb-4"
                            name="isActive" id="isActive" required>
                        <option value="1" {{ $user->isActive ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ !$user->isActive ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('isActive')
                    <div style="color:red">
                        {{ $message }}
                    </div>
                    @enderror

                    <div class="mb-4 w-full">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            placeholder="Nueva Contraseña"
                        >
                        @error('password')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 w-full">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            placeholder="Confirmar Contraseña"
                        >
                        @error('password_confirmation')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex justify-between items-center">
                        <button type="submit" class="block mt-3 border p-2 rounded-lg text-white bg-[#03A6A6] hover:bg-[#03A696] mb-5">Actualizar Usuario</button>
                        <a href="{{ route('admin.users.generate-credential.pdf', $user->id) }}"
                        class="text-white p-2 rounded-md mr-1 bg-blue-600 hover:bg-blue-700">Generar Credencial</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(() => {
                alert.style.display = 'none';
            }, 4000);
        }

        const roleSelect = document.getElementById('role');
        const multiGymSelection = document.getElementById('multiGymSelection');
        const singleGymSelection = document.getElementById('singleGymSelection');

        function toggleGymSelection() {
            const selectedRole = roleSelect.value;
            if (selectedRole === 'Super Administrador' || selectedRole === 'Administrador') {
                multiGymSelection.style.display = 'block';
                singleGymSelection.style.display = 'none';
            } else if (selectedRole === 'Staff' || selectedRole === 'Cliente') {
                multiGymSelection.style.display = 'none';
                singleGymSelection.style.display = 'block';
            } else {
                multiGymSelection.style.display = 'none';
                singleGymSelection.style.display = 'none';
            }
        }

        roleSelect.addEventListener('change', toggleGymSelection);
        toggleGymSelection(); // Ejecutar al cargar la página

        const removePhotoButton = document.getElementById('removePhotoButton');
        const removePhotoInput = document.getElementById('removePhotoInput');
        const image = document.getElementById('image');

        if (removePhotoButton) {
            removePhotoButton.addEventListener('click', function () {
                removePhotoInput.value = '1';
                image.src = '{{ asset('fotos/avatar.webp') }}';
            });
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr('#birthdate', {
            locale: 'es',
            dateFormat: 'Y-m-d'
        });
    });
</script>
@endsection
