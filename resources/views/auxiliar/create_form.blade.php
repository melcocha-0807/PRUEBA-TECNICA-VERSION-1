<form id="form-crear-producto" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="nombres">Nombre</label>
            <input type="text" class="form-control" id="nombres" name="nombres" required>
        </div>
        <div class="form-group col-md-2">
            <label for="cantidad">Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" min="0" required>
        </div>
        <div class="form-group col-md-2">
            <label for="valor">Valor</label>
            <input type="number" class="form-control" id="valor" name="valor" min="0" required>
        </div>
        <div class="form-group col-md-2">
            <label for="descuento">Descuento (%)</label>
            <input type="number" class="form-control" id="descuento" name="descuento" min="0" max="100" value="0">
        </div>
        <div class="form-group col-md-2">
            <label for="categoria_id">Categoría</label>
            <select class="form-control" id="categoria_id" name="categoria_id" required>
                <option value="">Seleccione...</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id_categoria }}">{{ $categoria->nuevo_nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="imagen">Imagen</label>
            <input type="file" class="form-control-file" id="imagen" name="imagen">
        </div>
        <div class="form-group col-md-6 align-self-end">
            <button type="submit" class="btn btn-primary">Crear Producto</button>
        </div>
    </div>
</form>
