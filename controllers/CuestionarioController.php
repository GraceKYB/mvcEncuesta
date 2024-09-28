<?php
require_once 'config/database.php';
require_once 'models/Cuestionario.php';
require_once 'models/Pregunta.php';
require_once 'models/Respuesta.php';

class CuestionarioController
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    public function index()
    {
        $this->crearEncuesta();
    }

    public function crearEncuesta()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['enc_nombre'])) {
            $enc_nombre = $_POST['enc_nombre'];
            $enc_descripcion = $_POST['enc_descripcion'];

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $cue_profesor_id = $_SESSION['usuario_id'];

            $cuestionario = new Cuestionario(null, $enc_nombre, $enc_descripcion, $cue_profesor_id, null);
            $cuestionario_id = $this->guardarCuestionario($cuestionario);

            if ($cuestionario_id) {
                $_SESSION['encuesta_id'] = $cuestionario_id;
                header('Location: index.php?action=agregarPreguntas');
                exit;
            } else {
                echo "Error al crear el cuestionario.";
            }
        } else {
            require 'views/crear_encuesta.php';
        }
    }


    private function guardarCuestionario(Cuestionario $cuestionario)
    {
        $query = "INSERT INTO tbl_cuestionarios (cue_titulo, cue_descripcion, cue_profesor_id) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            die('Error de preparación de la consulta: ' . $this->conn->error);
        }

        $titulo = $cuestionario->getCueTitulo();
        $descripcion = $cuestionario->getCueDescripcion();
        $profesor_id = $cuestionario->getCueProfesorId();

        $stmt->bind_param("ssi", $titulo, $descripcion, $profesor_id);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return null;
        }
    }

    public function agregarPreguntas()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['preguntas'])) {
            $preguntas = $_POST['preguntas'];

            foreach ($preguntas as $pregunta_data) {
                $texto_pregunta = $pregunta_data['texto'];
                $pregunta = new Pregunta(null, $_SESSION['encuesta_id'], $texto_pregunta);
                $pregunta_id = $this->guardarPregunta($pregunta);

                if ($pregunta_id) {
                    foreach ($pregunta_data['respuestas'] as $respuesta_data) {
                        $texto_respuesta = $respuesta_data['texto'];
                        $es_correcta = isset($respuesta_data['correcta']) ? 1 : 0;
                        $respuesta = new Respuesta(null, $pregunta_id, $texto_respuesta, $es_correcta);
                        $this->guardarRespuesta($respuesta);
                    }
                } else {
                    echo "Error al guardar la pregunta.";
                    return;
                }
            }

            echo "Preguntas guardadas exitosamente.";
        } else {
            require 'views/agregar_preguntas.php';
        }
    }

    private function guardarPregunta(Pregunta $pregunta)
    {
        $stmt = $this->conn->prepare("INSERT INTO tbl_preguntas (pre_cue_id, pre_texto) VALUES (?, ?)");
        $pre_cue_id = $pregunta->getPreCueId();
        $pre_texto = $pregunta->getPreTexto();
        $stmt->bind_param("is", $pre_cue_id, $pre_texto);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    private function guardarRespuesta(Respuesta $respuesta)
    {
        $stmt = $this->conn->prepare("INSERT INTO tbl_respuestas (res_pre_id, res_texto, res_es_correcta) VALUES (?, ?, ?)");
        $res_pre_id = $respuesta->getResPreId();
        $res_texto = $respuesta->getResTexto();
        $res_es_correcta = $respuesta->getResEsCorrecta();

        $stmt->bind_param("isi", $res_pre_id, $res_texto, $res_es_correcta);

        if ($stmt->execute()) {
            echo "Respuesta guardada correctamente.";
        } else {
            echo "Error al guardar la respuesta: " . $stmt->error;
        }
    }

    // Dentro de CuestionarioController
    public function realizarEncuesta($cue_id)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $usuario_id = $_SESSION['usuario_id'];

        // Verificar si el usuario ya ha realizado este cuestionario
        if ($this->haRealizadoCuestionario($usuario_id, $cue_id)) {
            // Obtener la calificación del cuestionario para mostrarla
            $calificacion = $this->obtenerCalificacionCuestionario($usuario_id, $cue_id);

            // Cargar la vista de resultado_encuesta.php y pasar la calificación como variable
            require_once 'views/resultado_encuesta.php';
            return;
        }

        // Si no ha realizado el cuestionario, proceder a mostrar las preguntas
        $preguntas = $this->getPreguntasByCuestionarioId($cue_id);

        if ($preguntas) {
            require_once 'views/realizar_encuesta.php';
        } else {
            echo "No se encontraron preguntas para este cuestionario.";
        }
    }

    private function haRealizadoCuestionario($usuario_id, $cue_id)
    {
        $stmt = $this->conn->prepare("SELECT cal_id FROM tbl_calificaciones WHERE cal_usu_id = ? AND cal_cue_id = ?");
        $stmt->bind_param("ii", $usuario_id, $cue_id);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
    private function obtenerCalificacionCuestionario($usuario_id, $cue_id)
    {
        $stmt = $this->conn->prepare("SELECT cal_calificacion FROM tbl_calificaciones WHERE cal_usu_id = ? AND cal_cue_id = ?");
        $stmt->bind_param("ii", $usuario_id, $cue_id);
        $stmt->execute();
        $stmt->bind_result($calificacion);
        $stmt->fetch();
        return $calificacion;
    }


    private function getPreguntasByCuestionarioId($cue_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tbl_preguntas WHERE pre_cue_id = ?");
        $stmt->bind_param("i", $cue_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $preguntas = array();
        while ($row = $result->fetch_assoc()) {
            $pregunta = array(
                'pre_id' => $row['pre_id'],
                'pre_texto' => $row['pre_texto'],
                'respuestas' => $this->getRespuestasByPreguntaId($row['pre_id'])
            );
            $preguntas[] = $pregunta;
        }
        return $preguntas;
    }

    private function getRespuestasByPreguntaId($pre_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tbl_respuestas WHERE res_pre_id = ?");
        $stmt->bind_param("i", $pre_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $respuestas = array();
        while ($row = $result->fetch_assoc()) {
            $respuesta = array(
                'res_id' => $row['res_id'],
                'res_texto' => $row['res_texto'],
                'res_es_correcta' => $row['res_es_correcta']
            );
            $respuestas[] = $respuesta;
        }
        return $respuestas;
    }

    public function submitEncuesta()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id'])) {
            die("Usuario no autenticado.");
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['cue_id']) && isset($_POST['respuestas'])) {
                $usu_id = $_SESSION['usuario_id'];
                $cue_id = $_POST['cue_id'];
                $respuestas = $_POST['respuestas'];

                $calificacion = 0;

                foreach ($respuestas as $pre_id => $res_id) {
                    // Obtener la respuesta correcta desde la base de datos
                    $respuesta_correcta = $this->getRespuestaCorrecta($pre_id);

                    if ($respuesta_correcta && $res_id == $respuesta_correcta['res_id']) {
                        // Sumar 2 puntos por cada respuesta correcta
                        $calificacion += 2;
                    }

                    // Registrar la respuesta del estudiante
                    $this->guardarRespuestaEstudiante($usu_id, $cue_id, $pre_id, $res_id);
                }

                // Guardar la calificación en la tabla de calificaciones si aún no está registrada
                $this->guardarCalificacion($usu_id, $cue_id, $calificacion);

                // Redirigir a la página de resultados con el cue_id como POST
                echo "<form id='redirectForm' method='POST' action='index.php?action=resultadoEncuesta'>
                    <input type='hidden' name='cue_id' value='$cue_id'>
                  </form>
                  <script type='text/javascript'>document.getElementById('redirectForm').submit();</script>";
                exit;
            } else {
                echo "Error: Respuestas no recibidas.";
            }
        } else {
            echo "Error: Método de solicitud no permitido.";
        }
    }

    private function getRespuestaCorrecta($pre_id)
    {
        $stmt = $this->conn->prepare("SELECT res_id FROM tbl_respuestas WHERE res_pre_id = ? AND res_es_correcta = 1");
        $stmt->bind_param("i", $pre_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    private function guardarRespuestaEstudiante($usu_id, $cue_id, $pre_id, $res_id)
    {
        // Verificar si la entrada ya existe
        if ($this->existeRespuestaEstudiante($usu_id, $cue_id, $pre_id)) {
            echo "Ya has respondido esta pregunta anteriormente.";
            return;
        }

        // Preparar la consulta para insertar la respuesta del estudiante
        $query = "INSERT INTO tbl_respuestas_estudiantes (res_est_usu_id, res_est_cue_id, res_est_pre_id, res_est_res_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt === false) {
            die('Error de preparación de la consulta: ' . $this->conn->error);
        }

        $stmt->bind_param("iiii", $usu_id, $cue_id, $pre_id, $res_id);

        if (!$stmt->execute()) {
            echo "Error al guardar la respuesta del estudiante: " . $stmt->error;
        }

        $stmt->close();
    }
    private function existeRespuestaEstudiante($usu_id, $cue_id, $pre_id)
    {
        $stmt = $this->conn->prepare("SELECT res_est_id FROM tbl_respuestas_estudiantes WHERE res_est_usu_id = ? AND res_est_cue_id = ? AND res_est_pre_id = ?");
        $stmt->bind_param("iii", $usu_id, $cue_id, $pre_id);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    private function guardarCalificacion($usu_id, $cue_id, $calificacion)
    {
        // Verificar si ya existe una calificación para este usuario y cuestionario
        $query = "SELECT cal_id FROM tbl_calificaciones WHERE cal_usu_id = ? AND cal_cue_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $usu_id, $cue_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Actualizar la calificación si ya existe
            $update_query = "UPDATE tbl_calificaciones SET cal_calificacion = ? WHERE cal_usu_id = ? AND cal_cue_id = ?";
            $update_stmt = $this->conn->prepare($update_query);
            $update_stmt->bind_param("iii", $calificacion, $usu_id, $cue_id);
            $update_stmt->execute();
            $update_stmt->close();
        } else {
            // Insertar la calificación si no existe
            $insert_query = "INSERT INTO tbl_calificaciones (cal_usu_id, cal_cue_id, cal_calificacion) VALUES (?, ?, ?)";
            $insert_stmt = $this->conn->prepare($insert_query);
            $insert_stmt->bind_param("iii", $usu_id, $cue_id, $calificacion);
            $insert_stmt->execute();
            $insert_stmt->close();
        }

        $stmt->close();
    }

    public function resultadoEncuesta()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario_id = $_SESSION['usuario_id'];
            $cue_id = $_POST['cue_id'];

            // Obtener la calificación del cuestionario para mostrarla
            $calificacion = $this->obtenerCalificacionCuestionario($usuario_id, $cue_id);

            if ($calificacion === false) {
                echo "Error al obtener la calificación del cuestionario.";
                return;
            }

            // Cargar la vista de resultado_encuesta.php y pasar la calificación como variable
            require_once 'views/resultado_encuesta.php';
        } else {
            header('Location: index.php?action=estudianteDashboard');
            exit;
        }
    }

    public function obtenerCuestionarios()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $usuario_id = $_SESSION['usuario_id'];

        $query = "SELECT c.*, 
                     IFNULL(cal.cal_calificacion, 'No realizado') as calificacion
              FROM tbl_cuestionarios c
              LEFT JOIN tbl_calificaciones cal ON c.cue_id = cal.cal_cue_id AND cal.cal_usu_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $cuestionarios = [];
        while ($row = $result->fetch_assoc()) {
            $cuestionarios[] = new Cuestionario(
                $row['cue_id'],
                $row['cue_titulo'],
                $row['cue_descripcion'],
                $row['cue_profesor_id'],
                $row['calificacion']
            );
        }

        return $cuestionarios;
    }


}
