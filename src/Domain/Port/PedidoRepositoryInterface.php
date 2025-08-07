<?php

interface PedidoRepositoryInterface
{
    public function obtenerPorId($id);
    public function obtenerPorNumero($numero);
    public function guardar(Pedido $pedido);
    public function actualizar(Pedido $pedido);
    public function eliminar($id);
    public function obtenerTodos();
    public function obtenerPorCliente($clienteId);
    public function obtenerPorEstado($estado);
    public function obtenerPorFecha($fecha);
}