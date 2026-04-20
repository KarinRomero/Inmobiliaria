<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nueva Propiedad
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('propiedades.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nombre/Titulo -->
                            <div class="mb-4">
                                <x-input-label for="nombre_titulo" value="Nombre / Título" />
                                <x-text-input id="nombre_titulo" class="block mt-1 w-full" type="text" name="nombre_titulo" :value="old('nombre_titulo')" required />
                                <x-input-error :messages="$errors->get('nombre_titulo')" class="mt-2" />
                            </div>

                            <!-- Tipo -->
                            <div class="mb-4">
                                <x-input-label for="tipo" value="Tipo" />
                                <select id="tipo" name="tipo" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="casa" @selected(old('tipo') == 'casa' )>Casa</option>
                                    <option value="depto" @selected(old('tipo') == 'depto' )>Departamento</option>
                                    <option value="terreno" @selected(old('tipo') == 'terreno' )>Terreno</option>
                                    <option value="local" @selected(old('tipo') == 'local' )>Local</option>
                                    <option value="galpon" @selected(old('tipo') == 'galpon' )>Galpon</option>
                                </select>
                                <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                            </div>

                            <!-- Direccion -->
                            <div class="mb-4 md:col-span-2">
                                <x-input-label for="direccion" value="Dirección" />
                                <x-text-input id="direccion" class="block mt-1 w-full" type="text" name="direccion" :value="old('direccion')" required />
                                <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                            </div>

                            <!-- Precio -->
                            <div class="mb-4">
                                <x-input-label for="precio" value="Precio" />
                                <x-text-input id="precio" class="block mt-1 w-full" type="number" min="1" step="0.01" name="precio" :value="old('precio')" required />
                                <x-input-error :messages="$errors->get('precio')" class="mt-2" />
                            </div>

                            <!-- Estado -->
                            <div class="mb-4">
                                <x-input-label for="estado" value="Estado" />
                                <select id="estado" name="estado" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="DISPONIBLE" {{ old('estado') == 'DISPONIBLE' ? 'selected' : '' }}>Disponible</option>
                                    <option value="RESERVADA" {{ old('estado') == 'RESERVADA' ? 'selected' : '' }}>Reservada</option>
                                    <option value="VENDIDA" {{ old('estado') == 'VENDIDA' ? 'selected' : '' }}>Vendida</option>
                                </select>
                                <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                            </div>

                            <!-- Superficie -->
                            <div class="mb-4">
                                <x-input-label for="superficie_m2" value="Superficie m²" />
                                <x-text-input id="superficie_m2" required class="block mt-1 w-full" type="number" min="1" name="superficie_m2" :value="old('superficie_m2')" />
                                <x-input-error :messages="$errors->get('superficie_m2')" class="mt-2" />
                            </div>

                            <!-- Ambientes -->
                            <div class="mb-4">
                                <x-input-label for="ambientes" value="Ambientes" />
                                <x-text-input id="ambientes" required class="block mt-1 w-full" type="number" min="1" name="ambientes" :value="old('ambientes')" />
                                <x-input-error :messages="$errors->get('ambientes')" class="mt-2" />
                            </div>

                            <!-- Descripcion -->
                            <div class="mb-4 md:col-span-2">
                                <x-input-label for="descripcion" value="Descripción" />
                                <textarea id="descripcion" name="descripcion" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('descripcion') }}</textarea>
                                <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                            </div>
                        </div>

                            <!-- Responsable -->
                            <div class="mb-4">
                                <x-input-label for="responsable_id" value="Responsable" />
                                <select id="responsable_id" name="responsable_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                  <option value="">Seleccionar responsable</option>
                                  @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}" @selected(old('responsable_id') == $usuario->id)>
                                        {{ $usuario->nombre }}
                                    </option>
                                  @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('responsable_id')" class="mt-2" />
                            </div>

                            <!-- Imagen URL - Simple por ahora -->
                            <div class="mb-4">
                                 <x-input-label for="imagen" value="URL de Imagen" />
                                 <x-text-input
                                    id="imagen"
                                    name="imagenes[]"
                                    type="url"
                                    class="mt-1 block w-full"
                                    :value="old('imagenes.0')"
                                    placeholder="https://ejemplo.com/foto.jpg"
                                   />
                                 <x-input-error :messages="$errors->get('imagenes.0')" class="mt-2" />
                            </div>


                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('propiedades.index') }}" class="mr-4 text-gray-600">Cancelar</a>
                            <x-primary-button>
                                Guardar Propiedad
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>