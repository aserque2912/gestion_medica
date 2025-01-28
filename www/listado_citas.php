<?php
include 'config.php';

$error_cita = "";
$cita = null;

// Buscar una cita por ID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buscar_cita'])) {
    $appointment_id = $_POST['appointment_id'];

    if (empty($appointment_id)) {
        $error_cita = "Por favor, rellene el campo de búsqueda.";
    } else {
        $sql = "SELECT a.appointment_id, a.appointment_date, a.appointment_reason, p.patient_name, a.doctor_name 
                FROM medical_appointments a
                JOIN patients p ON a.patient_id = p.patient_id
                WHERE a.appointment_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $appointment_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $cita = $result->fetch_assoc();
        } else {
            $error_cita = "No se encontró ninguna cita con ese ID.";
        }
    }
}

// Obtener el listado completo de citas
$sql_listado = "SELECT a.appointment_id, a.appointment_date, a.appointment_reason, p.patient_name, a.doctor_name 
                FROM medical_appointments a
                JOIN patients p ON a.patient_id = p.patient_id";
$result_listado = $conn->query($sql_listado);

if (!$result_listado) {
    die("Error en la consulta SQL: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Citas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'cabecera.html'; ?>
<div class="container mt-5">
    <h1>Listado de Citas</h1>

    <!-- Formulario de búsqueda -->
    <form method="POST" class="mb-4">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="appointment_id" class="form-label">Buscar Cita por ID</label>
                <input type="number" class="form-control" id="appointment_id" name="appointment_id" required>
            </div>
            <div class="col-md-3 align-self-end">
                <button type="submit" name="buscar_cita" class="btn btn-primary">Buscar</button>
            </div>
        </div>
    </form>

    <!-- Mostrar errores -->
    <?php if (!empty($error_cita)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error_cita) ?></div>
    <?php endif; ?>

    <!-- Mostrar detalles de la cita encontrada -->
    <?php if ($cita): ?>
        <div class="mt-4">
            <h4>Detalles de la Cita Encontrada</h4>
            <form method="POST" action="editar_cita.php">
                <table class="table table-bordered">
                    <tr><th>ID</th><td><?= htmlspecialchars($cita['appointment_id']) ?></td></tr>
                    <tr><th>Fecha y Hora</th><td><?= htmlspecialchars($cita['appointment_date']) ?></td></tr>
                    <tr><th>Razón</th><td><?= htmlspecialchars($cita['appointment_reason']) ?></td></tr>
                    <tr><th>Paciente</th><td><?= htmlspecialchars($cita['patient_name']) ?></td></tr>
                    <tr><th>Médico</th><td><?= htmlspecialchars($cita['doctor_name']) ?></td></tr>
                    <tr><th> <a href="editar_cita.php?id=<?= $cita['appointment_id'] ?>" class="btn btn-warning">Editar</a>
                    <a href="borrar_cita.php?id=<?= $cita['appointment_id'] ?>" 
                            class="btn btn-danger" 
                            onclick="return confirm('¿Está seguro de que desea eliminar esta cita?');">
                            Eliminar</a></th><td></td></tr>  
                            
                </table>
                
            </form>
        </div>
    <?php endif; ?>

    <!-- Mostrar listado completo de citas -->
    <h2 class="mt-5">Todas las Citas</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha y Hora</th>
                <th>Razón</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_listado->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['appointment_id']) ?></td>
                    <td><?= htmlspecialchars($row['appointment_date']) ?></td>
                    <td><?= htmlspecialchars($row['appointment_reason']) ?></td>
                    <td><?= htmlspecialchars($row['patient_name']) ?></td>
                    <td><?= htmlspecialchars($row['doctor_name']) ?></td>
                    <td>
                        <a href="editar_cita.php?id=<?= $row['appointment_id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="borrar_cita.php?id=<?= $row['appointment_id'] ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('¿Está seguro de que desea eliminar esta cita?');">
                           Eliminar
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
