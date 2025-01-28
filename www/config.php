
<?php
// Configuración de la conexión a la base de datos
define('DB_HOST', 'db');
define('DB_USER', 'root');
define('DB_PASSWORD', 'test');
define('DB_NAME', 'medical_appointments');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
