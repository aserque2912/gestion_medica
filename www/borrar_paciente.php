<?php
include 'config.php';

if (!isset($_GET['id'])) {
    die("ID de cliente no especificado.");
}

$patient_id = $_GET['id'];

try {
    // Iniciar una transacción
    $conn->begin_transaction();

    // Elimino citas del paciente para que no quede ningun daot asociado a el
    $sql_delete_appointments = "DELETE FROM medical_appointments WHERE patient_id = ?";
    $stmt_appointments = $conn->prepare($sql_delete_appointments);
    $stmt_appointments->bind_param('i', $patient_id);
    $stmt_appointments->execute();

    
    $sql_delete_patient = "DELETE FROM patients WHERE patient_id = ?";
    $stmt_patient = $conn->prepare($sql_delete_patient);
    $stmt_patient->bind_param('i', $patient_id);
    $stmt_patient->execute();

    $conn->commit();

    echo "<script>alert('Paciente eliminado con éxito.'); window.location.href = 'listado_pacientes.php';</script>";
} catch (Exception $e) {
    $conn->rollback();
    echo "<script>alert('Error al eliminar el paciente: " . $e->getMessage() . "'); window.location.href = 'listado_pacientes.php';</script>";
}
?>
