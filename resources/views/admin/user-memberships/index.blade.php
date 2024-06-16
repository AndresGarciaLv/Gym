@extends('layouts.panel')

@section('titulo')
    Membresías de Usuarios
@endsection

@section('contenido')
<h1 class="text-3xl font-bold text-center uppercase">Membresías de Usuarios de</h1>
<h2 class="text-xl font-semibold text-center mt-2 uppercase">{{ $gym->name }}</h2>
<div class="mt-5">
    <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
        
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
        
                <livewire:user-membership.users-membership-index :gymId="$gym->id" />
            </div>
        </div>
    </div>
</div>
@endsection
