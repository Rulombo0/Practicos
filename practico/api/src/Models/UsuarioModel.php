<?php
namespace App\Models;

class UsuarioModel {
    private $db;

    // constructor
    public function __construct($db) {
        $this->db = $db;
    }

    // Funcion para buscar usuario
    public function buscarPorUsuario($usuario) {
        try {
            $stmt = $this->db->prepare(
                'SELECT u.id_usuario, u.usuario, u.password_hash, u.nombre, t.nombre AS rol
                FROM usuario u
                INNER JOIN tipousuario t ON u.id_tipousuario = t.id_tipousuario
                WHERE u.usuario = :usuario
                LIMIT 1'
            );
            $stmt->execute(['usuario' => $usuario]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return false;
        }
    }

    // Crear usuario tipo 2 (usuario normal)
    public function crear($usuario, $passwordHash, $nombre) {
        try {
            $stmt = $this->db->prepare(
                'INSERT INTO usuario (usuario, password_hash, nombre, id_tipousuario)
                VALUES (:usuario, :password_hash, :nombre, 2)'
            );
            $stmt->execute([
                'usuario' => $usuario,
                'password_hash' => $passwordHash,
                'nombre' => $nombre
            ]);
            return (int) $this->db->lastInsertId();
        } catch (\Exception $e) {
            return false;
        }
    }
}
