// backend/js/productos.js
document.addEventListener('DOMContentLoaded', () => {
    const botones = document.querySelectorAll('.btn-hacer-pedido');

    botones.forEach((boton) => {
        boton.addEventListener('click', () => {
            const card = boton.closest('.card-producto');
            if (!card) return;

            // Datos del producto para precargar el formulario
            const nombre = card.dataset.nombre || '';
            const sku = card.dataset.sku || '';
            const precio = card.dataset.precio || '';
            const imagen = card.dataset.imagen || '';

            const productoSeleccionado = { nombre, sku, precio, imagen };
            localStorage.setItem('productoSeleccionado', JSON.stringify(productoSeleccionado));

            // Ir SIEMPRE al formulario público de pedidos
            window.location.href = 'pedidos.php';
            // (productos.php y pedidos.php están en la misma carpeta /frontend/pages)
        });
    });
});
