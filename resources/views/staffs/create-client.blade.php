@extends('layouts.panel')

@section('titulo')
   Nuevo Cliente
@endsection

@section('contenido')
<h1 class="text-3xl font-bold text-center mt-5 uppercase">Nuevo Cliente</h1>
<div class="mt-5">
    <div class="w-[600px] mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 flex flex-col justify-center w-full">

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <i class='bx bxs-check-shield'></i> <strong class="font-bold">{{ session('success') }}</strong>
                    </div>
                @endif

                <form id="userMembershipForm" action="{{ route('staffs.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="role" value="Cliente">

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
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico <span class="text-gray-400">(opcional)</span></label>
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
                            maxlength="10" pattern="\d{0,10}"
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
                        <div class="relative">
                            <input
                                type="text"
                                name="birthdate"
                                id="birthdate"
                                placeholder="Selecciona una fecha"
                                class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] pl-10"
                                value="{{ old('birthdate') }}"
                            >
                            <i class="absolute left-3 top-2 text-gray-500 bx bxs-calendar text-xl"></i>
                        </div>
                        @error('birthdate')
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
                            onchange="setMembershipDates(this)"
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
                        Crear Cliente
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
        const membershipSelect = document.getElementById('id_membership');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const startDateContainer = document.getElementById('start_date_container');
        const endDateContainer = document.getElementById('end_date_container');

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
