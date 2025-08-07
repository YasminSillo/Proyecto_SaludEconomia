<?php

class Producto
{
    private $id;
    private $codigoSku;
    private $nombre;
    private $categoriaId;
    private $proveedorId;

    public function __construct($id, $codigoSku, $nombre, $categoriaId, $proveedorId)
    {
        $this->id = $id;
        $this->codigoSku = $codigoSku;
        $this->nombre = $nombre;
        $this->categoriaId = $categoriaId;
        $this->proveedorId = $proveedorId;
    }

    public function getId() { return $this->id; }
    public function getCodigoSku() { return $this->codigoSku; }
    public function getNombre() { return $this->nombre; }
    public function getCategoriaId() { return $this->categoriaId; }
    public function getProveedorId() { return $this->proveedorId; }

    public function actualizarNombre($nuevoNombre)
    {
        $this->nombre = $nuevoNombre;
    }
}