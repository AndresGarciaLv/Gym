@extends('layouts.panel')

@section('titulo')
   Editar Membresía
@endsection

@section('contenido')
<h1 class="text-3xl font-bold text-center uppercase">Editar Membresía Activa</h1>
<div class="mt-5">
    <div class="w-[600px] mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 flex flex-col justify-center w-full">

                <form id="userMembershipForm" action="{{ route('admin.user-memberships.update', $userMembership->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id_gym" value="{{ $gym->id }}">

                    <div class="mb-4 w-full">
                        <label for="userSearch" class="block text-sm font-medium text-gray-700 mb-2">
                            Usuario <b class="text-[#FF0104]">*</b>
                        </label>
                        <div class="relative">
                            <input type="text" autocomplete="off" id="userSearch" placeholder="Buscar usuario por nombre, código o correo" class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 text-gray-500 bg-gray-300 " value="{{ $userMembership->user->name }}" disabled>
                            <input type="hidden" name="id_user" id="id_user" value="{{ $userMembership->user->id }}" required>
                        </div>
                        @error('id_user')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
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
                            <option value="" disabled>Selecciona una Membresía</option>
                            @foreach ($gym->memberships as $membership)
                                <option value="{{ $membership->id }}" data-duration-type="{{ $membership->duration_type }}" @if($membership->id == $userMembership->membership->id) selected @endif>
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
                                value="{{ $userMembership->start_date }}"
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
                                value="{{ $userMembership->end_date }}"
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
                        Editar Membresía
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

        flatpickr(startDateInput, {
            locale: 'es',
            dateFormat: 'Y-m-d',
            defaultDate: startDateInput.value,
            onChange: function(selectedDates, dateStr, instance) {
                const selectedMembership = membershipSelect.options[membershipSelect.selectedIndex];
                const durationType = selectedMembership.getAttribute('data-duration-type');
                const startDate = new Date(dateStr);
                let endDate = new Date(startDate);

                switch (durationType) {
                    case 'Semanal':
                        endDate.setDate(startDate.getDate() + 8);
                        break;
                    case 'Mensual':
                        endDate.setMonth(startDate.getMonth() + 1);
                        if (endDate.getDate() !== startDate.getDate()) {
                            endDate.setDate(0); // Set to the last day of the previous month
                        }
                        break;
                    case 'Anual':
                        endDate.setFullYear(startDate.getFullYear() + 1);
                        if (endDate.getDate() !== startDate.getDate()) {
                            endDate.setDate(0); // Set to the last day of the previous month
                        }
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

        flatpickr(endDateInput, {
            locale: 'es',
            dateFormat: 'Y-m-d',
            defaultDate: endDateInput.value
        });
    });
</script>
@endsection
