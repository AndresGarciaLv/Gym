@extends('layouts.panel')

@section('titulo')
   Membresias
@endsection

@section('contenido')

<h1 class="text-3xl font-bold text-center uppercase">Lista de Membresias</h1>
<div class="mt-5">
    <div class="max-w-10xl  mx-auto sm:px-6 lg:px-8">
        
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
        
                @livewire('membership.memberships-index')
            </div>
        </div>
    </div>
</div>

@endsection