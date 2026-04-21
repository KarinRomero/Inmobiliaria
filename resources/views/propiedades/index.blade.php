<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catálogo de Propiedades') }}
        </h2>
        <a href="{{ route('propiedades.create') }}" 
           class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-gray-700">
            + Nueva Propiedad
        </a>
    </div>
</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- MENSAJE DE ÉXITO --}}
            @if (session('success'))
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-init="setTimeout(() => show = false, 4000)"
                     x-transition
                     class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" 
                     role="alert">
                    <strong class="font-bold">¡Listo!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Cerrar</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 0 0 1 0 1.698z"/>
                        </svg>
                    </span>
                </div>
            @endif

            {{-- MENSAJE DE ERROR --}}
            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error:</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif


            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($propiedades as $propiedad)
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition">


                        {{-- Imagen --}}
                        <div class="relative">
                            <img 
                                src="{{ $propiedad->imagenPrincipal ? asset('storage/' . $propiedad->imagenPrincipal->url_imagen) : 'https://placehold.co/600x400?text=Sin+Imagen' }}" 
                                alt="{{ $propiedad->nombre_titulo }}"
                                class="w-full h-48 object-cover"
                            >

                            
                            {{-- Badge de estado --}}
                            <span class="absolute top-2 left-2 px-2 py-1 text-xs font-bold rounded 
                                @if($propiedad->estado == 'DISPONIBLE') bg-green-500 text-white
                                @elseif($propiedad->estado == 'RESERVADA') bg-yellow-500 text-white
                                @else bg-red-500 text-white @endif">
                                {{ $propiedad->estado }}
                            </span>
                        </div>
                        
                        <div class="p-6">
                            {{-- Precio grande --}}
                            <p class="text-2xl font-bold text-indigo-600 mb-1">
                                ${{ number_format($propiedad->precio, 0, ',', '.') }}
                            </p>
                            
                            {{-- Título --}}
                            <h3 class="text-lg font-semibold text-gray-800 mb-3">
                                {{ $propiedad->nombre_titulo }}
                            </h3>

                            {{-- Datos clave: tipo, ambientes, m2 --}}
                            <div class="flex justify-between text-sm text-gray-600 mb-4 border-t border-b py-2">
                                <span class="capitalize"><strong>{{ strtolower($propiedad->tipo) }}</strong></span>
                                <span><strong>{{ $propiedad->ambientes ?? '-' }}</strong> amb.</span>
                                <span><strong>{{ $propiedad->superficie_m2 ?? '-' }}</strong> m²</span>
                            </div>

                            <p class="text-sm text-gray-500 mb-4">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                                {{ $propiedad->direccion }}
                            </p>

                            {{-- Botón Ver más --}}
                           <div class="p-4 border-t border-gray-200 flex justify-between items-center">
                               <a href="{{ route('propiedades.show', $propiedad) }}" 
                                 class="text-sm font-semibold text-blue-600 hover:text-blue-800">
                                  Ver Detalle
                               </a>
                               
                               
                               {{-- Boton editar --}}
                            
                               <div class="flex gap-2">
                                  <a href="{{ route('propiedades.edit', $propiedad) }}" 
                                    class="bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600">
                                    Editar
                                  </a>
        
                                <div x-data="{ open: false }" class="inline-block">

                                
                                 {{-- Botón Borrar --}}

                                 @if(auth()->user()->rol == 'ADMINISTRADOR')
                                 <button @click="open = true" type="button"
                                    class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700">
                                          Borrar
                                 </button>
                                @endif


                                 {{-- Modal --}}
                                 <div x-show="open" 
                                       x-cloak
                                       class="fixed inset-0 z-50 overflow-y-auto"
                                       aria-labelledby="modal-title" 
                                       role="dialog" 
                                       aria-modal="true">
        
                                 <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                 {{-- Fondo oscuro --}}
                                 <div x-show="open" 
                                     @click="open = false"
                                       x-transition:enter="ease-out duration-300"
                                       x-transition:enter-start="opacity-0"
                                       x-transition:enter-end="opacity-100"
                                       class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                                 {{-- Contenido del modal --}}
                                 <div x-show="open"
                                     x-transition:enter="ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                     class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                                 <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                   <div class="sm:flex sm:items-start">
                                     <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                          <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                           </svg>
                                        </div>
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                                Borrar propiedad
                                            </h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                            ¿Seguro que querés borrar "{{ $propiedad->nombre_titulo }}"? Se borrarán también sus fotos. Esta acción no se puede deshacer.
                                            </p>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form action="{{ route('propiedades.destroy', $propiedad) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm">
                            Sí, borrar
                        </button>
                    </form>
                    <button @click="open = false" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
                               </div>
                           </div>


                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12">
                        <p class="text-gray-500 text-lg">No hay propiedades cargadas todavía.</p>
                    </div>
                @endforelse
            </div>

            {{-- Paginación --}}
            <div class="mt-6">
                {{ $propiedades->links() }}
            </div>
        </div>
    </div>
</x-app-layout>