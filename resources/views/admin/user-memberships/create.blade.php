@extends('layouts.panel')

@section('titulo')
   Asignar Membresía
@endsection

@section('contenido')
<h1 class="text-3xl font-bold text-center mt-5 uppercase">Asignar Membresía</h1>
<h2 class="text-xl font-semibold text-center mt-2 uppercase">{{ $gym->name }}</h2>
<div class="mb-10 mt-5">
    <div class="w-[600px] mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 flex flex-col justify-center w-full">

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <i class='bx bxs-check-shield'></i> <strong class="font-bold">{{ session('success') }}</strong>
                    </div>
                @endif

                <form id="userMembershipForm" action="{{ route('admin.user-memberships.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="id_gym" value="{{ $gym->id }}">

                    <div class="mb-4 w-full">
                        <label for="userSearch" class="block text-sm font-medium text-gray-700 mb-2">Usuario <b class="text-[#FF0104]">*</b></label>
                        <div class="relative">
                            <input type="text" id="userSearch" placeholder="Buscar usuario" class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]">
                            <div id="userDropdown" class="absolute shadow bg-white top-100 z-40 w-full left-0 rounded max-h-select overflow-y-auto" style="display: none;">
                                <div class="flex flex-col w-full">
                                    @foreach ($users as $user)
                                    <div class="cursor-pointer w-full border-gray-100 border-b hover:bg-teal-100" data-user-id="{{ $user->id }}">
                                        <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">
                                            <div class="w-6 flex flex-col items-center">
                                                <div class="flex relative w-5 h-5 bg-orange-500 justify-center items-center m-1 mr-2 w-4 h-4 mt-1 rounded-full">
                                                    <img id="image" class="object-cover rounded-full" src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('fotos/avatar.webp') }}" />
                                                </div>
                                            </div>
                                            <div class="w-full items-center flex">
                                                <div class="mx-2 -mt-1">{{ $user->name }}
                                                    <div class="text-xs truncate w-full normal-case font-normal -mt-1 text-gray-500">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @error('id_user')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                        <input type="hidden" name="id_user" id="id_user" required>
                    </div>

                    <div class="mb-4 w-full">
                        <label for="id_gym" class="block text-sm font-medium text-gray-700 mb-2">Gimnasio <b class="text-[#FF0104]">*</b></label>
                        <select
                            name="id_gym"
                            id="id_gym"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            disabled
                        >
                            <option value="{{ $gym->id }}" selected>{{ $gym->name }}</option>
                        </select>
                        @error('id_gym')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 w-full">
                        <label for="id_membership" class="block text-sm font-medium text-gray-700 mb-2">Membresía <b class="text-[#FF0104]">*</b></label>
                        <select
                            name="id_membership"
                            id="id_membership"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            required
                        >
                            <option value="" disabled selected>Selecciona una Membresía</option>
                            @foreach ($gym->memberships as $membership)
                                <option value="{{ $membership->id }}">
                                    {{ $membership->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_membership')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 w-full">
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Inicio <b class="text-[#FF0104]">*</b></label>
                        <div class="relative">
                            <input
                                type="text"
                                name="start_date"
                                id="start_date"
                                placeholder="Selecciona una fecha"
                                class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] pl-10"
                                required
                            >
                            <i class="absolute left-3 top-2 text-gray-500 bx bxs-calendar text-xl"></i>
                        </div>
                        @error('start_date')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 w-full">
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Vencimiento <b class="text-[#FF0104]">*</b></label>
                        <div class="relative">
                            <input
                                type="text"
                                name="end_date"
                                id="end_date"
                                placeholder="Selecciona una fecha"
                                class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] pl-10"
                                required
                            >
                            <i class="absolute left-3 top-2 text-gray-500 bx bxs-calendar text-xl"></i>
                        </div>
                        @error('end_date')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <button
                        type="submit"
                        class="mt-3 w-full py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#03A6A6] hover:bg-[#038686] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#03A6A6]"
                    >
                        Asignar Membresía
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userSearchInput = document.getElementById('userSearch');
        const userDropdown = document.getElementById('userDropdown');
        const userIdInput = document.getElementById('id_user');

        userSearchInput.addEventListener('focus', function() {
            userDropdown.style.display = 'block';
        });

        userSearchInput.addEventListener('blur', function() {
            setTimeout(function() {
                userDropdown.style.display = 'none';
            }, 200);
        });

        userSearchInput.addEventListener('input', function() {
            const filter = userSearchInput.value.toLowerCase();
            const users = userDropdown.querySelectorAll('[data-user-id]');
            
            users.forEach(function(user) {
                const userName = user.querySelector('.mx-2').textContent.toLowerCase();
                const userEmail = user.querySelector('.text-gray-500').textContent.toLowerCase();
                if (userName.includes(filter) || userEmail.includes(filter)) {
                    user.style.display = 'flex';
                } else {
                    user.style.display = 'none';
                }
            });
        });

        userDropdown.addEventListener('click', function(e) {
            const target = e.target.closest('[data-user-id]');
            if (target) {
                const userId = target.getAttribute('data-user-id');
                const userName = target.querySelector('.mx-2').textContent.trim();
                userSearchInput.value = userName;
                userIdInput.value = userId;
            }
        });

        userSearchInput.addEventListener('dblclick', function() {
            userSearchInput.value = '';
            userIdInput.value = '';
            userDropdown.style.display = 'block';
        });
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

        flatpickr('#start_date', {
            locale: 'es',
            dateFormat: 'Y-m-d',
            onChange: function(selectedDates, dateStr, instance) {
                const endDateInput = document.getElementById('end_date');
                const startDate = new Date(dateStr);
                const endDate = new Date(startDate);
                endDate.setMonth(endDate.getMonth() + 1);
                endDateInput._flatpickr.setDate(endDate);
            }
        });

        flatpickr('#end_date', {
            locale: 'es',
            dateFormat: 'Y-m-d'
        });
    });
</script>

@endsection
