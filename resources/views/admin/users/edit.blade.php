@extends('layouts.panel')

@section('titulo')
   Usuarios
@endsection

@section('contenido')
<h1 class="text-3xl font-bold text-center mt-5 uppercase">Lista de usuarios</h1>
<div class="mb-10 mt-5">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
        
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
        
                                <h1 class="text-lg leading-6 font-medium text-gray-900 mt-5"></h1>
        
                                <form action="{{route('admin.users.update',$user->id)}}" method="POST">
                                    @csrf
                                    @method('put')
                                    <label for="name" class="mt-3 block text-gray-400 font-bold mb-2">Nombre</label>
                                    <input type="text" name="name" placeholder="Nombre" value="{{$user->name}}">
                                    @error('name')
                                    <div style="color:red">
                                        {{$message}}
                                    </div>
                                    @enderror
                                    <label for="email" class="mt-3 block text-gray-400 font-bold mb-2">Correo Electrónico</label>
                                    <input type="email" name="email" placeholder="correo electrónico" value="{{$user->correo_electronico}}">
                                    @error('email')
                                    <div style="color:red">
                                        {{$message}}
                                    </div>
                                    @enderror
                                    <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Rol:</label>
            <select name="role" id="role"
                class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                onchange="roleChanged()">
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}" {{ $userRole == $role->name ? 'selected' : '' }}>
                        {{ $role->name }}</option>
                @endforeach
            </select>
            @error('role')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
                                    
                                    <button type="submit" class="block mt-3 border  p-2 rounded-lg text-white bg-[#03A6A6] hover:bg-[#03A696] mb-5">Editar</button>
                                    </form>
                                </div>
        
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

@endsection