<?php

class ProveedorRepository implements ProveedorRepositoryInterface
{
    private $db;

    public function __construct(DatabaseConnectionInterface $db)
    {
        $this->db = $db;
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM proveedores WHERE id_proveedor = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        
        if (!$data) {
            return null;
        }

        return $this->mapearProveedor($data);
    }

    public function obtenerPorRuc($ruc)
    {
        $stmt = $this->db->prepare("SELECT * FROM proveedores WHERE ruc = ?");
        $stmt->execute([$ruc]);
        $data = $stmt->fetch();
        
        if (!$data) {
            return null;
        }

        return $this->mapearProveedor($data);
    }

    public function guardar(Proveedor $proveedor)
    {
        $sql = "INSERT INTO proveedores (nombre_empresa, contacto_nombre, email, ruc) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            $proveedor->getNombreEmpresa(),
            $proveedor->getContactoNombre(),
            $proveedor->getEmail(),
            $proveedor->getRuc()
        ]);
        
        if ($success) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }

    public function actualizar(Proveedor $proveedor)
    {
        $sql = "UPDATE proveedores SET nombre_empresa = ?, contacto_nombre = ?, email = ?, ruc = ? WHERE id_proveedor = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $proveedor->getNombreEmpresa(),
            $proveedor->getContactoNombre(),
            $proveedor->getEmail(),
            $proveedor->getRuc(),
            $proveedor->getId()
        ]);
    }

    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM proveedores WHERE id_proveedor = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerTodos()
    {
        $stmt = $this->db->prepare("SELECT * FROM proveedores ORDER BY nombre_empresa");
        $stmt->execute();
        $proveedores = [];
        
        while ($data = $stmt->fetch()) {
            $proveedores[] = $this->mapearProveedor($data);
        }
        
        return $proveedores;
    }

    public function buscarPorNombre($nombre)
    {
        $stmt = $this->db->prepare("SELECT * FROM proveedores WHERE nombre_empresa LIKE ? ORDER BY nombre_empresa");
        $stmt->execute(["%{$nombre}%"]);
        $proveedores = [];
        
        while ($data = $stmt->fetch()) {
            $proveedores[] = $this->mapearProveedor($data);
        }
        
        return $proveedores;
    }

    private function mapearProveedor($data)
    {
        return new Proveedor(
            $data['id_proveedor'],
            $data['nombre_empresa'],
            $data['contacto_nombre'],
            $data['email'],
            $data['ruc']
        );
    }
}