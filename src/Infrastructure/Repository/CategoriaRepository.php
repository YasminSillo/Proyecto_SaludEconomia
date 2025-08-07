<?php

class CategoriaRepository implements CategoriaRepositoryInterface
{
    private $db;

    public function __construct(DatabaseConnectionInterface $db)
    {
        $this->db = $db;
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE id_categoria = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        
        if (!$data) {
            return null;
        }

        return $this->mapearCategoria($data);
    }

    public function guardar(Categoria $categoria)
    {
        $sql = "INSERT INTO categorias (nombre, descripcion, parent_id, activo) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $categoria->getNombre(),
            $categoria->getDescripcion(),
            $categoria->getParentId(),
            $categoria->getActivo() ? 1 : 0
        ]);
    }

    public function actualizar(Categoria $categoria)
    {
        $sql = "UPDATE categorias SET nombre = ?, descripcion = ?, parent_id = ?, activo = ? WHERE id_categoria = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $categoria->getNombre(),
            $categoria->getDescripcion(),
            $categoria->getParentId(),
            $categoria->getActivo() ? 1 : 0,
            $categoria->getId()
        ]);
    }

    public function eliminar($id)
    {
        $stmt = $this->db->prepare("DELETE FROM categorias WHERE id_categoria = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerTodas()
    {
        $stmt = $this->db->prepare("SELECT * FROM categorias ORDER BY nombre");
        $stmt->execute();
        $categorias = [];
        
        while ($data = $stmt->fetch()) {
            $categorias[] = $this->mapearCategoria($data);
        }
        
        return $categorias;
    }

    public function obtenerActivas()
    {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE activo = 1 ORDER BY nombre");
        $stmt->execute();
        $categorias = [];
        
        while ($data = $stmt->fetch()) {
            $categorias[] = $this->mapearCategoria($data);
        }
        
        return $categorias;
    }

    public function obtenerSubcategorias($parentId)
    {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE parent_id = ? ORDER BY nombre");
        $stmt->execute([$parentId]);
        $categorias = [];
        
        while ($data = $stmt->fetch()) {
            $categorias[] = $this->mapearCategoria($data);
        }
        
        return $categorias;
    }

    public function obtenerCategoriasPrincipales()
    {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE parent_id IS NULL ORDER BY nombre");
        $stmt->execute();
        $categorias = [];
        
        while ($data = $stmt->fetch()) {
            $categorias[] = $this->mapearCategoria($data);
        }
        
        return $categorias;
    }

    private function mapearCategoria($data)
    {
        return new Categoria(
            $data['id_categoria'],
            $data['nombre'],
            $data['descripcion'],
            $data['parent_id'],
            (bool)$data['activo']
        );
    }
}