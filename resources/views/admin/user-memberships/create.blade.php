@extends('layouts.panel')

@section('titulo')
   Asignar Membresía
@endsection

@section('contenido')
<h1 class="text-3xl font-bold text-center uppercase">Asignar Membresía222</h1>
<h2 class="text-xl font-semibold text-center mt-2 uppercase">{{ $gym->name }}</h2>
<div class="mt-5">
    <div class="w-[600px] mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 flex flex-col justify-center w-full">

                <form id="userMembershipForm" action="{{ route('admin.user-memberships.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="id_gym" value="{{ $gym->id }}">

                    <div class="mb-4 w-full">
                        <label for="userSearch" class="block text-sm font-medium text-gray-700 mb-2">
                            Usuario <b class="text-[#FF0104]">*</b>
                        </label>
                        <div class="relative">
                            <input type="text" autocomplete="off" id="userSearch" placeholder="Buscar usuario por nombre, código o correo" class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]">
                            <div id="userDropdown" class="border border-[#7F0001] absolute shadow bg-white top-100 z-40 w-full left-0 rounded max-h-60 overflow-y-auto" style="display: none;">
                                <div class="flex flex-col w-full">
                                    @foreach ($users as $user)
                                    <div class="cursor-pointer w-full border-gray-100 border-b hover:bg-teal-100" data-user-id="{{ $user->id }}">
                                        <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-teal-100">
                                            <div class="w-6 flex flex-col items-center">
                                                <div class="flex relative w-5 h-5 bg-orange-500 justify-center items-center m-1 mr-2 mt-1 rounded-full">
                                                    <img id="image" class="object-cover rounded-full" src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('fotos/avatar.webp') }}" />
                                                </div>
                                            </div>
                                            <div class="w-full items-center flex">
                                                <div class="mx-2 -mt-1">{{ $user->name }}
                                                    <div class="text-xs truncate w-full normal-case font-normal -mt-1 text-gray-500">{{ $user->code }}</div>
                                                    <div class="text-xs truncate w-full normal-case font-normal -mt-1 text-gray-500">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div id="noResults" class="px-4 py-2 text-gray-500" style="display: none;">
                                        No hay resultados.
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
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-500 bg-gray-300 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
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
                                <option value="{{ $membership->id }}" data-duration-type="{{ $membership->duration_type }}">
                                    {{ $membership->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_membership')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 w-full" id="start_date_container">
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

                    <div class="mb-4 w-full" id="end_date_container">
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


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function () {
    const userSearchInput = document.getElementById('userSearch');
    const userDropdown = document.getElementById('userDropdown');
    const userIdInput = document.getElementById('id_user');
    const membershipSelect = document.getElementById('id_membership');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const startDateContainer = document.getElementById('start_date_container');
    const endDateContainer = document.getElementById('end_date_container');
    const noResultsDiv = document.getElementById('noResults');

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
        let hasResults = false;

        users.forEach(function(user) {
            const userName = user.querySelector('.mx-2').textContent.toLowerCase();
            const userEmail = user.querySelector('.text-gray-500').textContent.toLowerCase();
            if (userName.includes(filter) || userEmail.includes(filter)) {
                user.style.display = 'flex';
                hasResults = true;
            } else {
                user.style.display = 'none';
            }
        });

        if (hasResults) {
            noResultsDiv.style.display = 'none';
        } else {
            noResultsDiv.style.display = 'block';
        }
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

    const startDatePicker = flatpickr(startDateInput, {
            locale: 'es',
            dateFormat: 'Y-m-d',
            onChange: function(selectedDates, dateStr, instance) {
                const selectedMembership = membershipSelect.options[membershipSelect.selectedIndex];
                const durationType = selectedMembership.getAttribute('data-duration-type');
                const startDate = new Date(dateStr);
                let endDate = new Date(startDate);

                switch (durationType) {
                    case 'Semanal':
                        endDate.setDate(startDate.getDate() + 7);
                        break;
                    case 'Mensual':
                    endDate.setMonth(startDate.getMonth() + 1);
                        if (endDate.getDate() !== startDate.getDate()) {
                            endDate.setDate(0); // Set to the last day of the previous month
                        }
                        break;
                    case 'Anual':
                        endDate.setFullYear(startDate.getFullYear() + 1);
                        break;
                    case 'Diaria':
                        const today = new Date();
                        startDatePicker.setDate(today);
                        endDatePicker.setDate(today.setHours(23, 59, 0, 0));
                        break;
                    default:
                        endDate = null;
                }

                if (endDate) {
                    endDate.setHours(23, 59, 0);
                    endDateInput._flatpickr.setDate(endDate);
                }
            }
        });

    const endDatePicker = flatpickr(endDateInput, {
        locale: 'es',
        dateFormat: 'Y-m-d'
    });

    membershipSelect.addEventListener('change', function() {
        const selectedMembership = this.options[this.selectedIndex];
        const durationType = selectedMembership.getAttribute('data-duration-type');
        if (durationType === 'Diaria') {
            const today = new Date();
            startDatePicker.setDate(today);
            endDatePicker.setDate(today.setHours(23, 59, 0, 0));
            startDateContainer.style.display = 'none';
            endDateContainer.style.display = 'none';
        } else {
            startDateContainer.style.display = 'block';
            endDateContainer.style.display = 'block';
        }
    });
});

</script>
@endsection
