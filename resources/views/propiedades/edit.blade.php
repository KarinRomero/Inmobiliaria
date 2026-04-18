<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Propiedad
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('propiedades.update', ['propiedad' => $propiedad]) }}">
                        @csrf
                        @method('PUT')
                        
                        <!-- Título -->
                        <div class="mb-4">
                            <x-input-label for="nombre_titulo" value="Título" />
                            <x-text-input id="nombre_titulo" name="nombre_titulo" type="text" class="mt-1 block w-full" value="{{ old('nombre_titulo', $propiedad->nombre_titulo) }}" required />
                            <x-input-error :messages="$errors->get('nombre_titulo')" class="mt-2" />
                        </div>

                        <!-- Tipo -->
                        <!-- Tipo -->
                        <div class="mb-4">
                            <x-input-label for="tipo" value="Tipo" />
                            <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                               <option value="Casa" @selected(old('tipo', $propiedad->tipo) == 'Casa')>Casa</option>
                               <option value="Departamento" @selected(old('tipo', $propiedad->tipo) == 'Departamento')>Departamento</option>
                               <option value="Terreno" @selected(old('tipo', $propiedad->tipo) == 'Terreno')>Terreno</option>
                               <option value="Local" @selected(old('tipo', $propiedad->tipo) == 'Local')>Local</option>
                            </select>
                            <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                        </div>

                        <!-- Dirección -->
                        <div class="mb-4">
                            <x-input-label for="direccion" value="Dirección" />
                            <x-text-input id="direccion" name="direccion" type="text" class="mt-1 block w-full" value="{{ old('direccion', $propiedad->direccion) }}" required />
                            <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                        </div>

                        <!-- Precio -->
                        <div class="mb-4">
                            <x-input-label for="precio" value="Precio" />
                            <x-text-input id="precio" name="precio" type="number" min="1" step="0.01" class="mt-1 block w-full" value="{{ old('precio', $propiedad->precio) }}" required />
                            <x-input-error :messages="$errors->get('precio')" class="mt-2" />
                        </div>

                        <!-- Estado -->
                        <div class="mb-4">
                            <x-input-label for="estado" value="Estado" />
                            <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="DISPONIBLE" @selected(old('estado', $propiedad->estado) == 'DISPONIBLE')>Disponible</option>
                                <option value="RESERVADA" @selected(old('estado', $propiedad->estado) == 'RESERVADA')>Reservada</option>
                                <option value="VENDIDA" @selected(old('estado', $propiedad->estado) == 'VENDIDA')>Vendida</option>
                            </select>
                            <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                        </div>

                        <!-- Descripción -->
                        <div class="mb-4">
                            <x-input-label for="descripcion" value="Descripción" />
                            <textarea id="descripcion" name="descripcion" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('descripcion', $propiedad->descripcion) }}</textarea>
                            <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                        </div>

                        <!-- Superficie -->
                        <div class="mb-4">
                            <x-input-label for="superficie_m2" value="Superficie m2" />
                            <x-text-input id="superficie_m2" name="superficie_m2" type="number" min="1" required class="mt-1 block w-full" value="{{ old('superficie_m2', $propiedad->superficie_m2) }}" />
                            <x-input-error :messages="$errors->get('superficie_m2')" class="mt-2" />
                        </div>

                        <!-- Ambientes -->
                        <div class="mb-4">
                            <x-input-label for="ambientes" value="Ambientes" />
                            <x-text-input id="ambientes" name="ambientes" type="number" min="1" required class="mt-1 block w-full" value="{{ old('ambientes', $propiedad->ambientes) }}" />
                            <x-input-error :messages="$errors->get('ambientes')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>Actualizar</x-primary-button>
                            <a href="{{ route('propiedades.index') }}">
                                <x-secondary-button type="button">Cancelar</x-secondary-button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>