@extends('layouts.panel')

@section('titulo')
Historial de Membresías
@endsection

@section('contenido')
<h1 class="text-3xl font-bold text-center uppercase">Historial de Membresias</h1>
<h2 class="text-xl font-semibold text-center mt-2 uppercase">{{ $user->name }}</h2>
<div class="mb-10 mt-5">
    <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
        
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
        
                <livewire:user-membership.history-index :userId="$user->id" :gymId="$gymId" />
            </div>
        </div>
    </div>
</div>
@endsection