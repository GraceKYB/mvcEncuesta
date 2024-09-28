<!DOCTYPE html>
<html>
<head>
    <title>Agregar Preguntas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .question-container {
            margin-bottom: 20px;
        }
        .response-container {
            margin-left: 20px;
        }
    </style>
    <script>
        function addQuestion() {
            const questionIndex = document.querySelectorAll('.question-container').length;
            const questionContainer = document.createElement('div');
            questionContainer.className = 'question-container';

            questionContainer.innerHTML = `
                <div class="mb-3">
                    <label class="form-label">Pregunta ${questionIndex + 1}:</label>
                    <input type="text" class="form-control" name="preguntas[${questionIndex}][texto]" required>
                </div>
                <div class="response-container">
                    <div class="mb-3 response">
                        <label class="form-label">Respuesta 1:</label>
                        <input type="text" class="form-control d-inline-block" name="preguntas[${questionIndex}][respuestas][0][texto]" required>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="preguntas[${questionIndex}][respuestas][0][correcta]" onchange="validateCheckboxes(${questionIndex}, 0)">
                            <label class="form-check-label">Correcta</label>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" onclick="addResponse(${questionIndex})">Agregar Respuesta</button>
            `;

            document.getElementById('questions').appendChild(questionContainer);
        }

        function addResponse(questionIndex) {
            const responseContainers = document.querySelectorAll(`.question-container:nth-child(${questionIndex + 1}) .response-container`);
            const responseIndex = responseContainers[0].querySelectorAll('.response').length;

            const responseContainer = document.createElement('div');
            responseContainer.className = 'mb-3 response';
            responseContainer.innerHTML = `
                <label class="form-label">Respuesta ${responseIndex + 1}:</label>
                <input type="text" class="form-control d-inline-block" name="preguntas[${questionIndex}][respuestas][${responseIndex}][texto]" required>
                <div class="form-check form-check-inline">
                    <input type="checkbox" class="form-check-input" name="preguntas[${questionIndex}][respuestas][${responseIndex}][correcta]" onchange="validateCheckboxes(${questionIndex}, ${responseIndex})">
                    <label class="form-check-label">Correcta</label>
                </div>
            `;

            responseContainers[0].appendChild(responseContainer);
        }

        function validateCheckboxes(questionIndex, responseIndex) {
            const checkboxes = document.querySelectorAll(`.question-container:nth-child(${questionIndex + 1}) .response-container .form-check-input`);
            checkboxes.forEach((checkbox, index) => {
                if (index !== responseIndex) {
                    checkbox.checked = false;
                }
            });
        }
    </script>
</head>
<body>
<div class="container mt-5">
    <h2>Agregar Preguntas y Respuestas</h2>
    <form method="POST" action="index.php?action=agregarPreguntas">
        <div id="questions">
            <div class="question-container">
                <div class="mb-3">
                    <label class="form-label">Pregunta 1:</label>
                    <input type="text" class="form-control" name="preguntas[0][texto]" required>
                </div>
                <div class="response-container">
                    <div class="mb-3 response">
                        <label class="form-label">Respuesta 1:</label>
                        <input type="text" class="form-control d-inline-block" name="preguntas[0][respuestas][0][texto]" required>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="preguntas[0][respuestas][0][correcta]" onchange="validateCheckboxes(0, 0)">
                            <label class="form-check-label">Correcta</label>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" onclick="addResponse(0)">Agregar Respuesta</button>
            </div>
        </div>
        <button type="button" class="btn btn-primary mt-3" onclick="addQuestion()">Agregar Pregunta</button>
        <button type="submit" class="btn btn-success mt-3">Guardar Preguntas</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
