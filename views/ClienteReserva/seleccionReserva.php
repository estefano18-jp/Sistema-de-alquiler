<!-- views/include/dashboard.cliente.php -->
<?php 

require_once '../include/header.cliente.php'; 
?>

<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Alquiler de Instalaciones Deportivas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Inicio</li>
    </ol>

    <!-- Sección para seleccionar el Complejo Deportivo -->
    <div class="card mb-4" style="background-color: rgba(245, 245, 245, 0.8);">
        <div class="card-header" style="background-color: rgba(0, 123, 255, 0.1); font-weight: bold;">
            <i class="fa-solid fa-building me-2"></i>Selecciona el Complejo Deportivo
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-10 mb-3">
                    <label for="complejoSeleccionar" class="form-label">Complejo Deportivo</label>
                    <select class="form-select" id="complejoSeleccionar" required>
                        <option value="">Selecciona un Complejo</option>
                        <!-- Opciones cargadas dinámicamente -->
                    </select>
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button class="btn btn-primary w-100" id="btnCargarCampos">
                        <i class="fa-solid fa-search me-2"></i>Buscar Campos
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenedor dinámico para las tarjetas de los Campos -->
    <div class="row justify-content-center" id="contenedorCampos">
        <!-- Aquí se llenarán las tarjetas dinámicamente -->
    </div>
</div>

<style>
    .card-campo {
        height: 100%;
        border-radius: 10px;
        overflow: hidden;
        color: white;
        text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.7);
        background-size: cover;
        background-position: center;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.2s;
    }

    .card-campo:hover {
        transform: scale(1.05);
    }

    .card-campo-footer {
        background: rgba(0, 0, 0, 0.6);
        text-align: center;
        padding: 10px;
    }

    .row {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .col-lg-3,
    .col-md-6 {
        padding: 10px;
    }

    .card-body-campo {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        text-align: center;
        height: 100%;
        padding: 20px;
        background: rgba(0, 0, 0, 0.4);
    }

    .card-body-campo h5,
    .card-body-campo p {
        margin: 0;
    }

    .card-body-campo .btn {
        margin-top: 15px;
    }

    .separador {
        width: 100%;
        border-top: 2px solid #ccc;
        margin: 20px 0;
    }

    /* Ajustes adicionales para asegurar la alineación de los botones */
    @media (max-width: 768px) {
        .col-md-10,
        .col-md-2 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .col-md-2 {
            margin-top: 15px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        cargarComplejos();

        /**
         * Función para cargar la lista de Complejos Deportivos en el select
         */
        function cargarComplejos() {
            fetch('../../controllers/complejo.controller.php?action=listar')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error en la respuesta del servidor: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    const complejoSelect = document.getElementById('complejoSeleccionar');
                    complejoSelect.innerHTML = '<option value="">Selecciona un Complejo</option>';

                    // Manejo de errores
                    if (data.error) {
                        alert(`Error al cargar los complejos: ${data.error}`);
                        return;
                    }

                    // Verificar si data es un arreglo
                    if (!Array.isArray(data) || data.length === 0) {
                        complejoSelect.innerHTML = '<option value="">No hay complejos disponibles</option>';
                        return;
                    }

                    // Llenar el select con los complejos
                    data.forEach(complejo => {
                        const option = document.createElement('option');
                        option.value = complejo.idcomplejo;
                        option.textContent = complejo.nombreComplejo;
                        complejoSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error al cargar los complejos:', error.message);
                    alert('Ocurrió un error al cargar los complejos. Inténtalo de nuevo más tarde.');
                });
        }

        /**
         * Evento al hacer clic en el botón "Buscar Campos"
         */
        document.getElementById('btnCargarCampos').addEventListener('click', function() {
            const idComplejo = document.getElementById('complejoSeleccionar').value;
            if (!idComplejo) {
                alert('Por favor, selecciona un Complejo Deportivo.');
                return;
            }
            cargarCampos(idComplejo);
        });

        /**
         * Función para cargar los Campos del Complejo seleccionado
         * @param {number} idComplejo - ID del Complejo Deportivo
         */
        function cargarCampos(idComplejo) {
            // Llamada al endpoint correcto para listar campos por complejo
            fetch(`../../controllers/campo.controller.php?idcomplejo=${idComplejo}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error en la respuesta del servidor: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    const contenedor = document.getElementById('contenedorCampos');
                    contenedor.innerHTML = '';

                    // Manejo de errores
                    if (data.error) {
                        contenedor.innerHTML = `
                            <div class="col-12">
                                <p class="text-center text-danger">Error al cargar los campos: ${data.error}</p>
                            </div>`;
                        return;
                    }

                    // Verificar si data es un arreglo
                    if (!Array.isArray(data) || data.length === 0) {
                        contenedor.innerHTML = `
                            <div class="col-12">
                                <p class="text-center text-muted">No hay campos disponibles para este complejo.</p>
                            </div>`;
                        return;
                    }

                    // Iconos para cada tipo de deporte
                    const iconosDeporte = {
                        'Fútbol': 'fas fa-futbol',
                        'Vóley': 'fas fa-volleyball-ball',
                        'Baloncesto': 'fas fa-basketball-ball',
                        'Piscina': 'fas fa-swimmer',
                        'Otro': 'fas fa-running'
                    };

                    data.forEach(campo => {
                        const imagenCampo = campo.imagenCampo ?
                            `../../uploads/${campo.imagenCampo}` :
                            '../../uploads/default-imagen.png'; // Imagen por defecto

                        const estadoCampo = campo.estado === 'activo' ? 'Disponible' : 'No Disponible';
                        const botonSeleccionar = campo.estado === 'activo' ?
                            `<button class="btn btn-light" onclick="seleccionarCampo(${campo.idcampo})">Seleccionar</button>` :
                            '<button class="btn btn-secondary" disabled>No Disponible</button>';
                        const icono = iconosDeporte[campo.tipoDeporte] || iconosDeporte['Otro'];

                        contenedor.innerHTML += `
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="card-campo text-white shadow-lg" style="background-image: url('${imagenCampo}');">
                                    <div class="card-body-campo">
                                        <i class="${icono} fa-2x mb-2"></i>
                                        <h5 class="card-title">${campo.nombreCampo}</h5>
                                        <p>${estadoCampo}</p>
                                        ${botonSeleccionar}
                                    </div>
                                    <div class="card-campo-footer">
                                        <small>Capacidad: ${campo.capacidad} personas</small><br>
                                        <small>Precio: S/ ${parseFloat(campo.precioHora).toFixed(2)}</small>
                                    </div>
                                </div>
                            </div>`;
                    });
                })
                .catch(error => {
                    console.error('Error al cargar los campos:', error.message);
                    const contenedor = document.getElementById('contenedorCampos');
                    contenedor.innerHTML = `
                        <div class="col-12">
                            <p class="text-center text-danger">Ocurrió un error al cargar los campos. Inténtalo de nuevo más tarde.</p>
                        </div>`;
                });
        }

        /**
         * Función para manejar la selección de un Campo
         * @param {number} idCampo - ID del Campo seleccionado
         */
        window.seleccionarCampo = function(idCampo) {
            window.location.href = `../ClienteReserva/index.php?idcampo=${idCampo}`;
        };
    });
</script>

