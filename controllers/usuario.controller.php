<?php
session_start();

require_once '../models/Usuario.php';
$usuario = new Usuario();

if (isset($_GET['operation'])) {
    switch ($_GET['operation']) {
        case 'login':
            $login = [
                "permitido" => false,
                "apellido" => "",
                "nombre" => "",
                "idusuario" => "",
                "rol" => "",
                "status" => ""
            ];

            // Verificar si el nombre de usuario y la contraseña están presentes
            if (isset($_GET['nomuser']) && isset($_GET['passuser'])) {
                // Paso 1: Verificar las credenciales con el modelo
                $row = $usuario->login([
                    'nomuser' => $_GET['nomuser'],
                    'passuser' => $_GET['passuser']
                ]);

                // Paso 2: Procesar la respuesta del modelo
                if (count($row) == 0) {
                    $login["status"] = "no existe el usuario"; // Usuario no encontrado
                } else {
                    $claveEncriptada = $row[0]['passuser']; // Clave almacenada en la base de datos
                    $claveIngreso = $_GET['passuser']; // Clave ingresada en el formulario

                    // Paso 3: Verificar si la contraseña ingresada coincide con la almacenada
                    if (password_verify($claveIngreso, $claveEncriptada)) {
                        $login["permitido"] = true;
                        $login["apellido"] = $row[0]["apellido"];
                        $login["nombre"] = $row[0]["nombre"];
                        $login["idusuario"] = $row[0]["idusuario"];
                        $login["rol"] = $row[0]["rol"];
                    } else {
                        $login["status"] = "contraseña incorrecta"; // Contraseña incorrecta
                    }
                }
            } else {
                $login["status"] = "faltan parámetros para login"; // Faltan parámetros
            }
            
            $_SESSION['login'] = $login; // Guardar estado del login en la sesión
            echo json_encode($login); // Devolver la respuesta en formato JSON
            break;

        case 'destroy':
            session_unset();
            session_destroy();
            header('Location: http://localhost/AlquilerCampoDeportivo/index.php'); // Redirige al login
            exit();
            break;
         // Nueva operación para obtener datos del usuario
         case 'obtener_datos_usuario':
            if (isset($_GET['idusuario'])) {
                $idusuario = $_GET['idusuario'];
                $datosUsuario = $usuario->obtenerDatosUsuario($idusuario);
                if ($datosUsuario) {
                    echo json_encode($datosUsuario);
                } else {
                    echo json_encode(['error' => 'Datos de usuario no encontrados']);
                }
            } else {
                echo json_encode(['error' => 'ID de usuario no proporcionado']);
            }
            break;
    }
    
}


if (isset($_POST['operation']) && $_POST['operation'] == 'add') {
    // Verificar si ya existe un usuario con el mismo número de documento
    $persona = $usuario->checkExistingPerson($_POST['nrodocumento']);

    // Validación si ya existe el número de documento
    if ($persona) {
        // Si la persona existe, verificar si ya tiene un usuario
        $existingUser = $usuario->checkExistingUser($_POST['nrodocumento']);
        if ($existingUser) {
            echo json_encode(["success" => false, "status" => "Usuario ya registrado con este número de documento"]);
        } else {
            // Si la persona no tiene usuario, registrar como nuevo usuario
            $datos = [
                "idpersona" => $persona['idpersona'], // ID de la persona existente
                "nomuser" => $_POST['nomuser'],
                "passuser" => $_POST['passuser'],
                "rol" => $_POST['rol']
            ];
            $idusuario = $usuario->add($datos);
            echo json_encode(["success" => true, "message" => "Usuario registrado exitosamente"]);
        }
    } else {
        // Si la persona no existe, registrar como nueva persona directamente
        $datos = [
            "nomuser" => $_POST['nomuser'],
            "passuser" => $_POST['passuser'],
            "rol" => $_POST['rol'],
            "nombres" => $_POST['nombres'],
            "apellidos" => $_POST['apellidos'],
            "telefono" => $_POST['telefono'],
            "nrodocumento" => $_POST['nrodocumento']
        ];
        $idusuario = $usuario->registerNewUser($datos);
        echo json_encode(["success" => true, "message" => "Persona registrada exitosamente"]);
    }
}

if (isset($_GET['operation'])) {
    switch ($_GET['operation']) {
        case 'checkExists':
            $telefono = $_GET['telefono'];
            $nomuser = $_GET['nomuser'];
            $nrodocumento = $_GET['nrodocumento'];

            // Si estamos en el primer registro de persona, solo verificamos el teléfono
            if ($nrodocumento && !$nomuser) {
                // Validamos si ya existe algún teléfono
                $telefonoExiste = $usuario->phoneExists($telefono);

                if ($telefonoExiste) {
                    echo json_encode(["success" => false, "status" => "El teléfono ya está registrado, intente cambiarlo"]);
                } else {
                    echo json_encode(["success" => true]);  // Si el teléfono está disponible
                }
            }
            // Si estamos en el registro de usuario (segundo paso), solo verificamos el nombre de usuario
            elseif ($nomuser) {
                // Validamos si ya existe el nombre de usuario
                $nomuserExiste = $usuario->nameExists($nomuser);

                if ($nomuserExiste) {
                    echo json_encode(["success" => false, "status" => "El nombre de usuario ya está registrado, intente cambiarlo"]);
                } else {
                    echo json_encode(["success" => true]);  // Si el nombre de usuario está disponible
                }
            }
            break;
    }
}


?>
