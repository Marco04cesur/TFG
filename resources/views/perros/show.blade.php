<form action="{{ route('mensajes.store', $matching) }}" method="POST" class="mb-3">
    @csrf
    <div class="form-group">
        <textarea name="contenido" class="form-control" rows="3" placeholder="Escribe tu mensaje..." required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
</form>

<!-- Mostrar mensajes previos: -->
@foreach($matching->mensajes as $mensaje)
    <div class="mensaje mb-3 p-3 border rounded">
        <strong>{{ $mensaje->usuario->nombre }}</strong>
        <p>{{ $mensaje->contenido }}</p>
        <small>{{ $mensaje->created_at->format('d/m/Y H:i') }}</small>
    </div>
@endforeach
