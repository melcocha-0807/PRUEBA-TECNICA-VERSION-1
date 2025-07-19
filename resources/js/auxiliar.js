// JS específico para el rol auxiliar

document.addEventListener('DOMContentLoaded', function () {
    // Mostrar formulario de crear producto
    const btnMostrarCrear = document.getElementById('btn-mostrar-crear');
    const formCrearContainer = document.getElementById('form-crear-producto-container');
    if (btnMostrarCrear && formCrearContainer) {
        btnMostrarCrear.addEventListener('click', function () {
            if (formCrearContainer.style.display === 'none' || formCrearContainer.innerHTML === '') {
                fetch('/auxiliar/productos/create')
                    .then(r => r.text())
                    .then(html => {
                        formCrearContainer.innerHTML = html;
                        formCrearContainer.style.display = 'block';
                    });
            } else {
                formCrearContainer.innerHTML = '';
                formCrearContainer.style.display = 'none';
            }
        });
    }

    // Delegación para mostrar formularios de editar y eliminar
    document.getElementById('productos-tbody').addEventListener('click', async function (e) {
        const tr = e.target.closest('tr[data-producto-id]');
        if (!tr) return;
        const productoId = tr.getAttribute('data-producto-id');
        // Editar
        if (e.target.classList.contains('btn-mostrar-editar')) {
            const container = tr.querySelector('.form-editar-container');
            if (container.style.display === 'none' || container.innerHTML === '') {
                const res = await fetch(`/auxiliar/productos/${productoId}/edit`);
                const html = await res.text();
                container.innerHTML = html;
                container.style.display = 'block';
            } else {
                container.innerHTML = '';
                container.style.display = 'none';
            }
        }
        // Eliminar
        if (e.target.classList.contains('btn-mostrar-eliminar')) {
            const container = tr.querySelector('.form-eliminar-container');
            if (container.style.display === 'none' || container.innerHTML === '') {
                container.innerHTML = `<form class="form-eliminar-producto" data-id="${productoId}">
                    <p>¿Seguro que deseas eliminar este producto?</p>
                    <button type="submit" class="btn btn-danger btn-sm">Confirmar</button>
                    <button type="button" class="btn btn-secondary btn-sm btn-cancelar-eliminar">Cancelar</button>
                </form>`;
                container.style.display = 'block';
            } else {
                container.innerHTML = '';
                container.style.display = 'none';
            }
        }
    });

    // Delegación para cancelar eliminar
    document.getElementById('productos-tbody').addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-cancelar-eliminar')) {
            const form = e.target.closest('.form-eliminar-container');
            form.innerHTML = '';
            form.style.display = 'none';
        }
    });

    // Delegación para enviar formulario de eliminar
    document.getElementById('productos-tbody').addEventListener('submit', async function (e) {
        if (e.target.classList.contains('form-eliminar-producto')) {
            e.preventDefault();
            const productoId = e.target.getAttribute('data-id');
            const res = await fetch(`/auxiliar/productos/${productoId}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            if (res.ok) {
                e.target.closest('tr').remove();
            } else {
                alert('Error al eliminar producto');
            }
        }
    });
});
