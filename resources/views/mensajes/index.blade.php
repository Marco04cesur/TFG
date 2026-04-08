@foreach($matchings as $matching)
    @php
        // Identificar cuál de los dos perros no es el mío
        $perroChat = in_array($matching->perro_id_1, $misPerrosIds) 
                     ? $matching->perro2 
                     : $matching->perro1;
    @endphp

    <a href="{{ route('mensajes.show', $matching->id) }}" class="list-group-item list-group-item-action">
        <div class="d-flex align-items-center">
            <img src="{{ asset('storage/' . $perroChat->foto_url) }}" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
            <div>
                <strong>{{ $perroChat->nombre }}</strong>
                <p class="mb-0 small text-muted">Haz clic para chatear</p>
            </div>
        </div>
    </a>
@endforeach