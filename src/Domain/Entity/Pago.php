<?php

class Pago
{
    private $id;
    private $pedidoId;
    private $clienteId;
    private $monto;
    private $metodoPago;
    private $fecha;

    public function __construct($id, $pedidoId, $clienteId, $monto, $metodoPago = 'efectivo', $fecha = null)
    {
        $this->id = $id;
        $this->pedidoId = $pedidoId;
        $this->clienteId = $clienteId;
        $this->monto = $monto;
        $this->metodoPago = $metodoPago;
        $this->fecha = $fecha;
    }

    public function getId() { return $this->id; }
    public function getPedidoId() { return $this->pedidoId; }
    public function getClienteId() { return $this->clienteId; }
    public function getMonto() { return $this->monto; }
    public function getMetodoPago() { return $this->metodoPago; }
    public function getFecha() { return $this->fecha; }

    public function esEfectivo()
    {
        return $this->metodoPago === 'efectivo';
    }

    public function esTarjeta()
    {
        return $this->metodoPago === 'tarjeta';
    }
}