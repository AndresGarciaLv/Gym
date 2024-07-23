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

                <form id="userMembershipForm" action="{{ route('staffs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="role" value="Cliente">

                    <div class="mb-4 w-full">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo <b class="text-[#FF0104]">*</b></label>
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
                        <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Nacimiento (año-mes-día) <span class="text-gray-400">(opcional)</span></label>
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
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Dirección <span class="text-gray-400">(opcional)</span></label>
                        <input
                            type="text"
                            name="address"
                            id="address"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            placeholder="Dirección"
                            value="{{ old('address') }}"
                        >
                        @error('address')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <label class="block text-sm font-medium text-gray-700 mb-2">Género <b class="text-[#FF0104]">*</b></label>
<div class="flex items-center space-x-4 mb-4 w-full">
    <div class="flex items-center">
        <input
            type="radio"
            name="gender"
            id="gender_male"
            value="male"
            {{ old('gender') == 'male' ? 'checked' : '' }}
            class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
            required
        >
        <label for="gender_male" class="ml-2 block text-sm text-gray-700">Masculino</label>
    </div>
    <div class="flex items-center">
        <input
            type="radio"
            name="gender"
            id="gender_female"
            value="female"
            {{ old('gender') == 'female' ? 'checked' : '' }}
            class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
            required
        >
        <label for="gender_female" class="ml-2 block text-sm text-gray-700">Femenino</label>
    </div>
    <div class="flex items-center">
        <input
            type="radio"
            name="gender"
            id="gender_undefined"
            value="undefined"
            {{ old('gender') == 'undefined' ? 'checked' : '' }}
            class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
            required
        >
        <label for="gender_undefined" class="ml-2 block text-sm text-gray-700">Indefinido</label>
    </div>
    @error('gender')
        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
    @enderror
</div>

                    <hr>
                    <p class="text-lg font-bold text-center">Datos de Contacto de Emergencia</p>

                    <div class="mb-4 w-full">
                        <label for="name_contact" class="block text-sm font-medium text-gray-700 mb-2">Nombre  <span class="text-gray-400">(opcional)</span></label>
                        <input
                            type="text"
                            name="name_contact"
                            id="name_contact"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            placeholder="Nombre de contacto de Emergencia"
                            value="{{ old('name_contact') }}"

                        >
                        @error('name_contact')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 w-full">
                        <label for="phone_emergency" class="block text-sm font-medium text-gray-700 mb-2">Teléfono <span class="text-gray-400">(opcional)</span></label>
                        <input
                            type="text"
                            name="phone_emergency"
                            id="phone_emergency"
                            maxlength="10" pattern="\d{0,10}"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            placeholder="Número de Telefono"
                            value="{{ old('phone_emergency') }}"
                        >
                        @error('phone_emergency')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <hr>

                    <div class="mt-2 mb-4 w-full">
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Foto de Perfil <span class="text-gray-400">(opcional)</span></label>
                        <input
                            type="file"
                            name="photo"
                            id="photo"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            accept="image/*"

                        >
                        @error('photo')
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
                                <option value="{{ $membership->id }}" data-duration-type="{{ $membership->duration_type }}" data-price="{{ $membership->price }}">
                                    {{ $membership->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_membership')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 w-full">
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Precio de la Membresía</label>
                        <input
                            type="text"
                            name="price"
                            id="price"
                            class="shadow-sm rounded-md w-full px-3 py-2 border bg-gray-100 border-gray-500 focus:outline-none cursor-not-allowed"
                            placeholder="Precio"
                            readonly
                        >
                    </div>

                    <div class="mb-4 w-full" id="start_date_container" style="display: none;">
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Inicio (año-mes-día) <b class="text-[#FF0104]">*</b></label>
                        <div class="relative">
                            <input
                                type="text"
                                name="start_date"
                                id="start_date"
                                placeholder="Selecciona una fecha"
                                class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] pl-10"
                            >
                            <i class="absolute left-3 top-2 text-gray-500 bx bxs-calendar text-xl"></i>
                        </div>
                        @error('start_date')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 w-full" id="end_date_container" style="display: none;">
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Vencimiento (año-mes-día) <b class="text-[#FF0104]">*</b></label>
                        <div class="relative">
                            <input
                                type="text"
                                name="end_date"
                                id="end_date"
                                placeholder="Selecciona una fecha"
                                class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] pl-10"
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
        const priceInput = document.getElementById('price');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const startDateContainer = document.getElementById('start_date_container');
        const endDateContainer = document.getElementById('end_date_container');

        flatpickr('#birthdate', {
            locale: 'es',
            dateFormat: 'Y-m-d'
        });


        const startDatePicker = flatpickr(startDateInput, {
        locale: 'es',
        dateFormat: 'Y-m-d',
        onChange: function(selectedDates, dateStr, instance) {
            updateEndDate();
        }
    });

    const endDatePicker = flatpickr(endDateInput, {
        locale: 'es',
        dateFormat: 'Y-m-d'
    });

    membershipSelect.addEventListener('change', function() {
        const selectedMembership = this.options[this.selectedIndex];
        const durationType = selectedMembership.getAttribute('data-duration-type');
        const price = selectedMembership.getAttribute('data-price');

        // Mostrar el precio de la membresía seleccionada
        priceInput.value = "$" + price;

        if (durationType === 'Diaria') {
            startDateContainer.style.display = 'none';
            endDateContainer.style.display = 'none';
            setDailyDates();
        } else if (durationType) {
            startDateContainer.style.display = 'block';
            endDateContainer.style.display = 'block';
            updateEndDate();
        } else {
            startDateContainer.style.display = 'none';
            endDateContainer.style.display = 'none';
        }
    });

    function updateEndDate() {
        const startDateStr = startDateInput.value;
        const selectedMembership = membershipSelect.options[membershipSelect.selectedIndex];
        const durationType = selectedMembership.getAttribute('data-duration-type');

        if (startDateStr && durationType) {
            const startDate = new Date(startDateStr);
            let endDate = new Date(startDateStr);

            switch (durationType) {
                case 'Semanal':
                    endDate.setDate(startDate.getDate() + 8);
                    break;
                    case 'Mensual':
    // Calculate end date based on the start date
    const currentMonth = startDate.getMonth();
    const nextMonth = new Date(startDate);
    nextMonth.setMonth(currentMonth + 1);

    // Condición: Si el mes actual tiene 31 días y el mes siguiente tiene 30 o viceversa
    if ((currentMonthDays(currentMonth) === 31 && currentMonthDays(nextMonth.getMonth()) === 30)) {
        endDate.setDate(startDate.getDate() + 32);
    }
    else if((currentMonthDays(currentMonth) === 30 && currentMonthDays(nextMonth.getMonth()) === 31))
    {
        endDate.setDate(startDate.getDate() + 31);
    }
    // Condición: Si el mes actual y el mes siguiente ambos tienen 31 días
    else if (currentMonthDays(currentMonth) === 31 && currentMonthDays(nextMonth.getMonth()) === 31) {
        endDate.setDate(startDate.getDate() + 32);
    }
    else {
        endDate.setDate(startDate.getDate() + 32);
    }

    // Ajustar la fecha de finalización para días en febrero
    if (startDate.getMonth() === 1 && endDate.getMonth() === 2 && endDate.getDate() !== startDate.getDate()) {
        endDate.setDate(startDate.getDate() + 1);
    }

    // Manejar casos especiales en febrero
    if (startDate.getDate() > endDate.getDate()) {
        endDate.setDate(1); // Esto establece el último día del mes anterior
        endDate.setDate(startDate.getDate() - (startDate.getDate() - endDate.getDate()));
    }
    break;

                case 'Anual':
                    endDate.setFullYear(startDate.getFullYear() + 1);
                    break;
                case 'Diaria':
                setDailyDates();
                    break;
                default:
                    endDate = null;
            }

            if (endDate) {
                endDate.setHours(23, 59, 0);
                endDateInput._flatpickr.setDate(endDate);
            }
        }
    }

    function setDailyDates() {
        const today = new Date();
        startDatePicker.setDate(today);
        endDatePicker.setDate(today.setHours(23, 59, 0, 0));
    }

    function currentMonthDays(month) {
    return new Date(new Date().getFullYear(), month + 1, 0).getDate();
    }



    // Ocultar campos de fecha hasta que se seleccione una membresía
    startDateContainer.style.display = 'none';
    endDateContainer.style.display = 'none';
});
</script>
@endsection
