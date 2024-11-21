<?php require_once '../include/header.administrador.php'; ?>

<style>
    /* Asegurar que el campo tenga espacio para el ícono sin moverlo */
    #claveacceso {
        padding-right: 40px;
        /* Espacio para el ícono a la derecha */
    }

    /* Mantener el ícono en una posición fija */
    .eye-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        cursor: pointer;
    }
</style>

<div class="container-fluid px-4">
    <h1 class="mt-4">Crear Acceso Usuario</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Registrar Usuario con acceso al sistema</li>
    </ol>

    <div class="card mb-4 shadow-lg">
        <div class="card-header">
            Complete los datos
        </div>
        <div class="card-body">
            <form action="" id="form-registro-usuarios" autocomplete="off">
                <div class="row g-2 mb-3">
                    <div class="col-md mb-2">
                        <div class="form-floating">
                            <select name="tipodoc" id="tipodoc" class="form-select" required>
                                <option value="DIN">DNI</option>
                            </select>
                            <label for="tipodoc">Tipo de documento</label>
                        </div>
                    </div>
                    <div class="col-md mb-2">
                        <div class="input-group">
                            <div class="form-floating">
                                <input type="tel" class="form-control" id="nrodocumento" placeholder="Numero documento" maxlength="8" autofocus required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <label for="nrodocumento">Número de Documento</label>
                            </div>
                            <button class="input-group-text" type="button" id="buscar-nrodocumento">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md mb-2">
                        <div class="form-floating">
                            <input type="tel" class="form-control" id="telefono" placeholder="Teléfono" maxlength="9" pattern="^9[0-9]{8}$" autofocus required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            <label for="telefono">Teléfono</label>
                        </div>
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="apellidos" placeholder="Apellidos" required>
                            <label for="apellidos">Apellidos</label>
                            <div class="invalid-feedback">Por favor ingrese los apellidos.</div>
                        </div>
                    </div>
                    <div class="col-md mb-2">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="nombres" placeholder="Nombres" required>
                            <label for="nombres">Nombres</label>
                            <div class="invalid-feedback">Por favor ingrese los nombres.</div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row g-2 mb-3">
                    <div class="col-md mb-2">
                        <div class="form-floating">
                            <input type="email" class="form-control" id="email" placeholder="Correo Electrónico" required>
                            <label for="email">Correo Electrónico</label>
                            <div class="invalid-feedback">Por favor ingrese un correo electrónico válido.</div>
                        </div>
                    </div>
                    <div class="col-md mb-2">
                        <div class="form-floating position-relative">
                            <input type="password" class="form-control pe-5" id="claveacceso" placeholder="Contraseña" maxlength="20" minlength="8" required>
                            <label for="claveacceso">Contraseña</label>
                            <div class="invalid-feedback">La contraseña debe tener al menos 8 caracteres.</div>
                            <span id="togglePassword" class="position-absolute top-50 translate-middle-y me-3 eye-icon">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md mb-2">
                        <div class="form-floating">
                            <select name="nivelacceso" id="nivelacceso" class="form-select" required>
                                <option value="">Seleccione</option>
                                <option value="administrador">Administrador</option>
                                <option value="cliente">Cliente</option>
                            </select>
                            <label for="nivelacceso">Nivel de Acceso</label>
                            <div class="invalid-feedback">Por favor seleccione un nivel de acceso.</div>
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit" id="registrar-usuario" class="btn btn-primary btn-sm" disabled>Registrar</button>
                    <button type="reset" class="btn btn-secondary btn-sm">Cancelar proceso</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../include/footer.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const nrodocumento = document.querySelector("#nrodocumento");
        let idpersona = -1;

        async function registrarUsuario() {
            const params = new FormData();
            params.append("operation", "add");

            // Agregar siempre los datos personales
            params.append("tipodoc", document.querySelector("#tipodoc").value);
            params.append("nrodocumento", nrodocumento.value);
            params.append("apellidos", document.querySelector("#apellidos").value);
            params.append("nombres", document.querySelector("#nombres").value);
            params.append("telefono", document.querySelector("#telefono").value);

            // Solo agregar los datos del usuario si los campos no están deshabilitados
            if (document.querySelector("#email").disabled === false) {
                params.append("email", document.querySelector("#email").value);
            }
            if (document.querySelector("#claveacceso").disabled === false) {
                params.append("contraseña", document.querySelector("#claveacceso").value);
            }
            if (document.querySelector("#nivelacceso").disabled === false) {
                params.append("nivelacceso", document.querySelector("#nivelacceso").value);
            }

            const options = {
                method: "POST",
                body: params
            };

            const response = await fetch(`../../controllers/usuario.controller.php`, options);
            return response.json();
        }

        async function buscarDocumento() {
            const params = new URLSearchParams();
            params.append("operation", "searchByDoc");
            params.append("nrodocumento", nrodocumento.value);

            const response = await fetch(`../../controllers/persona.controller.php?${params}`);
            return response.json();
        }

        function validarDocumento(response) {
            if (response.length === 0) {
                document.querySelector("#apellidos").value = ``;
                document.querySelector("#nombres").value = ``;
                document.querySelector("#telefono").value = ``;
                adPersona(true); // Habilitar campos personales
                adUsuario(false); // Deshabilitar campos de usuario
                document.querySelector("#registrar-usuario").disabled = false; // Habilitar el botón de registro
                alert("Número de documento no encontrado. Proceda a registrarse");
            } else {
                idpersona = response[0].idpersona;
                document.querySelector("#apellidos").value = response[0].apellido;
                document.querySelector("#nombres").value = response[0].nombre;
                document.querySelector("#telefono").value = response[0].telefono;
                adPersona(false); // Deshabilitar campos personales si se encuentra la persona
                if (response[0].idusuario === null) {
                    adUsuario(true); // Habilitar campos de usuario si no tiene uno
                } else {
                    adUsuario(false);
                    alert("Esta persona ya cuenta con un perfil de usuario.");
                }
            }
        }

        // Función para validar si el número de documento, correo o teléfono ya existen
        async function validarExistencia() {
            const telefono = document.querySelector("#telefono").value;
            const email = document.querySelector("#email").value;
            const nrodocumento = document.querySelector("#nrodocumento").value;

            const params = new URLSearchParams();
            params.append("operation", "checkExists");
            params.append("telefono", telefono);
            params.append("email", email);
            params.append("nrodocumento", nrodocumento);

            const response = await fetch(`../../controllers/usuario.controller.php?${params}`);
            const data = await response.json();

            if (data.success === false) {
                alert(data.status); // Muestra el mensaje de error recibido
                return false; // Si alguna validación falla, no continuar con el registro
            }
            return true; // Si todo está correcto, se puede registrar
        }

        function validarNroDocumento() {
            if (nrodocumento.value.trim() === "" || nrodocumento.value.length < 8) {
                alert("Por favor complete los datos con al menos 8 números en el número de documento.");
                return false;
            }
            return true;
        }

        nrodocumento.addEventListener("keypress", async (event) => {
            if (event.keyCode === 13) {
                if (validarNroDocumento()) {
                    const response = await buscarDocumento();
                    validarDocumento(response);
                }
            }
        });

        document.querySelector("#buscar-nrodocumento").addEventListener("click", async () => {
            if (validarNroDocumento()) {
                const response = await buscarDocumento();
                validarDocumento(response);
            }
        });

        function adPersona(sw = false) {
            const inputs = ["#apellidos", "#nombres", "#telefono"];
            inputs.forEach(input => {
                document.querySelector(input).disabled = !sw;
            });
        }

        function adUsuario(sw = false) {
            const inputs = ["#email", "#claveacceso", "#nivelacceso", "#registrar-usuario"];
            inputs.forEach(input => {
                document.querySelector(input).disabled = !sw;
            });
        }

        document.querySelector("#form-registro-usuarios").addEventListener("submit", async (event) => {
            event.preventDefault();

            // Primero validamos si el número de documento, teléfono o email ya existen
            const esValido = await validarExistencia();
            if (!esValido) {
                return; // Si alguna validación falla, no procedemos con el registro
            }

            if (idpersona !== -1) {
                // Persona ya registrada, solo registramos el usuario
                const response = await registrarUsuario();
                alert("Usuario registrado exitosamente");
            } else {
                alert("Registro exitoso, vuelve a buscar para registrar un usuario");
                const response = await registrarUsuario();
            }

            document.querySelector("#form-registro-usuarios").reset();
            idpersona = -1; // Resetear el idpersona
            adUsuario(false); // Deshabilitar campos de usuario después de resetear el formulario
        });

        // Funcionalidad para mostrar/ocultar la contraseña
        const togglePassword = document.querySelector("#togglePassword");
        const passwordInput = document.querySelector("#claveacceso");

        togglePassword.addEventListener("click", () => {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            togglePassword.innerHTML = type === "password" ? '<i class="fa fa-eye"></i>' : '<i class="fa fa-eye-slash"></i>';
        });

        adPersona();
        adUsuario(); // Deshabilitar los campos de usuario desde el inicio
    });
</script>
