<?php

class PedidoDetalle
{
    private $id;
    private $pedidoId;
    private $productoId;
    private $cantidad;
    private $precioUnitario;

    public function __construct($id, $pedidoId, $productoId, $cantidad, $precioUnitario)
    {
        $this->id = $id;
        $this->pedidoId = $pedidoId;
        $this->productoId = $productoId;
        $this->cantidad = $cantidad;
        $this->precioUnitario = $precioUnitario;
    }

    public function getId() { return $this->id; }
    public function getPedidoId() { return $this->pedidoId; }
    public function getProductoId() { return $this->productoId; }
    public function getCantidad() { return $this->cantidad; }
    public function getPrecioUnitario() { return $this->precioUnitario; }

    public function getSubtotal()
    {
        return $this->cantidad * $this->precioUnitario;
    }
}