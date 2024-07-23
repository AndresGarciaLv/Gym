@extends('layouts.panel')

@section('titulo')
   Editar Membresía
@endsection

@section('contenido')
<h1 class="text-3xl font-bold text-center uppercase">Editar Membresía</h1>
<div class="mt-5">
    <div class="w-[600px] mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 flex flex-col justify-center w-full">

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <i class='bx bx-dumbbell mr-3 text-lg'></i> <strong class="font-bold">{{ session('success') }}</strong>
                    </div>
                @endif

                <form action="{{ route('admin.memberships.update', $membership->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4 w-full">
                        <label for="id_gym" class="block text-sm font-medium text-gray-700 mb-2">Gimnasio <b class="text-[#FF0104]">*</b></label>
                        <select
                            name="id_gym"
                            id="id_gym"
                            class="shadow-sm rounded-md w-full px-3 py-2 border cursor-pointer border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            required
                        >
                            <option value="" disabled>Selecciona el Gimnasio</option>
                            @foreach($gyms as $gym)
                                <option value="{{ $gym->id }}" {{ $membership->id_gym == $gym->id ? 'selected' : '' }}>{{ $gym->name }}</option>
                            @endforeach
                        </select>
                        @error('id_gym')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 w-full">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre de la Membresía <b class="text-[#FF0104]">*</b></label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            placeholder="Nombre"
                            value="{{ old('name', $membership->name) }}"
                            required
                        >
                        @error('name')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 w-full">
                        <label for="duration_type" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Duración</label>
                        <select
                            name="duration_type"
                            id="duration_type"
                            class="shadow-sm rounded-md w-full px-3 py-2 border cursor-pointer border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                        >
                            <option value="" disabled {{ $membership->duration_type === null ? 'selected' : '' }}>Seleccionar</option>
                            @foreach(App\Enums\DurationType::cases() as $type)
                                <option value="{{ $type->value }}" {{ $membership->duration_type === $type ? 'selected' : '' }}>{{ $type->value }}</option>
                            @endforeach
                        </select>
                        @error('duration_type')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 w-full">
                        <label for="isActive" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">Estado</label>
                    <select class="shadow-sm rounded-md w-full px-3 py-2 border cursor-pointer border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] mb-4"
                            name="isActive" id="isActive" required>
                        <option value="1" {{ $membership->isActive ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ !$membership->isActive ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('isActive')
                    <div style="color:red">
                        {{ $message }}
                    </div>
                    @enderror
                    </div>



                    <div class="mb-4 w-full">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                        <textarea
                            name="description"
                            id="description"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            placeholder="Descripción"
                        >{{ old('description', $membership->description) }}</textarea>
                        @error('description')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 w-full">
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Precio <b class="text-[#FF0104]">*</b></label>
                        <input
                            type="number"
                            name="price"
                            id="price"
                            class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                            placeholder="Precio"
                            step="0.01"
                            value="{{ old('price', $membership->price) }}"
                            required
                        >
                        @error('price')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="mt-3 w-full py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#03A6A6] hover:bg-[#038686] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#03A6A6]"
                    >
                        Actualizar Membresía
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
