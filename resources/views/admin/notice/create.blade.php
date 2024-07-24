@extends('layouts.panel')

@section('titulo')
   Crear Aviso
@endsection

@section('contenido')
<h1 class="text-3xl font-bold text-center uppercase">Crear Aviso</h1>
<div class="mt-5">
    <div class="w-[600px] mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 flex flex-col justify-center w-full">

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <i class='bx bx-dumbbell mr-3 text-lg'></i> <strong class="font-bold">{{ session('success') }}</strong>
                    </div>
                @endif

                <form action="{{ route('notices.store') }}" method="POST">
                    @csrf

                    @if($user->hasRole('Staff'))
                        <input type="hidden" name="id_gym" value="{{ $gyms->id }}">
                    @else
                        <div class="mb-4 w-full">
                            <label for="id_gym" class="block text-sm font-medium text-gray-700 mb-2">Gimnasio <b class="text-[#FF0104]">*</b></label>
                            <select
                                name="id_gym"
                                id="id_gym"
                                class="shadow-sm rounded-md w-full px-3 py-2 border cursor-pointer border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                                required
                                @if($user->hasRole('Staff')) disabled @endif
                            >
                                <option value="" disabled selected>Selecciona el Gimnasio</option>
                                @foreach($gyms as $gym)
                                    <option value="{{ $gym->id }}" {{ $user->hasRole('Staff') && $gyms->id == $gym->id ? 'selected' : '' }}>
                                        {{ $gym->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_gym')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <div class="mb-4 w-full">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Título del Aviso <b class="text-[#FF0104]">*</b></label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            placeholder="Título"
                            value="{{ old('title') }}"
                            required
                        >
                        @error('title')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 w-full">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Contenido del Aviso <b class="text-[#FF0104]">*</b></label>
                        <textarea
                            name="content"
                            id="content"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            placeholder="Contenido"
                            required
                        >{{ old('content') }}</textarea>
                        @error('content')
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
                            <option value="" disabled selected>Selecciona el Estado</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                        @error('isActive')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="mt-3 w-full py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#03A6A6] hover:bg-[#038686] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#03A6A6]"
                    >
                        Crear Aviso
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
