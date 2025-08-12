<?php

class CompraRepository
{
    private $db;

    public function __construct(DatabaseConnectionInterface $db)
    {
        $this->db = $db;
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("
            SELECT c.*, p.nombre_empresa as proveedor_nombre, u.nombre as usuario_nombre 
            FROM compras c 
            LEFT JOIN proveedores p ON c.proveedor_id = p.id_proveedor 
            LEFT JOIN usuarios u ON c.usuario_id = u.id_usuario 
            WHERE c.id_compra = ?
        ");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        
        if (!$data) {
            return null;
        }

        return $this->mapearCompra($data);
    }

    public function obtenerTodas()
    {
        $stmt = $this->db->prepare("
            SELECT c.*, p.nombre_empresa as proveedor_nombre, u.nombre as usuario_nombre,
                   COALESCE(SUM(cd.cantidad_pedida * cd.precio_unitario), 0) as total
            FROM compras c 
            LEFT JOIN proveedores p ON c.proveedor_id = p.id_proveedor 
            LEFT JOIN usuarios u ON c.usuario_id = u.id_usuario 
            LEFT JOIN compra_detalles cd ON c.id_compra = cd.compra_id
            GROUP BY c.id_compra
            ORDER BY c.fecha DESC
        ");
        $stmt->execute();
        $compras = [];
        
        while ($data = $stmt->fetch()) {
            $compra = $this->mapearCompra($data);
            $compra->total = $data['total']; // Agregar total calculado
            $compras[] = $compra;
        }
        
        return $compras;
    }

    public function obtenerPorEstado($estado)
    {
        $stmt = $this->db->prepare("
            SELECT c.*, p.nombre_empresa as proveedor_nombre, u.nombre as usuario_nombre,
                   COALESCE(SUM(cd.cantidad_pedida * cd.precio_unitario), 0) as total
            FROM compras c 
            LEFT JOIN proveedores p ON c.proveedor_id = p.id_proveedor 
            LEFT JOIN usuarios u ON c.usuario_id = u.id_usuario 
            LEFT JOIN compra_detalles cd ON c.id_compra = cd.compra_id
            WHERE c.estado = ?
            GROUP BY c.id_compra
            ORDER BY c.fecha DESC
        ");
        $stmt->execute([$estado]);
        $compras = [];
        
        while ($data = $stmt->fetch()) {
            $compra = $this->mapearCompra($data);
            $compra->total = $data['total'];
            $compras[] = $compra;
        }
        
        return $compras;
    }

    public function obtenerPorProveedor($proveedorId)
    {
        $stmt = $this->db->prepare("
            SELECT c.*, p.nombre_empresa as proveedor_nombre, u.nombre as usuario_nombre 
            FROM compras c 
            LEFT JOIN proveedores p ON c.proveedor_id = p.id_proveedor 
            LEFT JOIN usuarios u ON c.usuario_id = u.id_usuario 
            WHERE c.proveedor_id = ?
            ORDER BY c.fecha DESC
        ");
        $stmt->execute([$proveedorId]);
        $compras = [];
        
        while ($data = $stmt->fetch()) {
            $compras[] = $this->mapearCompra($data);
        }
        
        return $compras;
    }

    public function guardar(Compra $compra)
    {
        $sql = "INSERT INTO compras (numero_compra, proveedor_id, usuario_id, estado, fecha) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            $compra->getNumeroCompra(),
            $compra->getProveedorId(),
            $compra->getUsuarioId(),
            $compra->getEstado(),
            $compra->getFecha()
        ]);
        
        if ($success) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }

    public function actualizar(Compra $compra)
    {
        $sql = "UPDATE compras SET numero_compra = ?, proveedor_id = ?, usuario_id = ?, estado = ? WHERE id_compra = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $compra->getNumeroCompra(),
            $compra->getProveedorId(),
            $compra->getUsuarioId(),
            $compra->getEstado(),
            $compra->getId()
        ]);
    }

    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM compras WHERE id_compra = ?");
        return $stmt->execute([$id]);
    }

    private function mapearCompra($data)
    {
        $compra = new Compra(
            $data['id_compra'],
            $data['numero_compra'],
            $data['proveedor_id'],
            $data['usuario_id'],
            $data['estado'],
            $data['fecha']
        );
        
        // Agregar información adicional
        if (isset($data['proveedor_nombre'])) {
            $compra->proveedor_nombre = $data['proveedor_nombre'];
        }
        if (isset($data['usuario_nombre'])) {
            $compra->usuario_nombre = $data['usuario_nombre'];
        }
        
        return $compra;
    }
}