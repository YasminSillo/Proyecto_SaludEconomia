<?php

class PedidoRepository implements PedidoRepositoryInterface
{
    private $db;

    public function __construct(DatabaseConnectionInterface $db)
    {
        $this->db = $db;
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, c.nombre as cliente_nombre, u.nombre as usuario_nombre 
            FROM pedidos p 
            LEFT JOIN clientes c ON p.cliente_id = c.id_cliente 
            LEFT JOIN usuarios u ON p.usuario_id = u.id_usuario 
            WHERE p.id_pedido = ?
        ");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        
        if (!$data) {
            return null;
        }

        return $this->mapearPedido($data);
    }

    public function obtenerPorNumero($numero)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, c.nombre as cliente_nombre, u.nombre as usuario_nombre 
            FROM pedidos p 
            LEFT JOIN clientes c ON p.cliente_id = c.id_cliente 
            LEFT JOIN usuarios u ON p.usuario_id = u.id_usuario 
            WHERE p.numero_pedido = ?
        ");
        $stmt->execute([$numero]);
        $data = $stmt->fetch();
        
        if (!$data) {
            return null;
        }

        return $this->mapearPedido($data);
    }

    public function guardar(Pedido $pedido)
    {
        $sql = "INSERT INTO pedidos (numero_pedido, cliente_id, usuario_id, estado, fecha) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            $pedido->getNumeroPedido(),
            $pedido->getClienteId(),
            $pedido->getUsuarioId(),
            $pedido->getEstado(),
            $pedido->getFecha()
        ]);
        
        if ($success) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }

    public function actualizar(Pedido $pedido)
    {
        $sql = "UPDATE pedidos SET numero_pedido = ?, cliente_id = ?, usuario_id = ?, estado = ? WHERE id_pedido = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $pedido->getNumeroPedido(),
            $pedido->getClienteId(),
            $pedido->getUsuarioId(),
            $pedido->getEstado(),
            $pedido->getId()
        ]);
    }

    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM pedidos WHERE id_pedido = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerTodos()
    {
        $stmt = $this->db->prepare("
            SELECT p.*, c.nombre as cliente_nombre, u.nombre as usuario_nombre 
            FROM pedidos p 
            LEFT JOIN clientes c ON p.cliente_id = c.id_cliente 
            LEFT JOIN usuarios u ON p.usuario_id = u.id_usuario 
            ORDER BY p.fecha DESC
        ");
        $stmt->execute();
        $pedidos = [];
        
        while ($data = $stmt->fetch()) {
            $pedidos[] = $this->mapearPedido($data);
        }
        
        return $pedidos;
    }

    public function obtenerPorCliente($clienteId)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, c.nombre as cliente_nombre, u.nombre as usuario_nombre 
            FROM pedidos p 
            LEFT JOIN clientes c ON p.cliente_id = c.id_cliente 
            LEFT JOIN usuarios u ON p.usuario_id = u.id_usuario 
            WHERE p.cliente_id = ? 
            ORDER BY p.fecha DESC
        ");
        $stmt->execute([$clienteId]);
        $pedidos = [];
        
        while ($data = $stmt->fetch()) {
            $pedidos[] = $this->mapearPedido($data);
        }
        
        return $pedidos;
    }

    public function obtenerPorEstado($estado)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, c.nombre as cliente_nombre, u.nombre as usuario_nombre 
            FROM pedidos p 
            LEFT JOIN clientes c ON p.cliente_id = c.id_cliente 
            LEFT JOIN usuarios u ON p.usuario_id = u.id_usuario 
            WHERE p.estado = ? 
            ORDER BY p.fecha DESC
        ");
        $stmt->execute([$estado]);
        $pedidos = [];
        
        while ($data = $stmt->fetch()) {
            $pedidos[] = $this->mapearPedido($data);
        }
        
        return $pedidos;
    }

    public function obtenerPorFecha($fecha)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, c.nombre as cliente_nombre, u.nombre as usuario_nombre 
            FROM pedidos p 
            LEFT JOIN clientes c ON p.cliente_id = c.id_cliente 
            LEFT JOIN usuarios u ON p.usuario_id = u.id_usuario 
            WHERE DATE(p.fecha) = ? 
            ORDER BY p.fecha DESC
        ");
        $stmt->execute([$fecha]);
        $pedidos = [];
        
        while ($data = $stmt->fetch()) {
            $pedidos[] = $this->mapearPedido($data);
        }
        
        return $pedidos;
    }

    public function obtenerConTotal()
    {
        $stmt = $this->db->prepare("
            SELECT p.*, c.nombre as cliente_nombre, u.nombre as usuario_nombre,
                   COALESCE(SUM(pd.cantidad * pd.precio_unitario), 0) as total
            FROM pedidos p 
            LEFT JOIN clientes c ON p.cliente_id = c.id_cliente 
            LEFT JOIN usuarios u ON p.usuario_id = u.id_usuario 
            LEFT JOIN pedido_detalles pd ON p.id_pedido = pd.pedido_id
            GROUP BY p.id_pedido
            ORDER BY p.fecha DESC
        ");
        $stmt->execute();
        $pedidos = [];
        
        while ($data = $stmt->fetch()) {
            $pedido = $this->mapearPedido($data);
            $pedido->total = $data['total']; // Agregar total calculado
            $pedidos[] = $pedido;
        }
        
        return $pedidos;
    }

    private function mapearPedido($data)
    {
        $pedido = new Pedido(
            $data['id_pedido'],
            $data['numero_pedido'],
            $data['cliente_id'],
            $data['usuario_id'],
            $data['estado'],
            $data['fecha']
        );
        
        // Agregar información adicional
        if (isset($data['cliente_nombre'])) {
            $pedido->cliente_nombre = $data['cliente_nombre'];
        }
        if (isset($data['usuario_nombre'])) {
            $pedido->usuario_nombre = $data['usuario_nombre'];
        }
        
        return $pedido;
    }
}