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
                    
                    <form method="POST" action="{{ route('propiedades.store') }}" enctype="multipart/form-data">
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
                                    <option value="Casa" @selected(old('Tipo') == 'Casa' )>Casa</option>
                                    <option value="Departamento" @selected(old('tipo') == 'Departamento' )>Departamento</option>
                                    <option value="Terreno" @selected(old('tipo') == 'Terreno' )>Terreno</option>
                                    <option value="Local" @selected(old('tipo') == 'Local' )>Local</option>
                                    <option value="Galpón" @selected(old('tipo') == 'Galpón' )>Galpón</option>
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
                                    <option value="DISPONIBLE" @selected(old( 'estado' ) == 'DISPONIBLE' )>Disponible</option>
                                    <option value="RESERVADA" @selected(old( 'estado' ) == 'RESERVADA' )>Reservada</option>
                                    <option value="VENDIDA" @selected(old('estado' ) == 'VENDIDA')>Vendida</option>
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
                                <x-text-input id="ambientes" required class="block mt-1 w-full" type="number" min="0" name="ambientes" :value="old('ambientes')" />
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

                            <!-- Imagenes - Subida de archivos multiple -->
                            <div class="mb-4">
                               <x-input-label for="imagenes" value="Imágenes de la propiedad *" />
                                 <input 
                                     id="imagenes"
                                     name="imagenes[]" 
                                     type="file"
                                     multiple
                                     required
                                     accept="image/jpeg,image/png,image/jpg,image/webp,image/avif"
                                     class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-gray-800 file:text-white hover:file:bg-gray-700"
                                 />
                               <x-input-error :messages="$errors->get('imagenes')" class="mt-2" />
                               <x-input-error :messages="$errors->get('imagenes.*')" class="mt-2" />
                               <p class="text-xs text-gray-500 mt-1">Subí mínimo 1 foto. La primera será la portada. Máx 4MB c/u.</p>
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