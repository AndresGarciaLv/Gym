@extends('layouts.panel')

@section('titulo')
   Dashboard
@endsection

@section('contenido')

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 p-4 gap-4">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-[#7F0001] dark:border-gray-600 text-white font-medium group">
        <div class="flex justify-center items-center w-14 h-14 bg-gray-100 border border-[#7F0001] rounded-full transition-all duration-300 transform group-hover:rotate-12">
            <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="stroke-current text-[#7F0001] dark:text-gray-800 transform transition-transform duration-500 ease-in-out"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
      </div>
      <div class="text-right">
        <p class="text-2xl text-[#7F0001]">{{ $totalUsers }}</p>
        <p class="text-[#7F0001]">Usuarios</p>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-[#7F0001] dark:border-gray-600 text-white font-medium group">
        <div class="flex justify-center items-center w-14 h-14 bg-gray-100 border border-[#7F0001] rounded-full transition-all duration-300 transform group-hover:rotate-12">
            <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="stroke-current text-[#7F0001] dark:text-gray-800 transform transition-transform duration-500 ease-in-out">
                <rect x="5" y="9" width="1" height="8" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" fill="currentColor"/>
                <rect x="7" y="8" width="1" height="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" fill="currentColor"/>
                <rect x="9" y="7" width="1" height="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" fill="currentColor"/>
                <rect x="2" y="12" width="22" height="2" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" fill="currentColor"/>
                <rect x="16" y="7" width="1" height="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" fill="currentColor"/>
                <rect x="18" y="8" width="1" height="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" fill="currentColor"/>
                <rect x="20" y="9" width="1" height="8" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" fill="currentColor"/>
              </svg>


      </div>
      <div class="text-right">
        <p class="text-2xl text-[#7F0001]">{{ $totalGyms }}</p>
        <p class="text-[#7F0001]">Gimnasios</p>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-[#7F0001] dark:border-gray-600 text-white font-medium group">
        <div class="flex justify-center items-center w-14 h-14 bg-gray-100 border border-[#7F0001] rounded-full transition-all duration-300 transform group-hover:rotate-12">
            <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="stroke-current text-[#7F0001] dark:text-gray-800 transform transition-transform duration-500 ease-in-out">
                <rect x="2" y="5" width="20" height="14" rx="2" ry="2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                <path d="M6 11h12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                <path d="M6 15h6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
              </svg>
                    </div>
      <div class="text-right">
        <p class="text-2xl text-[#7F0001]">{{ $totalMemberships}}</p>
        <p class="text-[#7F0001]">Membresías Totales</p>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-md flex items-center justify-between p-3 border-b-4 border-[#7F0001] dark:border-gray-600 text-white font-medium group">
      <div class="flex justify-center items-center w-14 h-14 bg-gray-100 border border-[#7F0001] rounded-full transition-all duration-300 transform group-hover:rotate-12">
        <svg width="45" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="stroke-current text-[#7F0001] dark:text-gray-800 transform transition-transform duration-500 ease-in-out">
            <rect x="2" y="5" width="20" height="14" rx="2" ry="2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
            <path d="M6 11h12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
            <path d="M6 15h6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
            <circle cx="22" cy="18" r="4" fill="#7F0001"/>
            <path d="M21 18l1 1 2-2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="white" fill="none"/>
          </svg>
                </div>
      <div class="text-right">
        <p class="text-2xl text-[#7F0001]">{{ $activeMemberships }}</p>
        <p class="text-[#7F0001]">Membresías Activas</p>
      </div>
    </div>

  </div>
  <!-- ./Statistics Cards -->

  <div class="p-4">
    <p class="text-xl font-semibold">Nuevos usuarios</p>

    @livewire('dashboard.super-admin.new-users')
  </div>






<script>
   @if (session('success'))
       toastr.success("{{ session('success') }}");
   @endif
</script>
@endsection
