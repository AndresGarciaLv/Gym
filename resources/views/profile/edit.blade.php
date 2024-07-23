@extends('layouts.panel')

@section('titulo')
   Mi Perfil
@endsection

@section('contenido')

<div class="mt-5">
    <div class="mx-auto sm:px-6 lg:px-8">
        <div class="flex space-x-2 mb-5">
            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 border border-[#7F0001] bg-[#7F0001] text-white font-semibold rounded hover:bg-[#5E0409] hover:text-white transition">
                <i class='bx bx-user text-lg mr-2'></i>
                Mi Cuenta
            </a>
            <a href="{{ route('profile.security') }}"  class="flex items-center px-4 py-2 border hover:border-[#7F0001] hover:text-[#7F0001] font-semibold rounded text-gray-700 transition">
                <i class='bx bx-lock-alt text-lg mr-2'></i>
                Seguridad
            </a>
        </div>


        <div class="overflow-hidden shadow-sm sm:rounded-lg ">
            <div class="p-6 bg-white border-b border-gray-200 w-full">

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <!-- Foto de Perfil -->
                    <div class="mb-5  grid grid-cols-1 md:grid-cols-2 gap-4">
                       <div class="mb-5 flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img id="image" class="w-32 h-32 rounded-full" src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('fotos/Avatar.webp') }}" />
                        </div>
                        <div>
                            <label
                            for="fileInput"
                            type="button"
                            class="cursor-pointer border border-gray-400 py-3 px-4 mr-2 rounded-lg shadow-sm text-left text-gray-600 bg-white hover:bg-gray-400  hover:text-white transition-colors font-medium"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="inline-flex flex-shrink-0 w-6 h-6 -mt-1 mr-1" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                <path d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                <circle cx="12" cy="13" r="3" />
                            </svg>
                            Subir Foto
                        </label>
                            @if($user->photo)
                            <button type="button" id="removePhotoButton" class="rounded-lg border border-red-600 text-red-600 py-2 px-4 hover:bg-red-600 hover:text-white transition-colors"><i class='bx bx-trash text-lg font-medium'></i>  Eliminar Foto</button>
                            @endif
                            <input type="hidden" name="remove_photo" id="removePhotoInput" value="0">
                            <input name="photo" id="fileInput" accept="image/*" class="hidden" type="file"
                                   onchange="let file = document.getElementById('fileInput').files[0];
                                             var reader = new FileReader();
                                             reader.onload = (e) => document.getElementById('image').src = e.target.result;
                                             reader.readAsDataURL(file);">
                            @error('photo')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                            <p class="text-gray-500 text-sm mt-2">Permitido JPG, GIF, PNG o Webp.</p>
                            <p class="text-gray-500 text-sm">Tamaño máximo de 2048kB.</p>
                        </div>
                       </div>

                       <div>
                        @if ($userRole && $userRole->name == 'Super Administrador')
                        <div class="flex m-2">
                            <i class='bx bx-crown text-gray-500 text-lg font-medium mr-2' ></i>
                            <p class="text-lg font-medium text-gray-500 mr-2">Rol: </p>
                            <p class="text-lg font-normal text-gray-500">Super Administrador</p>
                        </div>
                        <div class="flex m-2">
                            <i class='bx bx-dumbbell text-gray-500 text-lg font-medium mr-2'></i>
                            <p class="text-lg font-medium text-gray-500 mr-2">Gimnasios: </p>
                            <ul class="text-lg font-normal text-gray-500 list-disc ml-5">
                                @foreach ($user->gyms as $gym)
                                    <li>{{ $gym->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @elseif ($userRole && $userRole->name == 'Administrador')
                    <div class="flex m-2">
                        <i class='bx bx-crown text-gray-500 text-lg font-medium mr-2' ></i>
                        <p class="text-lg font-medium text-gray-500 mr-2">Rol: </p>
                        <p class="text-lg font-normal text-gray-500">Administrador</p>
                    </div>
                    <div class="flex m-2">
                        <i class='bx bx-dumbbell text-gray-500 text-lg font-medium mr-2'></i>
                        <p class="text-lg font-medium text-gray-500 mr-2">Gimnasios: </p>
                        <ul class="text-lg font-normal text-gray-500 list-disc ml-5">
                            @foreach ($user->gyms as $gym)
                                <li>{{ $gym->name }}</li>
                            @endforeach
                        </ul>
                    </div>

                    @elseif ($userRole && $userRole->name == 'Staff')
                    <div class="flex m-2">
                        <i class='bx bx-crown text-gray-500 text-lg font-medium mr-2' ></i>
                        <p class="text-lg font-medium text-gray-500 mr-2">Rol: </p>
                        <p class="text-lg font-normal text-gray-500">Staff</p>
                    </div>
                    <div class="flex m-2">
                        <i class='bx bx-dumbbell text-gray-500 text-lg font-medium mr-2'></i>
                        <p class="text-lg font-medium text-gray-500 mr-2">Gimnasio: </p>
                        <ul class="text-lg font-normal text-gray-500 list-disc ml-5">
                            @foreach ($user->gyms as $gym)
                                <li>{{ $gym->name }}</li>
                            @endforeach
                        </ul>
                    </div>

                    @else
                        No tiene rol asignado
                    @endif
                       </div>

                    </div>

                    <hr>

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                            <input type="text" name="name" id="name" value="{{ $user->name }}" class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]" required>
                            @error('name')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                            <input type="email" name="email" id="email" value="{{ $user->email }}" class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]" required>
                            @error('email')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Número de Teléfono</label>
                            <input type="text" name="phone_number" id="phone_number" value="{{ $user->phone_number }}" class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]">
                            @error('phone_number')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="birthdate" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
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

                    <div class="flex justify-end mt-4">
                        <button type="submit" class="block mt-3 border p-2 rounded-lg text-white bg-[#03A6A6] hover:bg-[#03A696] mb-5">Guardar Cambios</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
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
