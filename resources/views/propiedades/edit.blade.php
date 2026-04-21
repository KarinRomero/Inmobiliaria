<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Propiedad: {{ $propiedad->nombre_titulo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Importante: enctype para subir archivos --}}
                    <form method="POST" action="{{ route('propiedades.update', $propiedad) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Título -->
                        <div class="mb-4">
                            <x-input-label for="nombre_titulo" value="Título" />
                            <x-text-input id="nombre_titulo" name="nombre_titulo" type="text" class="mt-1 block w-full" :value="old('nombre_titulo', $propiedad->nombre_titulo)" required />
                            <x-input-error :messages="$errors->get('nombre_titulo')" class="mt-2" />
                        </div>

                        <!-- Tipo -->
                        <div class="mb-4">
                            <x-input-label for="tipo" value="Tipo" />
                            <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                               <option value="Casa" @selected(old('tipo', $propiedad->tipo) == 'Casa')>Casa</option>
                               <option value="Departamento" @selected(old('tipo', $propiedad->tipo) == 'Departamento')>Departamento</option>
                               <option value="Terreno" @selected(old('tipo', $propiedad->tipo) == 'Terreno')>Terreno</option>
                               <option value="Local" @selected(old('tipo', $propiedad->tipo) == 'Local')>Local</option>
                               <option value="Galpón" @selected(old('tipo', $propiedad->tipo) == 'Galpón')>Galpón</option>
                            </select>
                            <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                        </div>

                        <!-- Dirección -->
                        <div class="mb-4">
                            <x-input-label for="direccion" value="Dirección" />
                            <x-text-input id="direccion" name="direccion" type="text" class="mt-1 block w-full" :value="old('direccion', $propiedad->direccion)" required />
                            <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                        </div>

                        <!-- Precio: solo si es administrador -->
                        @if(auth()->user()->rol === 'ADMINISTRADOR')
                           <div class="mb-4">
                               <x-input-label for="precio" value="Precio" />
                               <x-text-input id="precio" class="block mt-1 w-full" type="number" min="0" step="0.01" name="precio" :value="old('precio', $propiedad->precio)" required />
                               <x-input-error :messages="$errors->get('precio')" class="mt-2" />
                           </div>
                        @else
                        <div class="mb-4">
                           <x-input-label for="precio" value="Precio" />
                           <x-text-input id="precio" class="block mt-1 w-full bg-gray-100" type="text" :value="'$' . number_format($propiedad->precio, 2, ',', '.')" disabled />
                           <p class="text-sm text-gray-600 mt-1">Solo administradores pueden modificar el precio.</p>
                        </div>
                        @endif

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
                            <textarea id="descripcion" name="descripcion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('descripcion', $propiedad->descripcion) }}</textarea>
                            <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                        </div>

                        <!-- Superficie -->
                        <div class="mb-4">
                            <x-input-label for="superficie_m2" value="Superficie m2" />
                            <x-text-input id="superficie_m2" name="superficie_m2" type="number" min="0" class="mt-1 block w-full" :value="old('superficie_m2', $propiedad->superficie_m2)" />
                            <x-input-error :messages="$errors->get('superficie_m2')" class="mt-2" />
                        </div>

                        <!-- Ambientes -->
                        <div class="mb-4">
                            <x-input-label for="ambientes" value="Ambientes" />
                            <x-text-input id="ambientes" name="ambientes" type="number" min="0" class="mt-1 block w-full" :value="old('ambientes', $propiedad->ambientes)" />
                            <x-input-error :messages="$errors->get('ambientes')" class="mt-2" />
                        </div>

                        <!-- Responsable -->
                        <div class="mb-4">
                            <x-input-label for="responsable_id" value="Responsable" />
                            <select id="responsable_id" name="responsable_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach(\App\Models\Usuario::all() as $usuario)
                                <option value="{{ $usuario->id }}" @selected(old('responsable_id',$propiedad->responsable_id) == $usuario->id)>
                                    {{ $usuario->nombre }}
                                </option> {{-- ← Acá estaba el </potion> --}}
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('responsable_id')" class="mt-2" />
                        </div>

                        {{-- IMÁGENES ACTUALES --}}
                       <div class="mb-4" x-data="{ imagenesMarcadas: [] }">
    <x-input-label value="Imágenes actuales" />
    <div class="mt-2 grid grid-cols-3 gap-4">
        @forelse($propiedad->imagenes as $imagen)
            <div class="relative">
                <img src="{{ asset('storage/' . $imagen->url_imagen) }}" 
                     :class="imagenesMarcadas.includes({{ $imagen->id }}) ? 'opacity-30 grayscale' : ''"
                     class="w-full h-24 object-cover rounded transition">
                
                <label class="absolute top-1 right-1 bg-red-600 text-white text-xs px-2 py-1 rounded cursor-pointer hover:bg-red-700">
                    <input type="checkbox" 
                           name="imagenes_borrar[]" 
                           value="{{ $imagen->id }}" 
                           class="hidden"
                           @click="imagenesMarcadas.includes({{ $imagen->id }}) 
                                   ? imagenesMarcadas = imagenesMarcadas.filter(id => id !== {{ $imagen->id }}) 
                                   : imagenesMarcadas.push({{ $imagen->id }})">
                    X
                </label>

                {{-- Badge de "Se borrará" --}}
                <div x-show="imagenesMarcadas.includes({{ $imagen->id }})" 
                     x-cloak
                     class="absolute inset-0 flex items-center justify-center bg-black/60 rounded">
                    <span class="text-white text-xs font-bold">SE BORRARÁ</span>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500 col-span-3">Sin imágenes cargadas</p>
        @endforelse
    </div>
    <p class="text-xs text-gray-500 mt-1">Tildá la X. La imagen se borrará al hacer clic en ACTUALIZAR.</p>
</div>


                        {{-- SUBIR NUEVAS IMÁGENES --}}
                        <div class="mb-4">
                            <x-input-label for="imagenes" value="Agregar nuevas imágenes" />
                            <input id="imagenes" name="imagenes[]" type="file" multiple accept="image/*"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-gray-800 file:text-white" />
                            <x-input-error :messages="$errors->get('imagenes.*')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>Actualizar</x-primary-button>
                            <a href="{{ route('propiedades.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>