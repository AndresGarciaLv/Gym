@extends('layouts.panel')

@section('titulo')
   Información del Usuario
@endsection

@section('contenido')
<h1 class="text-3xl font-bold text-center uppercase">Detalles del Usuario</h1>
<div class=" mt-5">
    <div class="w-[600px] mx-auto sm:px-6 lg:px-8">
        
        <div class="overflow-hidden shadow-sm sm:rounded-lg ">
            <div class="p-6 bg-white border-b border-gray-200 flex items-center justify-center w-full">
        
                                <form action="{{route('admin.users.update',$user->id)}}" method="POST">
                                    @csrf
                                    @method('put')
                                    <label for="name" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">Nombre</label>
                                    <input class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] mb-4"
                                    type="text" name="name" placeholder="Nombre" value="{{$user->name}}">
                                    @error('name')
                                    <div style="color:red">
                                        {{$message}}
                                    </div>
                                    @enderror
                                    <label for="email" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">Correo Electrónico</label>
                                    <input class="shadow-sm rounded-md w-full px-3 py-2 border cursor-not-allowed bg-gray-200 border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] mb-4"
                                     type="email" disabled name="email" placeholder="correo electrónico" value="{{$user->email}}">
                                    @error('email')
                                    <div style="color:red">
                                        {{$message}}
                                    </div>
                                    @enderror

                                    <label for="phone_number" class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">Número de Telefono</label>
                                    <input class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] mb-4"
                                     type="phone_number" placeholder="Numero de telefono" value="{{$user->phone_number}}">
                                    @error('phone_number')
                                    <div style="color:red">
                                        {{$message}}
                                    </div>
                                    @enderror

                                    <div class="mb-4 w-full">
                                        <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Nacimiento</label>
                                        <input
                                          type="date"
                                          name="birthdate"
                                          placeholder="Fecha de nacimiento"
                                          value="{{$user->birthdate}}"
                                          class="shadow-sm rounded-md w-full px-3 py-2 border border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001]"
                                        />
                                      </div>
            
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-400 mb-5"
                                    for="role">Rol:</label>
                                    <select class="shadow-sm rounded-md w-full px-3 py-2 border cursor-pointer border-gray-400 focus:outline-none focus:ring-[#7F0001] focus:border-[#7F0001] mb-4"
                                     name="role" id="role" required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" {{ $userRole && $userRole->name == $role->name ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
            @error('role')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
                                    
                                    <button type="submit" class="block mt-3 border  p-2 rounded-lg text-white bg-[#03A6A6] hover:bg-[#03A696] mb-5">Actualizar Usuario</button>
                                    </form>

                </div>
                
            </div>
        </div>
    </div>
</div>

@endsection