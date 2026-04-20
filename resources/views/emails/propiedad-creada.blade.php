<h2>Se cargó una nueva propiedad</h2>

<p><strong>Título:</strong> {{ $propiedad->titulo }}</p>
<p><strong>Precio:</strong> ${{ number_format($propiedad->precio, 0, ',', '.') }}</p>
<p><strong>Dirección:</strong> {{ $propiedad->direccion }}</p>
<p><strong>Tipo:</strong> {{ $propiedad->tipo }}</p>
<p><strong>Descripción:</strong> {{ $propiedad->descripcion }}</p>

<p>Ingresá al sistema para ver más detalles.</p>