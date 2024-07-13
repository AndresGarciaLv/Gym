@extends('layouts.panel')

@section('titulo')
   Renovar Membresía
@endsection

@section('contenido')
<style>
    .cursor-not-allowed {
        cursor: not-allowed;
    }
</style>

<h1 class="text-3xl font-bold text-center uppercase">Renovar Membresía</h1>
<h2 class="text-xl font-semibold text-center mt-2 uppercase">{{ $gym->name }}</h2>
<div class="mt-5">
    <div class="w-[600px] mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 flex flex-col justify-center w-full">

                @if($errors->any())
                    <div class="mb-4">
                        <div class="text-red-500 text-sm">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form id="userMembershipForm" action="{{ route('admin.user-memberships.storeRenewal', $userMembership->id) }}" method="POST">
                    @csrf

                    <input type="hidden" name="id_user" value="{{ $user->id }}">
                    <input type="hidden" name="id_gym" value="{{ $gym->id }}">

                    <div class="mb-4 w-full">
                        <label for="user" class="block text-sm font-medium text-gray-700 mb-2">
                            Usuario
                        </label>
                        <input type="text" value="{{ $user->name }}" class="cursor-not-allowed shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 bg-gray-300" disabled>
                    </div>
                    <div class="mb-4 w-full">
                        <label for="user" class="block text-sm font-medium text-gray-700 mb-2">
                            Código de Usuario
                        </label>
                        <input type="text" value="{{ $user->code }}" class="cursor-not-allowed shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 bg-gray-300" disabled>
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
                            @foreach ($memberships as $membership)
                                <option value="{{ $membership->id }}" {{ $membership->id == $userMembership->id_membership ? 'selected' : '' }}>
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
                                value="{{ \Carbon\Carbon::parse($userMembership->end_date)->addDay()->format('Y-m-d') }}"
                                class="shadow-sm rounded-md w-full px-3 py-2 bg-gray-300 border border-gray-400 focus:outline-none pl-10"
                                style="cursor: not-allowed;"
                                readonly
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
                        Renovar Membresía
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

        // Inicializar flatpickr para la fecha de inicio, pero deshabilitado
        flatpickr(startDateInput, {
            locale: 'es',
            dateFormat: 'Y-m-d',
            defaultDate: '{{ \Carbon\Carbon::parse($userMembership->end_date)->addDay()->format('Y-m-d') }}',
            allowInput: false,
            clickOpens: false
        });

        // Inicializar flatpickr para la fecha de fin
        flatpickr(endDateInput, {
            locale: 'es',
            dateFormat: 'Y-m-d'
        });

        membershipSelect.addEventListener('change', function() {
            const selectedMembershipId = membershipSelect.value;
            const memberships = @json($memberships);
            const selectedMembership = memberships.find(mem => mem.id == selectedMembershipId);

            const startDate = new Date(startDateInput.value);
            let endDate = new Date(startDate);

            if (selectedMembership) {
                switch (selectedMembership.duration_type) {
                    case 'Semanal':
                        endDate.setDate(startDate.getDate() + 8);
                        break;
                        case 'Mensual':
                            // Calculate end date based on the start date
                            endDate.setDate(startDate.getDate() + 32);

                            // Ajustar la fecha de finalización para días en febrero
                            if (startDate.getMonth() === 1 && endDate.getMonth() === 2 && endDate.getDate() !== startDate.getDate()) {
                                endDate.setDate(startDate.getDate()+1);
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
                        endDate.setDate(startDate.getDate() + 1);
                        break;
                    default:
                        endDate = null;
                }
            }

            if (endDate) {
                endDate.setHours(23, 59, 0);
                document.getElementById('end_date')._flatpickr.setDate(endDate);
            }
        });

        // Trigger change event to calculate end date initially
        membershipSelect.dispatchEvent(new Event('change'));
    });
</script>
@endsection
