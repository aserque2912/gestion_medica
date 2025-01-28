<?php include 'cabecera.html'; ?>

<?php
include 'config.php';

$error_cliente = "";
$cliente = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buscar_cliente'])) {
    $telefono = $_POST['telefono'];

    if (empty($telefono)) {
        $error_cliente = "Por favor, ingrese el número de teléfono.";
    } else {
        $sql = "SELECT * FROM patients WHERE patient_phone = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $telefono);
        $stmt->execute();
        $result_cliente = $stmt->get_result();

        if ($result_cliente->num_rows > 0) {
            $cliente = $result_cliente->fetch_assoc();
        } else {
            $error_cliente = "No se encontró ningún cliente con ese número de teléfono.";
        }
    }
}

$sql_listado = "SELECT * FROM patients";
$result = $conn->query($sql_listado);

if (!$result) {
    die("Error en la consulta SQL: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Pacientes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Listado de Pacientes</h1>

    <!-- Formulario de búsqueda -->
    <form method="POST" class="mb-4">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="telefono" class="form-label">Buscar Paciente por Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <div class="col-md-3 align-self-end">
                <button type="submit" name="buscar_cliente" class="btn btn-primary">Buscar</button>
            </div>
        </div>
    </form>

    <?php if (!empty($error_cliente)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error_cliente) ?></div>
    <?php endif; ?>

    <?php if ($cliente): ?>
        <div class="mt-4">
            <h4>Detalles del Paciente Encontrado</h4>
            <table class="table table-bordered">
                <tr><th>ID</th><td><?= htmlspecialchars($cliente['patient_id']) ?></td></tr>
                <tr><th>Nombre</th><td><?= htmlspecialchars($cliente['patient_name']) ?></td></tr>
                <tr><th>Fecha de Nacimiento</th><td><?= htmlspecialchars($cliente['patient_birthdate']) ?></td></tr>
                <tr><th>Teléfono</th><td><?= htmlspecialchars($cliente['patient_phone']) ?></td></tr>
                <tr><th>Correo Electrónico</th><td><?= htmlspecialchars($cliente['patient_email']) ?></td></tr>
                <tr>
                    <td colspan="2">
                        <a href="borrar_paciente.php?id=<?= $cliente['patient_id'] ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('¿Está seguro de que desea eliminar a este paciente?');">
                           Eliminar
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    <?php endif; ?>

    <h2 class="mt-5">Todos los Pacientes</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fecha de Nacimiento</th>
                <th>Teléfono</th>
                <th>Correo Electrónico</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['patient_id']) . "</td>
                            <td>" . htmlspecialchars($row['patient_name']) . "</td>
                            <td>" . htmlspecialchars($row['patient_birthdate']) . "</td>
                            <td>" . htmlspecialchars($row['patient_phone']) . "</td>
                            <td>" . htmlspecialchars($row['patient_email']) . "</td>
                            <td>
                                <a href='borrar_paciente.php?id=" . $row['patient_id'] . "' 
                                   class='btn btn-danger btn-sm' 
                                   onclick='return confirm(\"¿Está seguro de que desea eliminar este cliente?\");'>
                                   Eliminar
                                </a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay pacientes registrados o ocurrió un error.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
