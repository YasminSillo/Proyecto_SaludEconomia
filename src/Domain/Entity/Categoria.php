<?php

class Categoria
{
    private $id;
    private $nombre;
    private $descripcion;
    private $parentId;
    private $activo;

    public function __construct($id, $nombre, $descripcion = null, $parentId = null, $activo = true)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->parentId = $parentId;
        $this->activo = $activo;
    }

    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getDescripcion() { return $this->descripcion; }
    public function getParentId() { return $this->parentId; }
    public function getActivo() { return $this->activo; }

    public function esSubcategoria()
    {
        return $this->parentId !== null;
    }

    public function activar()
    {
        $this->activo = true;
    }

    public function desactivar()
    {
        $this->activo = false;
    }
}