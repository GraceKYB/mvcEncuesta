<?php
session_start();

// Incluir controladores y modelos necesarios
require_once 'controllers/UsuarioController.php';
require_once 'controllers/CuestionarioController.php';
require_once 'config/database.php';
require_once 'models/Usuario.php';

// Instanciar controladores
$usuarioController = new UsuarioController();
$cuestionarioController = new CuestionarioController();

// Determinar la acción a realizar
$action = $_GET['action'] ?? 'login';

// Verificar si el usuario está autenticado
function isAuthenticated() {
    return isset($_SESSION['usuario_id']);
}

function isRole($id): bool {
    return ($_SESSION['usuario_perfil'] ?? null) === $id;
}

switch ($action) {
    case 'authenticate':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $correo = $_POST['correo'];
            $contrasena = $_POST['contrasena'];
            $usuarioController->authenticate($correo, $contrasena);
        }
        break;
    case 'logout':
        $usuarioController->logout();
        break;
    case 'profesorDashboard':
        if (isAuthenticated()) {
            if (!isRole(2)) {
                echo 'No puedes acceder aquí maldito!';
                return;
            }
            $usuarioController->profesorDashboard();
        } else {
            header('Location: index.php?action=login');
        }
        break;
    case 'estudianteDashboard':
        if (isAuthenticated()) {
            if (!isRole(1)) {
                echo 'No puedes acceder aquí maldito!';
                return;
            }
            $usuarioController->estudianteDashboard();
        } else {
            header('Location: index.php?action=login');
        }
        break;
    case 'crearEncuesta':
        if (isAuthenticated()) {
            $cuestionarioController->crearEncuesta();
        } else {
            header('Location: index.php?action=login');
        }
        break;
    case 'agregarPreguntas':
        if (isAuthenticated() && isset($_SESSION['encuesta_id'])) {
            $encuesta_id = $_SESSION['encuesta_id'];
            $cuestionarioController->agregarPreguntas($encuesta_id);
        } else {
            header('Location: index.php?action=login');
        }
        break;
    case 'realizarEncuesta':
        if (isAuthenticated()) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cue_id'])) {
                $cue_id = $_POST['cue_id'];
            } elseif (isset($_GET['cue_id'])) {
                $cue_id = $_GET['cue_id'];
            } else {
                header('Location: index.php?action=estudianteDashboard');
                exit;
            }
            $cuestionarioController->realizarEncuesta($cue_id);
        } else {
            header('Location: index.php?action=login');
        }
        break;
    case 'submitEncuesta':
        if (isAuthenticated()) {
            $cuestionarioController->submitEncuesta();
        } else {
            header('Location: index.php?action=login');
        }
        break;
    case 'resultadoEncuesta':
        if (isAuthenticated()) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cue_id'])) {
                $cuestionarioController->resultadoEncuesta();
            } else {
                header('Location: index.php?action=estudianteDashboard');
                exit;
            }
        } else {
            header('Location: index.php?action=login');
        }
        break;
    default:
        $usuarioController->login();
        break;
}