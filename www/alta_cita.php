<?php include 'cabecera.html'; ?>

<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $reason = $_POST['reason'];
    $diagnostic = $_POST['diagnostic'];
    $patient_id = $_POST['patient_id'];
    $doctor_name = $_POST['doctor_name']; 

    $sql_check = "SELECT * FROM medical_appointments WHERE appointment_date = ? AND patient_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param('si', $date, $patient_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<div class='alert alert-danger mt-3'>El paciente ya tiene una cita registrada en la misma fecha y hora.</div>";
    } else {
        $sql = "INSERT INTO medical_appointments (appointment_date, appointment_reason, appointment_diagnostic, patient_id, doctor_name) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssis', $date, $reason, $diagnostic, $patient_id, $doctor_name);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success mt-3'>Cita registrada con éxito.</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Error al registrar la cita: " . $stmt->error . "</div>";
        }
    }
}

$sql_patients = "SELECT * FROM patients";
$result_patients = $conn->query($sql_patients);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Cita Médica</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Registrar Cita Médica</h1>
    <form method="post">
        <div class="mb-3">
            <label for="date" class="form-label">Fecha y Hora</label>
            <input type="datetime-local" class="form-control" id="date" name="date" required>
        </div>
        <div class="mb-3">
            <label for="reason" class="form-label">Razón de la Cita</label>
            <textarea class="form-control" id="reason" name="reason" required></textarea>
        </div>
        <div class="mb-3">
            <label for="diagnostic" class="form-label">Diagnóstico (opcional)</label>
            <textarea class="form-control" id="diagnostic" name="diagnostic"></textarea>
        </div>
        <div class="mb-3">
            <label for="patient_id" class="form-label">Paciente</label>
            <select class="form-control" id="patient_id" name="patient_id" required>
                <option value="">Seleccione un paciente</option>
                <?php while ($row = $result_patients->fetch_assoc()): ?>
                    <option value="<?= $row['patient_id'] ?>"><?= $row['patient_name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="doctor_name" class="form-label">Médico Asignado</label>
            <select class="form-control" id="doctor_name" name="doctor_name" required>
                <option value="">Seleccione un médico</option>
                <option value="Dr. Juan Pérez">Dr. Juan Pérez</option>
                <option value="Dra. María López">Dra. María López</option>
                <option value="Dr. Carlos García">Dr. Carlos García</option>
                <option value="Dra. Ana Torres">Dra. Ana Torres</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>
</body>
</html>
