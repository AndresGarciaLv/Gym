@extends('layouts.panel')

@section('titulo')
   Crear Usuario
@endsection

@section('contenido')
<h1 class="text-3xl font-bold text-center mt-5 uppercase">Crear Usuario</h1>
<div class="mb-10 mt-5">
    <div class="w-[600px] mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 flex flex-col  justify-center w-full">
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <i class='bx bxs-check-shield'></i> <strong class="font-bold">{{ session('success') }}</strong>
                    </div>
                @endif
                                     
                <form id="userForm" action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="mb-4 w-full">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre <b class="text-[#FF0104]">*</b></label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            placeholder="Nombre"
                            value="{{ old('name') }}"
                            required
                        >
                        @error('name')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 w-full">
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Rol <b class="text-[#FF0104]">*</b></label>
                        <select
                            name="role"
                            id="role"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            required
                        >
                        <option value="" disabled selected>Selecciona un Rol</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 w-full">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico <b class="text-[#FF0104]" id="email-label">*</b></label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            placeholder="Correo Electrónico"
                            value="{{ old('email') }}"
                        >
                        @error('email')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 w-full">
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Número de telefono <span class="text-gray-400">(opcional)</span></label>
                        <input
                            type="text"
                            name="phone_number"
                            id="phone_number"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            placeholder="Número de Telefono"
                            value="{{ old('phone_number') }}"
                        >
                        @error('phone_number')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 w-full">
                        <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Nacimiento <span class="text-gray-400">(opcional)</span></label>
                        <input
                          type="date"
                          name="birthdate"
                          placeholder="Fecha de nacimiento"
                          value="{{ old('birthdate') }}"
                          class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                        />
                      </div>

                      <div class="mb-4 w-full">
                        <label for="gyms" class="block text-sm font-medium text-gray-700 mb-2">Selecciona uno o más Gimnasios <b class="text-[#FF0104]">*</b></label>
                        <div class="flex flex-col space-y-2">
                            @foreach ($gyms as $gym)
                                <div class="flex items-center">
                                    <input
                                        type="checkbox"
                                        name="gyms[]"
                                        id="gym-{{ $gym->id }}"
                                        value="{{ $gym->id }}"
                                        {{ in_array($gym->id, old('gyms', [])) ? 'checked' : '' }}
                                        class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
                                    >
                                    <label for="gym-{{ $gym->id }}" class="ml-2 block text-sm text-gray-700">{{ $gym->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        @error('gyms')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4 w-full">
                        <label for="isActive" class="block text-sm font-medium text-gray-700 mb-2">Estado <b class="text-[#FF0104]">*</b></label>
                        <select
                            name="isActive"
                            id="isActive"
                            class="shadow-sm rounded-md w-full px-3 py-2 border cursor-pointer border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            required
                        >
                            <option value="" disabled selected>Selecciona el Estado del Usuario</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                        @error('isActive')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="passwordFields">
                        <div class="mb-4 w-full">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña <b class="text-[#FF0104]">*</b></label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                                placeholder="Contraseña"
                            >
                            @error('password')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 w-full">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña <b class="text-[#FF0104]">*</b></label>
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
                    </div>

                    <button
                        type="submit"
                        class="mt-3 w-full py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#03A6A6] hover:bg-[#038686] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#03A6A6]"
                    >
                        Crear Usuario
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role');
        const passwordFields = document.getElementById('passwordFields');
        const passwordInput = document.getElementById('password');
        const emailInput = document.getElementById('email');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const emailLabel = document.getElementById('email-label');
        const gymsLabel = document.getElementById('gyms-label');

        function toggleFields() {
            if (roleSelect.value === 'Cliente') {
                passwordFields.style.display = 'none';
                passwordInput.removeAttribute('required');
                emailInput.removeAttribute('required');
                passwordConfirmationInput.removeAttribute('required');
                passwordInput.value = '';
                passwordConfirmationInput.value = '';
                emailLabel.innerHTML = '<span class="text-gray-400">(opcional)</span>';

            } else {
                passwordFields.style.display = 'block';
                passwordInput.setAttribute('required', 'required');
                emailInput.setAttribute('required', 'required');
                passwordConfirmationInput.setAttribute('required', 'required');
                emailLabel.textContent = '*';
            }
        }

        roleSelect.addEventListener('change', toggleFields);
        toggleFields(); // Para ejecutar al cargar la página
    });
</script>
@endsection
