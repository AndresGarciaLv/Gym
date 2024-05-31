@extends('layouts.panel')

@section('titulo')
   Asignar Membresía
@endsection

@section('contenido')
<h1 class="text-3xl font-bold text-center mt-5 uppercase">Asignar Membresía</h1>
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

                    <div class="mb-4 w-full">
                        <label for="id_user" class="block text-sm font-medium text-gray-700 mb-2">Usuario <b class="text-[#FF0104]">*</b></label>
                        <select
                            name="id_user"
                            id="id_user"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            required
                        >
                            <option value="" disabled selected>Selecciona un Usuario</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }} - {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_user')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 w-full">
                        <label for="id_gym" class="block text-sm font-medium text-gray-700 mb-2">Gimnasio <b class="text-[#FF0104]">*</b></label>
                        <select
                            name="id_gym"
                            id="id_gym"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            required
                        >
                            <option value="" disabled selected>Selecciona un Gimnasio</option>
                            @foreach ($gyms as $gym)
                                <option value="{{ $gym->id }}">
                                    {{ $gym->name }}
                                </option>
                            @endforeach
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
                            disabled
                        >
                            <option value="" disabled selected>Selecciona una Membresía</option>
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
        const gymSelect = document.getElementById('id_gym');
        const membershipSelect = document.getElementById('id_membership');

        gymSelect.addEventListener('change', function() {
            const gymId = gymSelect.value;
            const gym = @json($gyms).find(gym => gym.id == gymId);

            if (gym) {
                membershipSelect.innerHTML = '<option value="" disabled selected>Selecciona una Membresía</option>';
                gym.memberships.forEach(membership => {
                    const option = document.createElement('option');
                    option.value = membership.id;
                    option.textContent = membership.name;
                    membershipSelect.appendChild(option);
                });
                membershipSelect.removeAttribute('disabled');
            } else {
                membershipSelect.innerHTML = '<option value="" disabled selected>Selecciona una Membresía</option>';
                membershipSelect.setAttribute('disabled', 'disabled');
            }
        });
    });
</script>
@endsection
