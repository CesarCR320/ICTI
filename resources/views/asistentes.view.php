<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Asistentes</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; }
        .event-info { margin-bottom: 20px; }
        .empty { color: #b00; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Lista de Asistentes</h1>
    <?php if (isset($eventoActivo) && $eventoActivo): ?>
        <div class="event-info">
            <strong>Evento activo:</strong>
            <?php echo htmlspecialchars($eventoActivo['nombre']); ?>
            (Fecha: <?php echo htmlspecialchars($eventoActivo['fecha']); ?>)
        </div>
    <?php else: ?>
        <div class="event-info empty">No hay evento activo actualmente.</div>
    <?php endif; ?>

    <?php if (count($asistentes) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Folio</th>
                    <th>Hora de Registro</th>
                    <!-- Agrega más columnas según tu tabla -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($asistentes as $i => $asistente): ?>
                    <tr>
                        <td><?php echo $i+1; ?></td>
                        <td><?php echo htmlspecialchars($asistente['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($asistente['email']); ?></td>
                        <td><?php echo htmlspecialchars($asistente['folio']); ?></td>
                        <td><?php echo htmlspecialchars($asistente['hora_registro']); ?></td>
                        <!-- Más columnas si necesitas -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty">No hay asistentes registrados.</div>
    <?php endif; ?>
</body>
</html>