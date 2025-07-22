document.addEventListener('DOMContentLoaded', function () {
    let productIndex = 1;
    document.getElementById('addProduct').addEventListener('click', function () {
        if (productIndex < 3) {
            const container = document.getElementById('productos-container');
            const newProduct = document.createElement('div');
            newProduct.classList.add('form-row', 'producto-item');
            newProduct.innerHTML = `
                <div class="form-group col-md-4">
                    <label for="producto_id_${productIndex}">Producto ${productIndex + 1}</label>
                    <select class="form-control" name="productos[${productIndex}][producto_id]">
                        <option value="">Seleccione...</option>
                        ${Array.from(document.querySelectorAll('#producto_id option')).map(option => `<option value="${option.value}">${option.textContent}</option>`).join('')}
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="cantidad_venta_${productIndex}">Cantidad ${productIndex + 1}</label>
                    <input type="number" class="form-control" name="productos[${productIndex}][cantidad_venta]" min="1">
                </div>
            `;
            container.appendChild(newProduct);
            productIndex++;
        }
    });
});