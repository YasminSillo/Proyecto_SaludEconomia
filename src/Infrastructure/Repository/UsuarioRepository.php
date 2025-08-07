<?php

class UsuarioRepository implements UsuarioRepositoryInterface
{
    private $db;

    public function __construct(DatabaseConnectionInterface $db)
    {
        $this->db = $db;
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        
        if (!$data) {
            return null;
        }

        return $this->mapearUsuario($data);
    }

    public function obtenerPorEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $data = $stmt->fetch();
        
        if (!$data) {
            return null;
        }

        return $this->mapearUsuario($data);
    }

    public function guardar(Usuario $usuario)
    {
        $sql = "INSERT INTO usuarios (nombre, email, password_hash, rol) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $usuario->getNombre(),
            $usuario->getEmail(),
            $usuario->getPasswordHash(),
            $usuario->getRol()
        ]);
    }

    public function actualizar(Usuario $usuario)
    {
        $sql = "UPDATE usuarios SET nombre = ?, email = ?, password_hash = ?, rol = ? WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $usuario->getNombre(),
            $usuario->getEmail(),
            $usuario->getPasswordHash(),
            $usuario->getRol(),
            $usuario->getId()
        ]);
    }

    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerTodos()
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios ORDER BY nombre");
        $stmt->execute();
        $usuarios = [];
        
        while ($data = $stmt->fetch()) {
            $usuarios[] = $this->mapearUsuario($data);
        }
        
        return $usuarios;
    }

    private function mapearUsuario($data)
    {
        return new Usuario(
            $data['id_usuario'],
            $data['nombre'],
            $data['email'],
            $data['password_hash'],
            $data['rol'],
            $data['created_at']
        );
    }
}