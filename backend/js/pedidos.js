document.addEventListener('DOMContentLoaded', () => {
    console.log('pedidos.js cargado');

    const BASE_URL = '/EJ-RG-1';  // carpeta raíz de tu proyecto en localhost

    const form = document.getElementById('formPedido');
    const mensaje = document.getElementById('mensaje');
    const productoSelect = document.getElementById('producto');
    const tallaSelect = document.getElementById('talla');
    const colorSelect = document.getElementById('color');
    const cantidadInput = document.getElementById('cantidad');

    const cargarProductos = async () => {
        try {
            const res = await fetch(`${BASE_URL}/backend/api/productos.php?action=list`);
            const data = await res.json();

            console.log('respuesta productos:', data);

            productoSelect.innerHTML = '';

            if (!data.success) {
                productoSelect.innerHTML = '<option value="">Error al cargar productos</option>';
                return;
            }

            const optDefault = document.createElement('option');
            optDefault.value = '';
            optDefault.textContent = 'Selecciona un producto';
            productoSelect.appendChild(optDefault);

            data.data.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.id;
                opt.textContent = `${p.nombre} (SKU: ${p.sku}) - $${p.precio}`;
                opt.dataset.sku = p.sku;
                opt.dataset.nombre = p.nombre;
                opt.dataset.precio = p.precio;
                productoSelect.appendChild(opt);
            });

            const guardado = localStorage.getItem('productoSeleccionado');
            if (guardado) {
                const prod = JSON.parse(guardado);
                const options = Array.from(productoSelect.options);
                const coincidente = options.find(o => o.dataset.sku === prod.sku);
                if (coincidente) {
                    coincidente.selected = true;
                    cargarTallasYColores();
                }
                localStorage.removeItem('productoSeleccionado');
            }

        } catch (err) {
            console.error(err);
            productoSelect.innerHTML = '<option value="">Error al cargar</option>';
        }
    };

    const cargarTallasYColores = () => {
        if (!productoSelect.value) {
            tallaSelect.innerHTML = '<option value="">Selecciona un producto primero</option>';
            colorSelect.innerHTML = '<option value="">Selecciona un producto primero</option>';
            return;
        }

        const tallas = ['S', 'M', 'L', 'XL'];
        const colores = ['Blanco', 'Negro', 'Azul', 'Rojo'];

        tallaSelect.innerHTML = '';
        colorSelect.innerHTML = '';

        tallas.forEach(t => {
            const opt = document.createElement('option');
            opt.value = t;
            opt.textContent = t;
            tallaSelect.appendChild(opt);
        });

        colores.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c;
            opt.textContent = c;
            colorSelect.appendChild(opt);
        });
    };

    productoSelect.addEventListener('change', cargarTallasYColores);
    cargarProductos();

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const optProducto = productoSelect.options[productoSelect.selectedIndex];

        const pedido = {
            nombre_cliente: document.getElementById('nombre_cliente').value.trim(),
            telefono: document.getElementById('telefono').value.trim(),
            direccion: document.getElementById('direccion').value.trim(),
            producto_id: productoSelect.value,
            producto_nombre: optProducto ? optProducto.dataset.nombre : '',
            producto_sku: optProducto ? optProducto.dataset.sku : '',
            talla: tallaSelect.value,
            color: colorSelect.value,
            cantidad: cantidadInput.value || 1
        };

        try {
            const res = await fetch(`${BASE_URL}/backend/api/pedidos.php?action=create`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(pedido)
            });

            const data = await res.json();
            mensaje.textContent = data.message || 'Pedido procesado.';

            if (data.success) {
                mensaje.style.color = 'green';
                form.reset();
                tallaSelect.innerHTML = '<option value="">Selecciona un producto primero</option>';
                colorSelect.innerHTML = '<option value="">Selecciona un producto primero</option>';
            } else {
                mensaje.style.color = 'red';
            }
        } catch (err) {
            console.error(err);
            mensaje.style.color = 'red';
            mensaje.textContent = 'Error al enviar el pedido: ' + err;
        }
    });
});
