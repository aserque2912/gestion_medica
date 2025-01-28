<?php
include 'config.php';

if (!isset($_GET['id'])) {
    die("ID de cita no especificado.");
}

$appointment_id = $_GET['id'];

$sql = "DELETE FROM medical_appointments WHERE appointment_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $appointment_id);

if ($stmt->execute()) {
    echo "<script>alert('Cita eliminada con éxito'); window.location.href='listado_citas.php';</script>";
} else {
    echo "Error al eliminar la cita: " . $conn->error;
}
?>
