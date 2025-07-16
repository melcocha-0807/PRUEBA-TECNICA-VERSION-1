<form class="form-editar-producto" method="POST" enctype="multipart/form-data" data-id="{{ $producto->id }}">
    @csrf
    @method('PUT')
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="nombres_{{ $producto->id }}">Nombre</label>
            <input type="text" class="form-control" id="nombres_{{ $producto->id }}" name="nombres" value="{{ $producto->nombres }}" required>
        </div>
        <div class="form-group col-md-2">
            <label for="cantidad_{{ $producto->id }}">Cantidad</label>
            <input type="number" class="form-control" id="cantidad_{{ $producto->id }}" name="cantidad" min="0" value="{{ $producto->cantidad }}" required>
        </div>
        <div class="form-group col-md-2">
            <label for="valor_{{ $producto->id }}">Valor</label>
            <input type="number" class="form-control" id="valor_{{ $producto->id }}" name="valor" min="0" value="{{ $producto->valor }}" required>
        </div>
        <div class="form-group col-md-2">
            <label for="descuento_{{ $producto->id }}">Descuento (%)</label>
            <input type="number" class="form-control" id="descuento_{{ $producto->id }}" name="descuento" min="0" max="100" value="{{ $producto->descuento }}">
        </div>
        <div class="form-group col-md-2">
            <label for="categoria_id_{{ $producto->id }}">Categoría</label>
            <select class="form-control" id="categoria_id_{{ $producto->id }}" name="categoria_id" required>
                <option value="">Seleccione...</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id_categoria }}" @if($producto->categoria_id == $categoria->id_categoria) selected @endif>{{ $categoria->nuevo_nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="imagen_{{ $producto->id }}">Imagen</label>
            <input type="file" class="form-control-file" id="imagen_{{ $producto->id }}" name="imagen">
        </div>
        <div class="form-group col-md-6 align-self-end">
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
    </div>
</form>
