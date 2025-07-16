// JS específico para el rol usuario

document.addEventListener('DOMContentLoaded', function () {
    const categoriaSelect = document.getElementById('categoria');
    if (categoriaSelect) {
        categoriaSelect.addEventListener('change', async function () {
            const categoria = this.value;
            let url = '/home';
            if (categoria) {
                url += '?categoria=' + encodeURIComponent(categoria);
            }
            try {
                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if (!response.ok) throw new Error('Error al obtener productos');
                const html = await response.text();
                // Extraer solo el HTML de productos-lista
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                const newProductos = tempDiv.querySelector('#productos-lista');
                if (newProductos) {
                    document.getElementById('productos-lista').innerHTML = newProductos.innerHTML;
                }
            } catch (error) {
                alert('No se pudieron cargar los productos.');
            }
        });
    }
});
