<?php require_once '../include/header.administrador.php'; ?>


<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Lista de Productos</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Gestión de Productos</li>
    </ol>

    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-success btn-lg" id="crear-nuevo-producto" data-bs-toggle="modal" data-bs-target="#modalNuevoProducto">
            + Agregar Nuevo Producto
        </button>
        <div class="input-group" style="max-width: 400px;">
            <input type="text" class="form-control" placeholder="Buscar producto..." id="buscar-producto">
            <button class="btn btn-primary" type="button" id="buscar-btn-producto">Buscar</button>
        </div>
    </div>

    <div class="card mb-4 shadow-lg">
        <div class="card-header bg-light text-dark">
            Lista de Productos
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center" id="tablaProductos">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyProductos">
                        <!-- Aquí se llenarán los productos dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .table-responsive {
            max-height: 400px;
            /* Ajusta la altura según tus necesidades */
            overflow-y: auto;
            /* Permite el desplazamiento vertical */
            overflow-x: auto;
            /* Permite el desplazamiento horizontal */
            border: 1px solid #dee2e6;
            /* Opcional: agrega un borde alrededor de la tabla */
        }
    </style>


    <!-- Modal para crear nuevo producto -->
    <div class="modal fade" id="modalNuevoProducto" tabindex="-1" aria-labelledby="modalNuevoProductoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="modalNuevoProductoLabel">Registrar Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formNuevoProducto" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nombreProducto" class="form-label">Nombre</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-pencil-fill"></i></span> <!-- Icono de lápiz -->
                                <input type="text" class="form-control" id="nombreProducto" name="nombre" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="precioProducto" class="form-label">Precio</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-cash-stack"></i></span> <!-- Icono de dinero -->
                                <input type="number" class="form-control" id="precioProducto" name="precio" required step="0.01" min="0">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="cantidadProducto" class="form-label">Cantidad</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-box"></i></span> <!-- Icono de caja -->
                                <input type="number" class="form-control" id="cantidadProducto" name="cantidad" required min="0">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="imagenProducto" class="form-label">Imagen del Producto (Opcional)</label>
                            <input type="file" class="form-control" id="imagenProducto" name="imagenProducto" accept="image/*">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="guardarProductoBtn">Guardar Producto</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para actualizar producto -->
    <div class="modal fade" id="modalActualizarProducto" tabindex="-1" aria-labelledby="modalActualizarProductoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="modalActualizarProductoLabel">Actualizar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formActualizarProducto" enctype="multipart/form-data">
                        <input type="hidden" id="idProductoActualizar" name="idproducto">

                        <!-- Cuadro de imagen -->
                        <div class="mb-3 text-center">
                            <img id="imagenProductoActual" src="" alt="Imagen del Producto" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                        </div>

                        <!-- Selección de nueva imagen -->
                        <div class="mb-3">
                            <label for="imagenProductoActualizar" class="form-label">Selecciona una nueva imagen (Opcional)</label>
                            <input type="file" class="form-control" id="imagenProductoActualizar" name="imagenProducto" accept="image/*" onchange="previewImage(event)">
                        </div>

                        <!-- Nombre del producto -->
                        <div class="mb-3">
                            <label for="nombreProductoActualizar" class="form-label">Nombre</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-pencil-fill"></i></span> <!-- Icono de lapiz -->
                                <input type="text" class="form-control" id="nombreProductoActualizar" name="nombre" required>
                            </div>
                        </div>

                        <!-- Precio -->
                        <div class="mb-3">
                            <label for="precioProductoActualizar" class="form-label">Precio</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-cash-stack"></i></span> <!-- Icono de dinero -->
                                <input type="number" class="form-control" id="precioProductoActualizar" name="precio" required step="0.01" min="0">
                            </div>
                        </div>

                        <!-- Cantidad -->
                        <div class="mb-3">
                            <label for="cantidadProductoActualizar" class="form-label">Cantidad</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-box"></i></span> <!-- Icono de caja -->
                                <input type="number" class="form-control" id="cantidadProductoActualizar" name="cantidad" required min="0">
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="mb-3">
                            <label for="estadoProductoActualizar" class="form-label">Estado</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-check-circle-fill"></i></span> <!-- Icono de check -->
                                <select class="form-select" id="estadoProductoActualizar" name="estado" required>
                                    <option value="" selected disabled>Selecciona el estado</option>
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="actualizarProductoBtn">Actualizar Producto</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para ver producto -->
    <div class="modal fade" id="modalVerProducto" tabindex="-1" aria-labelledby="modalVerProductoLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 680px;"> <!-- Ajusta el ancho máximo aquí -->
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="modalVerProductoLabel">Detalles del Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img id="imagenProductoVer" src="" alt="Imagen del Producto" class="img-fluid" style="max-height: 315px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);"> <!-- Ajusta la altura máxima aquí -->
                    </div>
                    <h5 id="nombreProductoVer" class="fw-bold text-center mb-3" style="font-size: 1.5rem;"></h5>

                    <div class="mb-3" style="margin-left: 25px;"> <!-- Ajusta el margin-left si es necesario -->
                        <div class="d-flex align-items-center">
                            <i class="bi bi-tag-fill me-2" style="font-size: 1.6rem;"></i>
                            <p class="mb-0" style="font-size: 1.2rem;"><strong>Precio:</strong> <span id="precioProductoVer"></span></p>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-box-fill me-2" style="font-size: 1.6rem;"></i>
                            <p class="mb-0" style="font-size: 1.2rem;"><strong>Cantidad:</strong> <span id="cantidadProductoVer"></span></p>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2" style="font-size: 1.6rem;"></i>
                            <p class="mb-0" style="font-size: 1.2rem;"><strong>Estado:</strong> <span id="estadoProductoVer"></span></p>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-fill me-2" style="font-size: 1.6rem;"></i>
                            <p class="mb-0" style="font-size: 1.2rem;"><strong>Fecha de Creación:</strong> <span id="fechaCreacionVer"></span></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <?php require_once '../include/footer.php'; ?>


    <!-- Scripts de funcionalidad -->
    <script>
        // Guardar nuevo Producto
        document.getElementById('guardarProductoBtn').addEventListener('click', function() {
            const formData = new FormData(document.getElementById('formNuevoProducto'));

            fetch('../../controllers/producto.controller.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.mensaje || data.error);
                    if (data.mensaje) {
                        cargarProductos(); // Recargar la lista de productos
                        document.getElementById('formNuevoProducto').reset(); // Limpiar el formulario
                        var modalEl = document.getElementById('modalNuevoProducto');
                        var modal = bootstrap.Modal.getInstance(modalEl);
                        modal.hide(); // Cerrar el modal
                    }
                })
                .catch(error => console.error('Error al registrar producto:', error));
        });

        // Cargar todo los productos
        function cargarProductos() {
            fetch('../../controllers/producto.controller.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('tbodyProductos');
                    tbody.innerHTML = ''; // Limpiar el contenido existente

                    data.forEach(producto => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                    <td>${producto.idproducto}</td>
                    <td>${producto.nombre}</td>
                    <td>${producto.precio}</td>
                    <td>${producto.cantidad}</td>
                    <td>${producto.estado}</td>
                    <td>
                        <button class="btn btn-info btn-sm" onclick="verProducto(${producto.idproducto})">Ver</button>
                        <button class="btn btn-warning btn-sm" onclick="editarProducto(${producto.idproducto})">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarProducto(${producto.idproducto})">Eliminar</button>
                    </td>
                `;
                        tbody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error al cargar productos:', error));
        }

        // Función para actualizar producto
        function editarProducto(idProducto) {
            fetch(`../../controllers/producto.controller.php?idproducto=${idProducto}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('idProductoActualizar').value = data.idproducto;
                    document.getElementById('nombreProductoActualizar').value = data.nombre;
                    document.getElementById('precioProductoActualizar').value = data.precio;
                    document.getElementById('cantidadProductoActualizar').value = data.cantidad;
                    document.getElementById('estadoProductoActualizar').value = data.estado;

                    const imagenSrc = `../../uploads/${data.imagenProducto}?t=${new Date().getTime()}`;
                    const imageElement = document.getElementById('imagenProductoActual');
                    imageElement.src = imagenSrc;

                    imageElement.onerror = function() {
                        this.src = '../../img/imagen.png'; // Imagen por defecto
                    };

                    var modalActualizarEl = document.getElementById('modalActualizarProducto');
                    var modalActualizar = new bootstrap.Modal(modalActualizarEl);
                    modalActualizar.show();
                })
                .catch(error => console.error('Error al cargar producto para editar:', error));
        }

        // Actualizar producto
        document.getElementById('actualizarProductoBtn').addEventListener('click', function() {
            const formData = new FormData(document.getElementById('formActualizarProducto'));

            // Agregar la acción para la actualización
            formData.append('action', 'actualizar');

            fetch('../../controllers/producto.controller.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.mensaje || data.error);
                    if (data.mensaje) {
                        cargarProductos(); // Función para recargar la lista de productos
                        document.getElementById('formActualizarProducto').reset();
                        var modalActualizarEl = document.getElementById('modalActualizarProducto');
                        var modalActualizar = bootstrap.Modal.getInstance(modalActualizarEl);
                        modalActualizar.hide();
                    }
                })
                .catch(error => console.error('Error al actualizar producto:', error));
        });

        // Función para eliminar un producto
        function eliminarProducto(idProducto) {
            if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                fetch('../../controllers/producto.controller.php', {
                        method: 'DELETE',
                        body: JSON.stringify({
                            idproducto: idProducto
                        }),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.mensaje || data.error);
                        if (data.mensaje) {
                            cargarProductos(); // Asumiendo que tienes una función para cargar los productos
                        }
                    })
                    .catch(error => console.error('Error al eliminar producto:', error));
            }
        }

        function verProducto(idProducto) {
            fetch(`../../controllers/producto.controller.php?idproducto=${idProducto}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        // Llenar el modal con los datos del producto
                        document.getElementById('nombreProductoVer').textContent = data.nombre;
                        document.getElementById('precioProductoVer').textContent = data.precio;
                        document.getElementById('cantidadProductoVer').textContent = data.cantidad;
                        document.getElementById('estadoProductoVer').textContent = data.estado;
                        document.getElementById('fechaCreacionVer').textContent = new Date(data.create_at).toLocaleDateString();

                        const imagenSrc = `../../uploads/${data.imagenProducto}?t=${new Date().getTime()}`;
                        document.getElementById('imagenProductoVer').src = imagenSrc;

                        // Manejo de errores para la imagen
                        document.getElementById('imagenProductoVer').onerror = function() {
                            this.src = '../../img/imagen.png'; // Imagen por defecto
                        };

                        // Mostrar el modal
                        const modal = new bootstrap.Modal(document.getElementById('modalVerProducto'));
                        modal.show();
                    } else {
                        alert('No se encontró el producto.');
                    }
                })
                .catch(error => console.error('Error al cargar el producto:', error));
        }



        document.addEventListener('DOMContentLoaded', cargarProductos);
    </script>
</div>