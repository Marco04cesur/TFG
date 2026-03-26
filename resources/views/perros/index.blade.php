<form action="{{ route('busqueda.search') }}" method="GET" class="mb-4">
    <div class="form-group mb-3">
        <label class="form-label">Raza:</label>
        <input type="text" name="raza" class="form-control" value="{{ request('raza') }}">
    </div>
    <div class="form-group mb-3">
        <label class="form-label">Sexo:</label>
        <select name="sexo" class="form-control">
            <option value="">-- Cualquiera --</option>
            <option value="macho">Macho</option>
            <option value="hembra">Hembra</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Buscar</button>
</form>
