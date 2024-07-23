@extends('layouts.panel')

@section('titulo')
   Seguridad de Cuenta
@endsection

@section('contenido')

<div class="mt-5">
    <div class="mx-auto sm:px-6 lg:px-8">
        <div class="flex space-x-2 mb-5">
            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 border hover:border-[#7F0001] hover:text-[#7F0001] font-semibold rounded text-gray-700 transition">
                <i class='bx bx-user text-lg mr-2'></i>
                Mi Cuenta
            </a>
            <a href="{{ route('profile.security') }}"  class="flex items-center px-4 py-2 border border-[#7F0001] bg-[#7F0001] text-white font-semibold rounded hover:bg-[#5E0409] hover:text-white transition">
                <i class='bx bx-lock-alt text-lg mr-2'></i>
                Seguridad
            </a>


        </div>


        <div class="overflow-hidden shadow-sm sm:rounded-lg ">
            <div class="p-6 bg-white border-b border-gray-200 w-full">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const removePhotoButton = document.getElementById('removePhotoButton');
        const removePhotoInput = document.getElementById('removePhotoInput');
        const image = document.getElementById('image');

        if (removePhotoButton) {
            removePhotoButton.addEventListener('click', function () {
                removePhotoInput.value = '1';
                image.src = '{{ asset('fotos/avatar.webp') }}';
            });
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr('#birthdate', {
            locale: 'es',
            dateFormat: 'Y-m-d'
        });
    });
</script>
@endsection


