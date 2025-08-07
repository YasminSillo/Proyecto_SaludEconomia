<?php

class Producto
{
    private $id;
    private $codigoSku;
    private $nombre;
    private $descripcion;
    private $precio;
    private $categoriaId;
    private $proveedorId;
    private $imagen;

    public function __construct($id, $codigoSku, $nombre, $categoriaId, $proveedorId, $descripcion = null, $precio = null, $imagen = null)
    {
        $this->id = $id;
        $this->codigoSku = $codigoSku;
        $this->nombre = $nombre;
        $this->categoriaId = $categoriaId;
        $this->proveedorId = $proveedorId;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->imagen = $imagen;
    }

    public function getId() { return $this->id; }
    public function getCodigoSku() { return $this->codigoSku; }
    public function getNombre() { return $this->nombre; }
    public function getDescripcion() { return $this->descripcion; }
    public function getPrecio() { return $this->precio; }
    public function getCategoriaId() { return $this->categoriaId; }
    public function getProveedorId() { return $this->proveedorId; }
    public function getImagen() { return $this->imagen; }

    public function actualizarNombre($nuevoNombre)
    {
        $this->nombre = $nuevoNombre;
    }

    public function actualizarImagen($nuevaImagen)
    {
        $this->imagen = $nuevaImagen;
    }

    public function tieneImagen()
    {
        return !empty($this->imagen);
    }
}