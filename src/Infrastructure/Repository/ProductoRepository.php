<?php

class ProductoRepository implements ProductoRepositoryInterface
{
    private $db;

    public function __construct(DatabaseConnectionInterface $db)
    {
        $this->db = $db;
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id_producto = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        
        if (!$data) {
            return null;
        }

        return $this->mapearProducto($data);
    }

    public function obtenerPorSku($sku)
    {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE codigo_sku = ?");
        $stmt->execute([$sku]);
        $data = $stmt->fetch();
        
        if (!$data) {
            return null;
        }

        return $this->mapearProducto($data);
    }

    public function guardar(Producto $producto)
    {
        $sql = "INSERT INTO productos (codigo_sku, nombre, descripcion, precio, categoria_id, proveedor_id, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $producto->getCodigoSku(),
            $producto->getNombre(),
            $producto->getDescripcion(),
            $producto->getPrecio(),
            $producto->getCategoriaId(),
            $producto->getProveedorId(),
            $producto->getImagen()
        ]);
    }

    public function actualizar(Producto $producto)
    {
        $sql = "UPDATE productos SET codigo_sku = ?, nombre = ?, descripcion = ?, precio = ?, categoria_id = ?, proveedor_id = ?, imagen = ? WHERE id_producto = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $producto->getCodigoSku(),
            $producto->getNombre(),
            $producto->getDescripcion(),
            $producto->getPrecio(),
            $producto->getCategoriaId(),
            $producto->getProveedorId(),
            $producto->getImagen(),
            $producto->getId()
        ]);
    }

    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id_producto = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerTodos()
    {
        $stmt = $this->db->prepare("
            SELECT p.*, c.nombre as categoria_nombre, pr.nombre_empresa as proveedor_nombre 
            FROM productos p 
            LEFT JOIN categorias c ON p.categoria_id = c.id_categoria 
            LEFT JOIN proveedores pr ON p.proveedor_id = pr.id_proveedor 
            ORDER BY p.nombre
        ");
        $stmt->execute();
        $productos = [];
        
        while ($data = $stmt->fetch()) {
            $productos[] = $this->mapearProductoConRelaciones($data);
        }
        
        return $productos;
    }

    public function obtenerPorCategoria($categoriaId)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, c.nombre as categoria_nombre, pr.nombre_empresa as proveedor_nombre 
            FROM productos p 
            LEFT JOIN categorias c ON p.categoria_id = c.id_categoria 
            LEFT JOIN proveedores pr ON p.proveedor_id = pr.id_proveedor 
            WHERE p.categoria_id = ? 
            ORDER BY p.nombre
        ");
        $stmt->execute([$categoriaId]);
        $productos = [];
        
        while ($data = $stmt->fetch()) {
            $productos[] = $this->mapearProductoConRelaciones($data);
        }
        
        return $productos;
    }

    public function buscarPorNombre($nombre)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, c.nombre as categoria_nombre, pr.nombre_empresa as proveedor_nombre 
            FROM productos p 
            LEFT JOIN categorias c ON p.categoria_id = c.id_categoria 
            LEFT JOIN proveedores pr ON p.proveedor_id = pr.id_proveedor 
            WHERE p.nombre LIKE ? 
            ORDER BY p.nombre
        ");
        $stmt->execute(["%{$nombre}%"]);
        $productos = [];
        
        while ($data = $stmt->fetch()) {
            $productos[] = $this->mapearProductoConRelaciones($data);
        }
        
        return $productos;
    }

    private function mapearProducto($data)
    {
        return new Producto(
            $data['id_producto'],
            $data['codigo_sku'],
            $data['nombre'],
            $data['categoria_id'],
            $data['proveedor_id'],
            $data['descripcion'] ?? null,
            $data['precio'] ?? null,
            $data['imagen'] ?? null
        );
    }

    private function mapearProductoConRelaciones($data)
    {
        $producto = $this->mapearProducto($data);
        // Agregar propiedades adicionales para mostrar en vistas
        $producto->categoriaNombre = $data['categoria_nombre'] ?? '';
        $producto->proveedorNombre = $data['proveedor_nombre'] ?? '';
        return $producto;
    }
}