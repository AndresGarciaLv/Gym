@extends('layouts.panel')

@section('titulo')
   Nuevo Cliente
@endsection

@section('contenido')
<h1 class="text-3xl font-bold text-center mt-5 uppercase">Nuevo Cliente</h1>
<div class="mb-10 mt-5">
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
                        <input
                          type="date"
                          name="birthdate"
                          placeholder="Fecha de nacimiento"
                          value="{{ old('birthdate') }}"
                          class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                        />
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
                        <input
                            type="date"
                            name="start_date"
                            id="start_date"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            required
                        >
                        @error('start_date')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 w-full">
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Vencimiento <b class="text-[#FF0104]">*</b></label>
                        <input
                            type="date"
                            name="end_date"
                            id="end_date"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            required
                        >
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
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        startDateInput.addEventListener('change', function() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(startDate);
            endDate.setMonth(endDate.getMonth() + 1); // Añadir un mes
            endDateInput.value = endDate.toISOString().split('T')[0]; // Formato YYYY-MM-DD
        });
    });
</script>
@endsection