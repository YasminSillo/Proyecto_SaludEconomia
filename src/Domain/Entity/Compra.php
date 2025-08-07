<?php

class Compra
{
    private $id;
    private $numeroCompra;
    private $proveedorId;
    private $usuarioId;
    private $estado;
    private $fecha;

    public function __construct($id, $numeroCompra, $proveedorId, $usuarioId, $estado = 'pendiente', $fecha = null)
    {
        $this->id = $id;
        $this->numeroCompra = $numeroCompra;
        $this->proveedorId = $proveedorId;
        $this->usuarioId = $usuarioId;
        $this->estado = $estado;
        $this->fecha = $fecha;
    }

    public function getId() { return $this->id; }
    public function getNumeroCompra() { return $this->numeroCompra; }
    public function getProveedorId() { return $this->proveedorId; }
    public function getUsuarioId() { return $this->usuarioId; }
    public function getEstado() { return $this->estado; }
    public function getFecha() { return $this->fecha; }

    public function cambiarEstado($nuevoEstado)
    {
        $estadosValidos = ['pendiente', 'recibido', 'cancelado'];
        if (in_array($nuevoEstado, $estadosValidos)) {
            $this->estado = $nuevoEstado;
        }
    }
}