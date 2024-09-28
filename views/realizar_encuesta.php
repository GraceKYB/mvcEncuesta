<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Encuesta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Realizar Encuesta</h1>

    <form method="POST" action="index.php?action=submitEncuesta">
        <input type="hidden" name="cue_id" value="<?php echo isset($_POST['cue_id']) ? htmlspecialchars($_POST['cue_id']) : ''; ?>">
        <?php foreach ($preguntas as $pregunta): ?>
            <div class="mb-4">
                <h3><?php echo htmlspecialchars($pregunta['pre_texto']); ?></h3>
                <ul class="list-unstyled">
                    <?php foreach ($pregunta['respuestas'] as $respuesta): ?>
                        <li class="form-check">
                            <input class="form-check-input" type="radio" name="respuestas[<?php echo $pregunta['pre_id']; ?>]"
                                   value="<?php echo htmlspecialchars($respuesta['res_id']); ?>" required>
                            <label class="form-check-label">
                                <?php echo htmlspecialchars($respuesta['res_texto']); ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Enviar Encuesta</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
