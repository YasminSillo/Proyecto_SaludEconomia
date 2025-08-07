<?php

class Pedido
{
    private $id;
    private $numeroPedido;
    private $clienteId;
    private $usuarioId;
    private $estado;
    private $fecha;
    private $detalles;

    public function __construct($id, $numeroPedido, $clienteId, $usuarioId, $estado = 'pendiente', $fecha = null)
    {
        $this->id = $id;
        $this->numeroPedido = $numeroPedido;
        $this->clienteId = $clienteId;
        $this->usuarioId = $usuarioId;
        $this->estado = $estado;
        $this->fecha = $fecha;
        $this->detalles = [];
    }

    public function getId() { return $this->id; }
    public function getNumeroPedido() { return $this->numeroPedido; }
    public function getClienteId() { return $this->clienteId; }
    public function getUsuarioId() { return $this->usuarioId; }
    public function getEstado() { return $this->estado; }
    public function getFecha() { return $this->fecha; }
    public function getDetalles() { return $this->detalles; }

    public function agregarDetalle($detalle)
    {
        $this->detalles[] = $detalle;
    }

    public function cambiarEstado($nuevoEstado)
    {
        $estadosValidos = ['pendiente', 'procesando', 'completado', 'cancelado'];
        if (in_array($nuevoEstado, $estadosValidos)) {
            $this->estado = $nuevoEstado;
        }
    }

    public function calcularTotal()
    {
        $total = 0;
        foreach ($this->detalles as $detalle) {
            $total += $detalle->getSubtotal();
        }
        return $total;
    }
}