<?php
$claves = [
    "SISTEMA2024",
    "SISTEMA2024",
    "SENATI2024",
    "",
    ""
];

foreach ($claves as $clave) {
    echo "<hr>";
    echo "Clave: " . $clave . "<br>";
    echo "Encriptada: " . password_hash($clave, PASSWORD_BCRYPT) . "<br>";
}
