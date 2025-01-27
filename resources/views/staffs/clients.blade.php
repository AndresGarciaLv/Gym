@extends('layouts.panel')

@section('titulo')
    Clientes
@endsection

@section('contenido')
<h1 class="text-3xl font-bold text-center mt-5 uppercase">Lista de Clientes</h1>
<h2 class="text-xl font-semibold text-center mt-2 uppercase">{{ Auth::user()->gyms()->first()->name }}</h2>
<div class="mt-5">
    <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @livewire('staff.clients')
            </div>
        </div>
    </div>
</div>
@endsection
