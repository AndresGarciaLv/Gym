@extends('layouts.panel')

@section('titulo')
   Crear Usuario
@endsection

@section('contenido')
<h1 class="text-3xl font-bold text-center uppercase">Crear Usuario</h1>
<div class="mt-5">
    <div class="w-[600px] mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 flex flex-col justify-center w-full">

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <i class='bx bxs-check-shield'></i> <strong class="font-bold">{{ session('success') }}</strong>
                    </div>
                @endif

                <form id="userForm" action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
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
                                @if(auth()->user()->hasRole('Super Administrador') || $role->name != 'Super Administrador')
                                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endif
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

<div id="singleGymSelection" class="mb-4 w-full" style="display: none;">
    <label for="single_gym" class="block text-sm font-medium text-gray-700 mb-2">Selecciona un Gimnasio <b class="text-[#FF0104]">*</b></label>
    <select
        name="single_gym"
        id="single_gym"
        class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
    >
        <option value="" disabled selected>Selecciona un Gimnasio</option>
        @foreach ($gyms as $gym)
            <option value="{{ $gym->id }}" {{ old('single_gym') == $gym->id ? 'selected' : '' }}>
                {{ $gym->name }}
            </option>
        @endforeach
    </select>
    @error('single_gym')
        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
    @enderror
</div>

<div id="customerFields" style="display: none;">
    <div class="mb-4 w-full">
        <label for="id_membership" class="block text-sm font-medium text-gray-700 mb-2">Membresía <b class="text-[#FF0104]">*</b></label>
        <select
            name="id_membership"
            id="id_membership"
            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
            required
        >
            <option value="" disabled selected>Selecciona una Membresía</option>
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
</div>

                    <div id="multiGymSelection" class="mb-4 w-full">
                        <label for="gyms" class="block text-sm font-medium text-gray-700 mb-2">Selecciona uno o más Gimnasios <b class="text-[#FF0104]">*</b></label>
                        <div class="flex flex-col space-y-2">
                            @foreach ($gyms as $gym)
                                @if(auth()->user()->hasRole('Super Administrador') || in_array($gym->id, auth()->user()->gyms->pluck('id')->toArray()))
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
                                @endif
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
                            <option value="1" selected>Activo</option>
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

                    <div class="mb-4 w-full">
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
        const multiGymSelection = document.getElementById('multiGymSelection');
        const singleGymSelection = document.getElementById('singleGymSelection');
        const customerFields = document.getElementById('customerFields');

        function toggleGymSelection() {
            const selectedRole = roleSelect.value;
            if (selectedRole === 'Super Administrador' || selectedRole === 'Administrador') {
                multiGymSelection.style.display = 'block';
                singleGymSelection.style.display = 'none';
                customerFields.style.display = 'none';
                clearMembershipFields();
            } else if (selectedRole === 'Staff' || selectedRole === 'Cliente' || selectedRole === 'Checador') {
                multiGymSelection.style.display = 'none';
                singleGymSelection.style.display = 'block';
                if (selectedRole === 'Cliente') {
                    customerFields.style.display = 'block';
                } else {
                    customerFields.style.display = 'none';
                    clearMembershipFields();
                }
            } else {
                multiGymSelection.style.display = 'none';
                singleGymSelection.style.display = 'none';
                customerFields.style.display = 'none';
                clearMembershipFields();
            }
        }

        function clearMembershipFields() {
            const membershipSelect = document.getElementById('id_membership');
            const priceInput = document.getElementById('price');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            membershipSelect.innerHTML = '<option value="" disabled selected>Selecciona una Membresía</option>';
            priceInput.value = '';
            startDateInput.value = '';
            endDateInput.value = '';
        }

        roleSelect.addEventListener('change', toggleGymSelection);
        toggleGymSelection(); // Ejecutar al cargar la página
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role');
        const passwordFields = document.getElementById('passwordFields');
        const passwordInput = document.getElementById('password');
        const emailInput = document.getElementById('email');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const emailLabel = document.getElementById('email-label');

        const singleGymSelect = document.getElementById('single_gym');
        const membershipSelect = document.getElementById('id_membership');
        const priceInput = document.getElementById('price');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const startDateContainer = document.getElementById('start_date_container');
        const endDateContainer = document.getElementById('end_date_container');

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
                membershipSelect.removeAttribute('required');
                membershipSelect.value = '';
                startDateInput.removeAttribute('required');
                startDateInput.value = '';
                endDateInput.removeAttribute('required');
                endDateInput.value = '';
                passwordFields.style.display = 'block';
                passwordInput.setAttribute('required', 'required');
                emailInput.setAttribute('required', 'required');
                passwordConfirmationInput.setAttribute('required', 'required');
                emailLabel.textContent = '*';
            }
        }

        roleSelect.addEventListener('change', toggleFields);
        toggleFields(); // Para ejecutar al cargar la página

      

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

        singleGymSelect.addEventListener('change', function() {
            const selectedGymId = this.value;
            updateMembershipOptions(selectedGymId);
        });

        membershipSelect.addEventListener('change', function() {
            const selectedMembership = this.options[this.selectedIndex];
            const durationType = selectedMembership.getAttribute('data-duration-type');
            const price = selectedMembership.getAttribute('data-price');

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

        async function updateMembershipOptions(gymId) {
            const response = await fetch(`/gyms/${gymId}/memberships`);
            const data = await response.json();
            membershipSelect.innerHTML = '<option value="" disabled selected>Selecciona una Membresía</option>';
            data.forEach(membership => {
                const option = document.createElement('option');
                option.value = membership.id;
                option.setAttribute('data-duration-type', membership.duration_type);
                option.setAttribute('data-price', membership.price);
                option.textContent = membership.name;
                membershipSelect.appendChild(option);
            });
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

@endsection
