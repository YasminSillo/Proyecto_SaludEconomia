<?php

class MovimientoInventario
{
    private $id;
    private $productoId;
    private $tipoMovimiento;
    private $cantidad;
    private $usuarioId;
    private $fecha;

    public function __construct($id, $productoId, $tipoMovimiento, $cantidad, $usuarioId, $fecha = null)
    {
        $this->id = $id;
        $this->productoId = $productoId;
        $this->tipoMovimiento = $tipoMovimiento;
        $this->cantidad = $cantidad;
        $this->usuarioId = $usuarioId;
        $this->fecha = $fecha;
    }

    public function getId() { return $this->id; }
    public function getProductoId() { return $this->productoId; }
    public function getTipoMovimiento() { return $this->tipoMovimiento; }
    public function getCantidad() { return $this->cantidad; }
    public function getUsuarioId() { return $this->usuarioId; }
    public function getFecha() { return $this->fecha; }

    public function esEntrada()
    {
        return $this->tipoMovimiento === 'entrada';
    }

    public function esSalida()
    {
        return $this->tipoMovimiento === 'salida';
    }

    public function esAjuste()
    {
        return $this->tipoMovimiento === 'ajuste';
    }
}