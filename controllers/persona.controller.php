<?php
require_once '../models/Persona.php';
$persona = new Persona();

// Obtener datos de la petición
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if (isset($data['operation'])) {
    switch ($data['operation']) {
        case 'add':
            $datos = [
                "nombre"       => $data['nombre'],
                "apellido"     => $data['apellido'],
                "telefono"     => $data['telefono'],
                "nrodocumento" => $data['nrodocumento']
            ];
            $idobtenido = $persona->add($datos);
            echo json_encode(["idpersona" => $idobtenido]);
            break;

        case 'update':
            $datos = [
                "idpersona"    => $data['idpersona'],
                "nombre"       => $data['nombre'],
                "apellido"     => $data['apellido'],
                "telefono"     => $data['telefono'],
                "nrodocumento" => $data['nrodocumento']
            ];
            $resultado = $persona->update($datos);
            echo json_encode(["success" => $resultado]);
            break;

        case 'delete':
            $idpersona = $data['idpersona'];
            $resultado = $persona->delete($idpersona);
            echo json_encode(["success" => $resultado]);
            break;
    }
} else if (isset($_GET['operation'])) {
    switch ($_GET['operation']) {
        case 'list':
            echo json_encode($persona->listAll());
            break;

        case 'searchByDoc':
            echo json_encode($persona->searchByDoc(['nrodocumento' => $_GET['nrodocumento']]));
            break;
    }
}
?>
