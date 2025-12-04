document.addEventListener('DOMContentLoaded', () => {
    const btnHacerPedido = document.querySelectorAll(".btn-hacer-pedido");

    btnHacerPedido.forEach(btn => {
        btn.addEventListener("click", () => {
            const card = btn.closest(".card-producto");
            if (!card) return;

            const producto = {
                nombre: card.getAttribute("data-nombre"),
                sku: card.getAttribute("data-sku"),
                precio: card.getAttribute("data-precio"),
                imagen: card.getAttribute("data-imagen") || ""
            };

            // Guardamos el producto para usarlo en pedidos.php
            localStorage.setItem("productoSeleccionado", JSON.stringify(producto));

            // productos.php y pedidos.php están en la misma carpeta (frontend/pages)
            window.location.href = "pedidos.php";
        });
    });
});
