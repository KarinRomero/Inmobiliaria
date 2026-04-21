<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $propiedad->nombre_titulo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    {{-- Badge de estado --}}
                    @php
                        $estadoClasses = [
                            'Disponible' => 'bg-green-100 text-green-800',
                            'Reservada' => 'bg-yellow-100 text-yellow-800',
                            'Vendida' => 'bg-red-100 text-red-800',
                        ];
                    @endphp
                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $estadoClasses[$propiedad->estado] ?? 'bg-gray-100' }}">
                        {{ $propiedad->estado }}
                    </span>

                    {{-- Galería de imágenes --}}
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        @forelse($propiedad->imagenes as $imagen)
                            <img src="{{ asset('storage/' . $imagen->url_imagen) }}" 
                                 alt="Foto de {{ $propiedad->nombre_titulo }}"
                                 class="w-full h-64 object-cover rounded-lg shadow">
                        @empty
                            <div class="col-span-3 h-64 bg-gray-100 flex items-center justify-center rounded-lg">
                                <span class="text-gray-400">Sin Imágenes</span>
                            </div>
                        @endforelse
                    </div>

                    {{-- Datos de la propiedad --}}
                    <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Precio</p>
                            <p class="text-2xl font-bold text-blue-600">${{ number_format($propiedad->precio, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tipo</p>
                            <p class="font-semibold">{{ $propiedad->tipo }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Superficie</p>
                            <p class="font-semibold">{{ $propiedad->superficie_m2 }} m²</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Ambientes</p>
                            <p class="font-semibold">{{ $propiedad->ambientes ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <p class="text-sm text-gray-500">Dirección</p>
                        <p class="font-semibold">{{ $propiedad->direccion }}</p>
                    </div>

                    <div class="mt-4">
                        <dt class="text-sm text-gray-500">Responsable</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">
                            {{ $propiedad->responsable->nombre ?? 'Sin asignar' }}
                        </dd>
                   </div>


                    <div class="mt-4">
                        <p class="text-sm text-gray-500">Descripción</p>
                        <p class="text-gray-700">{{ $propiedad->descripcion ?? 'Sin descripción' }}</p>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('propiedades.index') }}" 
                           class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">
                            ← Volver al catálogo
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>