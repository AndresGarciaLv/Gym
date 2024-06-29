@extends('layouts.panel')

@section('titulo')
   Editar Gimnasio
@endsection

@section('contenido')
<h1 class="text-3xl font-bold text-center uppercase">Editar {{ $gym->name }}</h1>
<div class="mt-5">
    <div class="w-[600px] mx-auto sm:px-6 lg:px-8">

        <div class="overflow-hidden shadow-sm sm:rounded-lg ">
            <div class="p-6 bg-white border-b border-gray-200 flex flex-col items-center  justify-center w-full">


                <form action="{{route('admin.gyms.update', $gym->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')


                      <!-- Foto de Perfil -->
                      <div class="mb-5 text-center">
                        <div class="mx-auto w-32 h-32 mb-2 border rounded-full relative bg-gray-100 mb-4 shadow-inset">
                            <img id="image" class="object-cover w-full h-32 rounded-full" src="{{ $gym->photo ? asset('storage/' . $gym->photo) : asset('fotos/Gym-default2.webp') }}" />
                        </div>

                        <label for="fileInput" type="button" class="cursor-pointer border border-gray-400 py-2 px-4 mr-2 rounded-lg shadow-sm text-left text-gray-600 bg-white hover:bg-gray-400 hover:text-white transition-colors font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="inline-flex flex-shrink-0 w-6 h-6 -mt-1 mr-1" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                <path d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                <circle cx="12" cy="13" r="3" />
                            </svg>
                            Subir Foto
                        </label>

                        @if($gym->photo)
                        <button type="button" id="removePhotoButton" class="rounded-lg border border-red-600 text-red-600 py-2 px-4 hover:bg-red-600 hover:text-white transition-colors">Eliminar Foto</button>
                        @endif

                        <input type="hidden" name="remove_photo" id="removePhotoInput" value="0">

                        <div class="mx-auto w-48 text-gray-500 text-xs text-center mt-2">Haz Click para agregar una foto</div>

                        <input name="photo" id="fileInput" accept="image/*" class="hidden" type="file"
                               onchange="let file = document.getElementById('fileInput').files[0];
                                         var reader = new FileReader();
                                         reader.onload = (e) => document.getElementById('image').src = e.target.result;
                                         reader.readAsDataURL(file);">
                        @error('photo')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

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

                    <label for="email" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">Correo Electrónico</label>
                    <input class="shadow-sm rounded-md w-full px-3 py-2 border  border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] mb-4"
                    type="email" name="email" placeholder="correo electrónico" value="{{ $gym->email }}">
                    @error('email')
                    <div style="color:red">
                        {{ $message }}
                    </div>
                    @enderror

                    <label for="phone_number" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">Número de Telefono</label>
                    <input class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] mb-4"
                    type="text" name="phone_number" maxlength="10" pattern="\d{0,10}" placeholder="Numero de telefono" value="{{ $gym->phone_number }}">
                    @error('phone_number')
                    <div style="color:red">
                        {{ $message }}
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
                        <button type="submit"  class="mt-3 w-full py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#03A6A6] hover:bg-[#038686] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#03A6A6]">Actualizar Gimnasio</button>
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

        const removePhotoButton = document.getElementById('removePhotoButton');
        const removePhotoInput = document.getElementById('removePhotoInput');
        const image = document.getElementById('image');

        if (removePhotoButton) {
            removePhotoButton.addEventListener('click', function () {
                removePhotoInput.value = '1';
                image.src = '{{ asset('fotos/Gym-default2.webp') }}';
            });
        }
    });
</script>
