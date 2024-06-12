@extends('layouts.panel')

@section('titulo')
  Check-in/Out
@endsection

@section('contenido')
  <h1 class="text-3xl font-bold text-center uppercase">CHECK IN / OUT</h1>
  <div class="mt-5">
      <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
          <div class="overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">

                  <form method="POST" action="{{ route('admin.gym-log.logAction') }}">
                      @csrf
                      <input type="text" name="code" placeholder="Ingresa el código del usuario" class="border p-2 rounded" required />
                      <input type="hidden" name="id_gym" value="1"> <!-- Suponiendo un ID de gimnasio fijo -->
                      <button type="submit" class="ml-2 p-2 bg-blue-500 text-white rounded">Buscar</button>
                      @if ($errors->has('code'))
                          <div class="text-red-500 mt-2">{{ $errors->first('code') }}</div>
                      @endif
                  </form>

                  @if (session('message'))
                      <div class="p-6 mt-6 bg-green-100 text-green-700 border border-green-400 rounded-lg">
                          {{ session('message') }}
                      </div>
                  @endif

              </div>
          </div>
      </div>
  </div>
@endsection
