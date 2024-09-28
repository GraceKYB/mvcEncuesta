<!DOCTYPE html>
<html>
<head>
    <title>Crear Encuesta</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <a href="index.php?action=profesorDashboard" class="btn btn-secondary mb-3">Regresar</a>
    <h2 class="text-center mb-4">Crear Nueva Encuesta</h2>
    <form action="index.php?action=crearEncuesta" method="POST">
        <div class="mb-3">
            <label for="enc_nombre" class="form-label">Nombre de la Encuesta:</label>
            <input type="text" class="form-control" id="enc_nombre" name="enc_nombre" required>
        </div>
        <div class="mb-3">
            <label for="enc_descripcion" class="form-label">Descripción:</label>
            <textarea class="form-control" id="enc_descripcion" name="enc_descripcion" rows="4" required></textarea>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Crear Encuesta</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
