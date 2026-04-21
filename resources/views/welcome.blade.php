<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Inmobiliaria') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="relative min-h-screen flex flex-col items-center justify-center bg-cover bg-center" 
         style="background-image: url('{{ asset('imagenes/fondo.jpg') }}');">
        
        <!-- Capa oscura para contraste -->
        <div class="absolute inset-0 bg-black/60"></div>

        <div class="relative z-10 text-center p-6">
            <!-- Título -->
            <h1 class="text-3xl font-semibold text-white">
                Sistema Inmobiliaria
            </h1>
            
            <!-- Subtítulo -->
            <p class="mt-2 mb-8 text-lg text-gray-200">
                Gestión de propiedades
            </p>

            @if (Route::has('login'))
                <div class="flex items-center justify-center gap-4">
                    @auth
                        <a href="{{ url('/propiedades') }}" 
                           class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md">
                            Ir a Propiedades
                        </a>
                    @else
                        <!-- Botón login -->
                        <a href="{{ route('login') }}" 
                           class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md">
                            Iniciar sesión
                        </a>

                        @if (Route::has('register'))
                            <!-- Botón registro -->
                            <a href="{{ route('register') }}" 
                               class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-md">
                                Registrarse
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
</body>
</html>