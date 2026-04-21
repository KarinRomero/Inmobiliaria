# Sistema de Gestión de Propiedades - Test Técnico Evolvere

Sistema web desarrollado en Laravel para la gestión de propiedades inmobiliarias. Proyecto realizado como parte del proceso de evaluación técnica para Evolvere.

## Descripción general del sistema
Aplicación que permite administrar propiedades con diferentes niveles de acceso según el rol del usuario. Incluye autenticación, ABM de propiedades con carga de imágenes, sistema de auditoría de cambios y notificaciones automáticas por email al cargar nuevas propiedades.

## Stack Tecnológico
- *Backend:* PHP 8.2 / Laravel 12
- *Base de datos:* MySQL 8.0
- *Frontend:* Blade + TailwindCSS + Vite
- *Autenticación:* Laravel Breeze
- *Email:* SMTP vía Laravel Mail

## Funcionalidades implementadas
1. *Portada/Landing:* Pantalla de bienvenida con acceso al login.
2. *Autenticación:* Sistema de login que reconoce el perfil y habilita funcionalidades según permisos.
3. *ABM de Propiedades:* Carga, edición y eliminación de propiedades con validaciones.
4. *Carga de imágenes:* Soporte para una o más imágenes por propiedad.
5. *Filtros:* Búsqueda por tipo, estado, rango de precio, superficie y ambientes.
6. *Auditoría de cambios:* Registro automático de toda acción sobre propiedades. Guarda usuario, acción, fecha/hora, valores anteriores y nuevos. Historial consultable desde el sistema.
7. *Notificación por email:* Envío automático al cargar una nueva propiedad con los datos principales.

## Perfiles de usuario y sus permisos

### ADMINISTRADOR
- Cargar nueva propiedad
- Editar cualquier propiedad, incluido el precio
- Eliminar cualquier propiedad
- Ver historial de auditoría completo

### OPERARIO
- Cargar nueva propiedad
- Editar propiedades, excepto el precio
- No puede eliminar propiedades
- No puede ver el historial de auditoría

## Instrucciones básicas para correr el proyecto localmente

### 1. Requisitos previos
- PHP >= 8.2
- Composer
- MySQL
- Node.js >= 18.x y NPM

### 2. Instalación
```bash
# Clonar repositorio
git clone https://github.com/KarinRomero/Inmobiliaria.git
cd Inmobiliaria

# Instalar dependencias
composer install
npm install

# Configurar entorno
cp.env.example.env
php artisan key:generate

#Configurar Base de datos y mail en .env.example
php artisan storage:link
php artisan migrate:fresh --seed
npm run build
php artisan serve

#Usuarios de prueba
// Admin
User::create([
    'name' => 'Admin',
    'email' => 'admin@inmobiliaria.com',
    'password' => Hash::make('password'),
    'role' => 'admin'
]);

// Operario  
User::create([
    'name' => 'Operario',
    'email' => 'test@test.com', 
    'password' => Hash::make('password'),
    'role' => 'operario'
]);
