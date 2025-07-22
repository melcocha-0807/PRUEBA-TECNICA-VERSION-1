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
    document.querySelectorAll('.edit-product').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const productId = this.getAttribute('data-id');
            const productRow = this.closest('tr');
            const productName = productRow.querySelector('td:nth-child(2)').textContent.trim();
            const productQuantity = productRow.querySelector('td:nth-child(4)').textContent.trim();
            const productValue = productRow.querySelector('td:nth-child(5)').textContent.replace('$', '').replace(',', '').trim();
            const productCategory = productRow.querySelector('td:nth-child(3)').textContent.trim();

            document.getElementById('edit_nombres').value = productName;
            document.getElementById('edit_cantidad').value = productQuantity;
            document.getElementById('edit_valor').value = productValue;

            const categorySelect = document.getElementById('edit_categoria_id');
            for (let i = 0; i < categorySelect.options.length; i++) {
                if (categorySelect.options[i].text.trim() === productCategory) {
                    categorySelect.selectedIndex = i;
                    break;
                }
            }

            const editForm = document.getElementById('editForm');
            editForm.action = `/productos-auxiliar/${productId}/editar`;
        });
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
