<?php
// frontend/pages/clientes.php
require_once __DIR__ . '/../../backend/core/session.php';
require_login_page();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Clientes - AzuraShirts</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="wrapper container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Clientes</h1>
        <div class="d-flex gap-2 align-items-center">
            <!-- NUEVO: botón para volver al inicio del panel -->
            <a href="inicio.php" class="btn btn-outline-secondary btn-sm">
                Inicio
            </a>
            <a href="pedidos_admin.php" class="btn btn-outline-secondary btn-sm">
                Ver pedidos
            </a>
            <span class="text-muted">
                Usuario: <strong><?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? ''); ?></strong>
            </span>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">
                Cerrar sesión
            </a>
        </div>
    </div>

    <!-- FORMULARIO: CREA / EDITA -->
    <div class="card-form mb-3">
        <h2 class="h5 mb-3" id="tituloForm">Nuevo cliente</h2>

        <form id="formCliente">
            <input type="hidden" id="id" name="id">

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="telefono">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="ciudad">Ciudad</label>
                    <input type="text" class="form-control" id="ciudad" name="ciudad">
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary" id="btnGuardar">
                    Guardar
                </button>
                <button type="button" class="btn btn-secondary ms-2 d-none" id="btnCancelar">
                    Cancelar edición
                </button>
            </div>

            <p id="mensajeForm" class="mt-2"></p>
        </form>
    </div>

    <!-- TABLA: LISTA + BOTONES EDITAR / ELIMINAR -->
    <div class="tabla-wrapper">
        <p class="text-muted mb-2">
            Listado de clientes registrados en el sistema.
        </p>

        <div class="table-responsive">
            <table class="table table-sm table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Ciudad</th>
                        <th style="width: 140px;">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbodyClientes">
                    <!-- filas por JS -->
                </tbody>
            </table>
        </div>

        <p id="mensajeClientes" class="mt-2 text-center text-muted"></p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tbody          = document.getElementById('tbodyClientes');
    const msgTabla       = document.getElementById('mensajeClientes');
    const form           = document.getElementById('formCliente');
    const msgForm        = document.getElementById('mensajeForm');
    const tituloForm     = document.getElementById('tituloForm');
    const btnGuardar     = document.getElementById('btnGuardar');
    const btnCancelar    = document.getElementById('btnCancelar');

    const inputId        = document.getElementById('id');
    const inputNombre    = document.getElementById('nombre');
    const inputEmail     = document.getElementById('email');
    const inputTelefono  = document.getElementById('telefono');
    const inputCiudad    = document.getElementById('ciudad');

    const apiUrl = '../../backend/api/clientes.php';

    const resetForm = () => {
        form.reset();
        inputId.value = '';
        tituloForm.textContent = 'Nuevo cliente';
        btnGuardar.textContent = 'Guardar';
        btnCancelar.classList.add('d-none');
        msgForm.textContent = '';
    };

    const cargarClientes = async () => {
        tbody.innerHTML = '';
        msgTabla.textContent = 'Cargando clientes...';
        msgTabla.classList.remove('text-danger');
        msgTabla.classList.add('text-muted');

        try {
            const res = await fetch(apiUrl + '?action=list');
            const data = await res.json();

            if (!data.success) {
                msgTabla.textContent = data.message || 'No se pudieron cargar los clientes.';
                msgTabla.classList.remove('text-muted');
                msgTabla.classList.add('text-danger');
                return;
            }

            const clientes = data.data || [];

            if (clientes.length === 0) {
                msgTabla.textContent = 'No hay clientes registrados aún.';
                return;
            }

            msgTabla.textContent = '';

            clientes.forEach(c => {
                const tr = document.createElement('tr');
                tr.dataset.id       = c.id;
                tr.dataset.nombre   = c.nombre ?? '';
                tr.dataset.email    = c.email ?? '';
                tr.dataset.telefono = c.telefono ?? '';
                tr.dataset.ciudad   = c.ciudad ?? '';

                tr.innerHTML = `
                    <td>${c.id}</td>
                    <td>${c.nombre ?? ''}</td>
                    <td>${c.email ?? ''}</td>
                    <td>${c.telefono ?? ''}</td>
                    <td>${c.ciudad ?? ''}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary me-1 btn-editar">
                            Editar
                        </button>
                        <button class="btn btn-sm btn-outline-danger btn-eliminar">
                            Eliminar
                        </button>
                    </td>
                `;

                tbody.appendChild(tr);
            });

        } catch (error) {
            console.error(error);
            msgTabla.textContent = 'Error al conectar con la API de clientes.';
            msgTabla.classList.remove('text-muted');
            msgTabla.classList.add('text-danger');
        }
    };

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const nombre = inputNombre.value.trim();
        if (nombre === '') {
            msgForm.style.color = 'red';
            msgForm.textContent = 'El nombre es obligatorio.';
            return;
        }

        const formData = new FormData();
        formData.append('nombre', nombre);
        formData.append('email', inputEmail.value.trim());
        formData.append('telefono', inputTelefono.value.trim());
        formData.append('ciudad', inputCiudad.value.trim());

        let action = 'create';

        if (inputId.value) {
            action = 'update';
            formData.append('id', inputId.value);
        }

        try {
            const res = await fetch(apiUrl + '?action=' + action, {
                method: 'POST',
                body: formData
            });

            const data = await res.json();

            if (data.success) {
                msgForm.style.color = 'green';
                msgForm.textContent = data.message || 'Operación realizada correctamente.';
                resetForm();
                cargarClientes();
            } else {
                msgForm.style.color = 'red';
                msgForm.textContent = data.message || 'Error al guardar el cliente.';
            }
        } catch (error) {
            console.error(error);
            msgForm.style.color = 'red';
            msgForm.textContent = 'Error al conectar con la API.';
        }
    });

    btnCancelar.addEventListener('click', resetForm);

    tbody.addEventListener('click', async (e) => {
        const btn = e.target;

        if (btn.classList.contains('btn-editar')) {
            const tr = btn.closest('tr');
            inputId.value       = tr.dataset.id;
            inputNombre.value   = tr.dataset.nombre;
            inputEmail.value    = tr.dataset.email;
            inputTelefono.value = tr.dataset.telefono;
            inputCiudad.value   = tr.dataset.ciudad;

            tituloForm.textContent = 'Editar cliente';
            btnGuardar.textContent = 'Actualizar';
            btnCancelar.classList.remove('d-none');
            msgForm.textContent = '';
        }

        if (btn.classList.contains('btn-eliminar')) {
            const tr  = btn.closest('tr');
            const id  = tr.dataset.id;
            const nom = tr.dataset.nombre || '';

            if (!confirm('¿Eliminar al cliente "' + nom + '"?')) {
                return;
            }

            const fd = new FormData();
            fd.append('id', id);

            try {
                const res = await fetch(apiUrl + '?action=delete', {
                    method: 'POST',
                    body: fd
                });

                const data = await res.json();

                if (data.success) {
                    msgTabla.classList.remove('text-danger');
                    msgTabla.classList.add('text-muted');
                    msgTabla.textContent = data.message || 'Cliente eliminado.';
                    cargarClientes();
                    if (inputId.value === id) {
                        resetForm();
                    }
                } else {
                    msgTabla.classList.remove('text-muted');
                    msgTabla.classList.add('text-danger');
                    msgTabla.textContent = data.message || 'No se pudo eliminar el cliente.';
                }

            } catch (error) {
                console.error(error);
                msgTabla.classList.remove('text-muted');
                msgTabla.classList.add('text-danger');
                msgTabla.textContent = 'Error al conectar con la API al eliminar.';
            }
        }
    });

    cargarClientes();
});
</script>

</body>
</html>
