<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-end">
        <a href="index.php?action=logout" class="btn btn-danger mb-3">Cerrar sesión</a>
    </div>
    <h2 class="text-center mb-4">Bienvenido Estudiante</h2>
    <p class="text-center">Aquí puedes seleccionar y realizar cuestionarios.</p>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Encuesta</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Acciones</th>
            <th>Nota</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cuestionarios as $cuestionario): ?>
            <tr>
                <td><?php echo htmlspecialchars($cuestionario->getCueTitulo()); ?></td>
                <td><?php echo htmlspecialchars($cuestionario->getCueDescripcion()); ?></td>
                <td><?php echo $cuestionario->getCalificacion() == null ? 'Pendiente' : 'Resuelto' ?></td>
                <td class="actions">
                    <form method="POST" action="index.php?action=realizarEncuesta">
                        <input type="hidden" name="cue_id" value="<?php echo $cuestionario->getCueId(); ?>">
                        <button type="submit" class="btn btn-primary"><?php echo $cuestionario->getCalificacion() == null ? 'Realizar Encuesta' : 'Ver Resultado' ?></button>
                    </form>
                </td>
                <td><?php echo $cuestionario->getCalificacion() ?? 'Cuestionario no resuelto' ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
