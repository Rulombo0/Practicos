<?php
namespace App\Controllers;

use App\Models\UsuarioModel;

class AuthController {
    private $db;

    // Construktor
    public function __construct($db) {
        $this->db = $db;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Funcion para el login, comprueba usuario y la contraseña, tmb genera la sesion
    public function login() {
        $datos = json_decode(file_get_contents('php://input'), true);
        if (!is_array($datos)) {
            $datos = [];
        }

        $usuario = trim((string) ($datos['usuario'] ?? ''));
        $password = (string) ($datos['password'] ?? '');

        if ($usuario === '' || $password === '') {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Usuario y contraseña son obligatorios'
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        $usuarioModel = new UsuarioModel($this->db);
        $fila = $usuarioModel->buscarPorUsuario($usuario);

        if (!$fila || !password_verify($password, $fila['password_hash'])) {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'message' => 'Usuario o contraseña incorrectos'
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        session_regenerate_id(true);
        $_SESSION['usuario_id'] = (int) $fila['id_usuario'];
        $_SESSION['usuario'] = $fila['usuario'];
        $_SESSION['nombre'] = $fila['nombre'];
        $_SESSION['rol'] = $fila['rol'];

        echo json_encode([
            'status' => 'ok',
            'message' => 'Login correcto',
            'data' => [
                'usuario' => $fila['usuario'],
                'nombre' => $fila['nombre'],
                'rol' => $fila['rol']
            ]
        ], JSON_UNESCAPED_UNICODE);
    }

    // Funcion que valida el formulario y crea el usuario 
    public function registro() {
        $datos = json_decode(file_get_contents('php://input'), true);
        if (!is_array($datos)) {
            $datos = [];
        }

        $nombre = trim((string) ($datos['nombre'] ?? ''));
        $usuario = trim((string) ($datos['usuario'] ?? ''));
        $password = (string) ($datos['password'] ?? '');

        if ($nombre === '' || $usuario === '' || $password === '') {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Nombre, usuario y contraseña son obligatorios'
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        if (strlen($password) < 6) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'La contraseña debe tener al menos 6 caracteres'
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        $usuarioModel = new UsuarioModel($this->db);

        if ($usuarioModel->buscarPorUsuario($usuario)) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Ese usuario ya existe'
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        $id = $usuarioModel->crear($usuario, password_hash($password, PASSWORD_DEFAULT), $nombre);

        if (!$id) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'No se pudo crear la cuenta'
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        echo json_encode([
            'status' => 'ok',
            'message' => 'Cuenta creada. Ya puedes iniciar sesión.'
        ], JSON_UNESCAPED_UNICODE);
    }

    // Funcion que muestra la sesion activa
    public function sesion() {
        if (empty($_SESSION['usuario_id'])) {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'message' => 'No hay sesión'
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        echo json_encode([
            'status' => 'ok',
            'data' => [
                'usuario' => $_SESSION['usuario'],
                'nombre' => $_SESSION['nombre'],
                'rol' => $_SESSION['rol']
            ]
        ], JSON_UNESCAPED_UNICODE);
    }

    // Funcion para desloguearte, borra la sesion y GALLETITA (cookie)
    public function logout() {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        echo json_encode([
            'status' => 'ok',
            'message' => 'Sesión cerrada'
        ], JSON_UNESCAPED_UNICODE);
    }
}
