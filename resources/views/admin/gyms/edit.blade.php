@extends('layouts.panel')

@section('titulo')
   Editar Gimnasio
@endsection

@section('contenido')
<h1 class="text-3xl font-bold text-center mt-5 uppercase">Editar {{ $gym->name }}</h1>
<div class="mb-10 mt-5">
    <div class="w-[600px] mx-auto sm:px-6 lg:px-8">
        
        <div class="overflow-hidden shadow-sm sm:rounded-lg ">
            <div class="p-6 bg-white border-b border-gray-200 flex flex-col items-center  justify-center w-full">
                {{-- Alerta SUCCESS --}}
                @if(session('success'))
                <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 mb-4 mt-1 py-3 rounded relative"
                    role="alert">
                    <i class='bx bxs-check-shield'></i> <strong class="font-bold">{{ session('success') }}</strong>
                </div>
                @endif
            
                <form action="{{route('admin.gyms.update', $gym->id)}}" method="POST">
                    @csrf
                    @method('put')

                    <label for="name" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">Nombre</label>
                    <input class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] mb-4"
                           type="text" name="name" placeholder="Nombre" value="{{$gym->name}}">
                    @error('name')
                    <div style="color:red">
                        {{$message}}
                    </div>
                    @enderror

                    <label for="location" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">Dirección</label>
                    <input class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] mb-4"
                           type="text" name="location" placeholder="Dirección" value="{{$gym->location}}">
                    @error('location')
                    <div style="color:red">
                        {{$message}}
                    </div>
                    @enderror

                    <label for="isActive" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">Estado</label>
                    <select class="shadow-sm rounded-md w-full px-3 py-2 border cursor-pointer border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] mb-4"
                            name="isActive" id="isActive" required>
                        <option value="1" {{ $gym->isActive ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ !$gym->isActive ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('isActive')
                    <div style="color:red">
                        {{$message}}
                    </div>
                    @enderror

                    <div class="flex justify-between items-center">
                        <button type="submit" class="block mt-3 border p-2 rounded-lg text-white bg-[#03A6A6] hover:bg-[#03A696] mb-5">Actualizar Gimnasio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(() => {
                alert.style.display = 'none';
            }, 4000);
        }
    });
</script>
