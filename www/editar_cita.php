<?php
include 'config.php';

if (!isset($_GET['id'])) {
    die("ID de cita no especificado.");
}

$appointment_id = $_GET['id'];

// Obtener los detalles de la cita
$sql = "SELECT appointment_date, appointment_reason, doctor_name FROM medical_appointments WHERE appointment_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $appointment_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Cita no encontrada.");
}

$cita = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_date = $_POST['appointment_date'];
    $appointment_reason = $_POST['appointment_reason'];
    $doctor_name = $_POST['doctor_name'];

    $update_sql = "UPDATE medical_appointments SET appointment_date = ?, appointment_reason = ?, doctor_name = ? WHERE appointment_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('sssi', $appointment_date, $appointment_reason, $doctor_name, $appointment_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Cita actualizada con éxito'); window.location.href='listado_citas.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar la cita.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cita</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Editar Cita</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="appointment_date" class="form-label">Fecha y Hora</label>
            <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date" 
                   value="<?= htmlspecialchars($cita['appointment_date']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="appointment_reason" class="form-label">Razón de la Cita</label>
            <textarea class="form-control" id="appointment_reason" name="appointment_reason" required><?= htmlspecialchars($cita['appointment_reason']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="doctor_name" class="form-label">Médico Asignado</label>
            <select class="form-control" id="doctor_name" name="doctor_name" required>
                <option value="Dr. Juan Pérez" <?= $cita['doctor_name'] == 'Dr. Juan Pérez' ? 'selected' : '' ?>>Dr. Juan Pérez</option>
                <option value="Dra. María López" <?= $cita['doctor_name'] == 'Dra. María López' ? 'selected' : '' ?>>Dra. María López</option>
                <option value="Dr. Carlos García" <?= $cita['doctor_name'] == 'Dr. Carlos García' ? 'selected' : '' ?>>Dr. Carlos García</option>
                <option value="Dra. Ana Torres" <?= $cita['doctor_name'] == 'Dra. Ana Torres' ? 'selected' : '' ?>>Dra. Ana Torres</option>
            </select>
        </div>
        <!-- Botones en la misma fila -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="listado_citas.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>
