<!-- resources/views/components/flux-modal.blade.php -->
@props(['name'])

<div x-data="{ open: false }" 
     x-show="open" 
     x-transition 
     @open-modal.window="if($event.detail === '{{ $name }}') open = true"
     @close-modal.window="open = false"
     class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
        <button @click="open = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">✖</button>
        {{ $slot }}
    </div>
</div>