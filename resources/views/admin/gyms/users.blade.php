@extends('layouts.panel')

@section('titulo')
   Gyms
@endsection

@section('contenido')

<h1 class="text-3xl font-bold text-center mt-5 uppercase">Usuarios de {{ $gym->name }}</h1>
<div class="mb-10 mt-5">
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
        
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
        
                <livewire:gym.users-gym :gymId="$gym->id" />
            </div>
        </div>
    </div>
</div>

@endsection