<?php
require_once 'config/database.php';
require_once 'models/Usuario.php';
require_once 'models/Cuestionario.php'; // Asegúrate de incluir el modelo de Cuestionario

class UsuarioController {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function index() {
        $action = isset($_GET['action']) ? $_GET['action'] : 'login';
        switch ($action) {
            case 'login':
                $this->login();
                break;
            case 'authenticate':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $correo = $_POST['correo'];
                    $contrasena = $_POST['contrasena'];
                    $this->authenticate($correo, $contrasena);
                }
                break;
            case 'logout':
                $this->logout();
                break;
            default:
                $this->login();
                break;
        }
    }

    public function login() {
        require 'views/login.php';
    }

    public function authenticate($correo, $contrasena) {
        $usuario = $this->getUsuarioByCorreo($correo);

        if (!$usuario) {
            echo "Usuario no encontrado.";
            return;
        }

        // Comparar contraseñas sin encriptar
        if ($contrasena === $usuario->getUsuContrasena()) {
            session_start();
            $_SESSION['usuario_id'] = $usuario->getUsuId();
            $_SESSION['usuario_nombre'] = $usuario->getUsuNombre();
            $_SESSION['usuario_perfil'] = $usuario->getUsuPerId();

            if ($usuario->getUsuPerId() == 2) { // 2 para Profesor
                header('Location: index.php?action=profesorDashboard');
            } elseif ($usuario->getUsuPerId() == 1) { // 1 para Estudiante
                header('Location: index.php?action=estudianteDashboard');
            } else {
                echo "Perfil no reconocido.";
            }
        } else {
            echo "Correo o contraseña incorrectos";
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php?action=login');
    }

    public function getUsuarioByCorreo($correo) {
        $stmt = $this->conn->prepare("SELECT * FROM tbl_usuarios WHERE usu_correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $usuario = new Usuario(
                $row['usu_id'],
                $row['usu_nombre'],
                $row['usu_correo'],
                $row['usu_contrasena'],
                $row['usu_per_id']
            );
            return $usuario;
        }
        return null;
    }

    public function profesorDashboard() {
        require 'views/profesor_dashboard.php';
    }

    public function estudianteDashboard() {
        $cuestionarios = $this->getCuestionarios();
        require 'views/estudiante_dashboard.php';
    }

    public function realizarEncuesta($cue_id) {
        $cuestionarioController = new CuestionarioController();
        $cuestionarioController->realizarEncuesta($cue_id);
    }

    public function getCuestionarios() {
        $stmt = $this->conn->prepare("SELECT * FROM tbl_cuestionarios");
        $stmt->execute();
        $result = $stmt->get_result();



        $cuestionarios = array();
        while ($row = $result->fetch_assoc()) {
            // Crear objeto Cuestionario y agregarlo al array
            $cuestionario = new Cuestionario(
                $row['cue_id'],
                $row['cue_titulo'],
                $row['cue_descripcion'],
                $row['cue_profesor_id'],
                $this->obtenerCalificacionCuestionario($_SESSION['usuario_id'],$row['cue_id'])
            );
            $cuestionarios[] = $cuestionario;
        }

        return $cuestionarios;
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
}
?>
