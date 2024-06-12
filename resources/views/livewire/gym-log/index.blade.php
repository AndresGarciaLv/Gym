<div id="app">
    <input type="text" wire:model.debounce.500ms="code" placeholder="Ingresa el código del usuario" class="border p-2 rounded" />



        <div class="p-6 mt-6 bg-white dark:bg-gray-800 shadow rounded-lg">
            @if($user)
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ $user->name }}
                </h2>
                <img class="rounded-full" src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('fotos/avatar.webp') }}" alt="Foto del usuario" width="100">
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ $message }}
                </p>
            @else
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Usuario no encontrado
                </h2>
            @endif
            <div class="mt-6 flex justify-end">
                <x-secondary-button wire:click="$set('showModal', true)">
                    {{ __('Cerrar') }}
                </x-secondary-button>
            </div>

</div>
