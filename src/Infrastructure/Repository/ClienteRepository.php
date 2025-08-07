<?php

class ClienteRepository implements ClienteRepositoryInterface
{
    private $db;

    public function __construct(DatabaseConnectionInterface $db)
    {
        $this->db = $db;
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        
        if (!$data) {
            return null;
        }

        return $this->mapearCliente($data);
    }

    public function obtenerPorRucDni($rucDni)
    {
        $stmt = $this->db->prepare("SELECT * FROM clientes WHERE ruc_dni = ?");
        $stmt->execute([$rucDni]);
        $data = $stmt->fetch();
        
        if (!$data) {
            return null;
        }

        return $this->mapearCliente($data);
    }

    public function guardar(Cliente $cliente)
    {
        $sql = "INSERT INTO clientes (tipo_cliente, nombre, email, ruc_dni) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $cliente->getTipoCliente(),
            $cliente->getNombre(),
            $cliente->getEmail(),
            $cliente->getRucDni()
        ]);
    }

    public function actualizar(Cliente $cliente)
    {
        $sql = "UPDATE clientes SET tipo_cliente = ?, nombre = ?, email = ?, ruc_dni = ? WHERE id_cliente = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $cliente->getTipoCliente(),
            $cliente->getNombre(),
            $cliente->getEmail(),
            $cliente->getRucDni(),
            $cliente->getId()
        ]);
    }

    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM clientes WHERE id_cliente = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerTodos()
    {
        $stmt = $this->db->prepare("SELECT * FROM clientes ORDER BY nombre");
        $stmt->execute();
        $clientes = [];
        
        while ($data = $stmt->fetch()) {
            $clientes[] = $this->mapearCliente($data);
        }
        
        return $clientes;
    }

    public function buscarPorNombre($nombre)
    {
        $stmt = $this->db->prepare("SELECT * FROM clientes WHERE nombre LIKE ? ORDER BY nombre");
        $stmt->execute(["%{$nombre}%"]);
        $clientes = [];
        
        while ($data = $stmt->fetch()) {
            $clientes[] = $this->mapearCliente($data);
        }
        
        return $clientes;
    }

    private function mapearCliente($data)
    {
        return new Cliente(
            $data['id_cliente'],
            $data['tipo_cliente'],
            $data['nombre'],
            $data['email'],
            $data['ruc_dni']
        );
    }
}