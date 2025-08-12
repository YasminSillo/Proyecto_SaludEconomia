<?php

class PagoRepository
{
    private $db;

    public function __construct(DatabaseConnectionInterface $db)
    {
        $this->db = $db;
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, pe.numero_pedido, c.nombre as cliente_nombre 
            FROM pagos p 
            LEFT JOIN pedidos pe ON p.pedido_id = pe.id_pedido
            LEFT JOIN clientes c ON p.cliente_id = c.id_cliente 
            WHERE p.id_pago = ?
        ");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        
        if (!$data) {
            return null;
        }

        return $this->mapearPago($data);
    }

    public function obtenerTodos()
    {
        $stmt = $this->db->prepare("
            SELECT p.*, pe.numero_pedido, c.nombre as cliente_nombre 
            FROM pagos p 
            LEFT JOIN pedidos pe ON p.pedido_id = pe.id_pedido
            LEFT JOIN clientes c ON p.cliente_id = c.id_cliente 
            ORDER BY p.fecha DESC
        ");
        $stmt->execute();
        $pagos = [];
        
        while ($data = $stmt->fetch()) {
            $pagos[] = $this->mapearPago($data);
        }
        
        return $pagos;
    }

    public function obtenerPorMetodo($metodo)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, pe.numero_pedido, c.nombre as cliente_nombre 
            FROM pagos p 
            LEFT JOIN pedidos pe ON p.pedido_id = pe.id_pedido
            LEFT JOIN clientes c ON p.cliente_id = c.id_cliente 
            WHERE p.metodo_pago = ?
            ORDER BY p.fecha DESC
        ");
        $stmt->execute([$metodo]);
        $pagos = [];
        
        while ($data = $stmt->fetch()) {
            $pagos[] = $this->mapearPago($data);
        }
        
        return $pagos;
    }

    public function obtenerPorFecha($fecha)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, pe.numero_pedido, c.nombre as cliente_nombre 
            FROM pagos p 
            LEFT JOIN pedidos pe ON p.pedido_id = pe.id_pedido
            LEFT JOIN clientes c ON p.cliente_id = c.id_cliente 
            WHERE DATE(p.fecha) = ?
            ORDER BY p.fecha DESC
        ");
        $stmt->execute([$fecha]);
        $pagos = [];
        
        while ($data = $stmt->fetch()) {
            $pagos[] = $this->mapearPago($data);
        }
        
        return $pagos;
    }

    public function obtenerResumenDiario($fecha = null)
    {
        $fechaConsulta = $fecha ?? date('Y-m-d');
        
        $stmt = $this->db->prepare("
            SELECT 
                COUNT(*) as total_pagos,
                SUM(monto) as total_recaudado,
                SUM(CASE WHEN metodo_pago = 'efectivo' THEN monto ELSE 0 END) as total_efectivo,
                SUM(CASE WHEN metodo_pago IN ('tarjeta', 'transferencia') THEN monto ELSE 0 END) as total_digital
            FROM pagos 
            WHERE DATE(fecha) = ?
        ");
        $stmt->execute([$fechaConsulta]);
        
        return $stmt->fetch();
    }

    public function guardar(Pago $pago)
    {
        $sql = "INSERT INTO pagos (pedido_id, cliente_id, monto, metodo_pago, fecha) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            $pago->getPedidoId(),
            $pago->getClienteId(),
            $pago->getMonto(),
            $pago->getMetodoPago(),
            $pago->getFecha()
        ]);
        
        if ($success) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }

    private function mapearPago($data)
    {
        $pago = new Pago(
            $data['id_pago'],
            $data['pedido_id'],
            $data['cliente_id'],
            $data['monto'],
            $data['metodo_pago'],
            $data['fecha']
        );
        
        // Agregar información adicional
        if (isset($data['numero_pedido'])) {
            $pago->numero_pedido = $data['numero_pedido'];
        }
        if (isset($data['cliente_nombre'])) {
            $pago->cliente_nombre = $data['cliente_nombre'];
        }
        
        return $pago;
    }
}