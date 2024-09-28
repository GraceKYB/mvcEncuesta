<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard del Profesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-end">
        <a href="index.php?action=logout" class="btn btn-danger mb-3">Cerrar sesión</a>
    </div>
    <h2 class="text-center mb-4">Bienvenido Profesor</h2>
    <p class="text-center">Aquí puedes crear y gestionar cuestionarios.</p>

    <div class="card p-4 mb-4">
        <h3 class="mb-3">Crear Nueva Encuesta</h3>
        <form action="index.php?action=crearEncuesta" method="POST">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título de la Encuesta:</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear Encuesta</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
