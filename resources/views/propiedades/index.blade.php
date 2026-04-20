<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Listado de Propiedades
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-4">
                        <a href="{{ route('propiedades.create') }}">
                            <x-primary-button>
                                Nueva Propiedad
                            </x-primary-button>
                        </a>
                    </div>

                    @if (session('success'))
                       <div 
                           x-data="{ show: true }" 
                           x-show="show" 
                           x-init="setTimeout(() => show = false, 3000)"
                           x-transition:leave="transition ease-in duration-300"
                           x-transition:leave-start="opacity-100"
                           x-transition:leave-end="opacity-0"
                           class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded"
                        >
                           {{ session('success') }}
                        </div>
                    @endif

                    @if($propiedades->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Responsable</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($propiedades as $propiedad)
                                    <tr>
                                        <td class="px-6 py-4">{{ $propiedad->nombre_titulo }}</td>
                                        <td class="px-6 py-4">{{ ucfirst($propiedad->tipo) }}</td>
                                        <td class="px-6 py-4">${{ number_format($propiedad->precio, 2, ',', '.') }}</td>
                                        <td class="px-6 py-4">{{ $propiedad->estado }}</td>
                                        <td class="px-6 py-4">{{ $propiedad->responsable->nombre }}</td>
                                        <td class="px-6 py-4 flex gap-2">
                                            <a href="{{ route('propiedades.edit', $propiedad) }}">
                                                <x-secondary-button>Editar</x-secondary-button>
                                            </a>
    
                                            <!-- Botón que abre el modal -->

                                            @if(auth()->user()->rol=== 'ADMINISTRADOR')
                                            <form action="{{ route('propiedades.destroy',$propiedad) }}"method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                            <x-danger-button 
                                                x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'confirm-propiedad-{{ $propiedad->id }}')"
                                            >
                                                Borrar
                                            </x-danger-button>
                                            </form>
                                            @endif



                                            <!-- Modal de confirmación -->
                                            <x-modal name="confirm-propiedad-{{ $propiedad->id }}" focusable>
                                               <div class="p-6">
                                                  <h2 class="text-lg font-medium text-gray-900">
                                                      ¿Seguro que querés borrar "{{ $propiedad->nombre_titulo }}"?
                                                 </h2>

                                                 <p class="mt-1 text-sm text-gray-600">
                                                      Esta acción no se puede deshacer.
                                                 </p>
                     
                                                  <div class="mt-6 flex justify-end gap-3">
                                                       <x-secondary-button x-on:click="$dispatch('close')">
                                                          Cancelar
                                                       </x-secondary-button>

                                                       <form method="POST" action="{{ route('propiedades.destroy', $propiedad) }}">
                                                           @csrf
                                                           @method('DELETE')
                                                          <x-danger-button type="submit">
                                                             Sí, borrar
                                                          </x-danger-button>
                                                       </form>
                                                  </div>
                                              </div>
                                          </x-modal>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No hay propiedades cargadas.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>