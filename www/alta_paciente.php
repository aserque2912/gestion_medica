<?php include 'cabecera.html'; ?>

<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['name'];
    $nacimiento = $_POST['birthdate'];
    $historial = $_POST['history'];
    $telefono = $_POST['phone'];
    $email = $_POST['email'];

    $sql_check = "SELECT * FROM patients WHERE patient_phone = ? OR patient_email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ss", $telefono, $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<div class='alert alert-danger mt-3'>El teléfono o correo electrónico ya está registrado para otro paciente.</div>";
    } else {
        $sql = "INSERT INTO patients (patient_name, patient_birthdate, patient_history, patient_phone, patient_email) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $nombre, $nacimiento, $historial, $telefono, $email);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success mt-3'>Nuevo paciente registrado con éxito.</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Error al registrar el paciente: " . $conn->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Paciente</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Registrar Paciente</h1>
    <form method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="birthdate" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" required>
        </div>
        <div class="mb-3">
            <label for="history" class="form-label">Historial Médico</label>
            <textarea class="form-control" id="history" name="history"></textarea>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>
</body>
</html>
