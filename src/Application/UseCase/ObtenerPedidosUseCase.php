<?php

class ObtenerPedidosUseCase
{
    private $pedidoRepository;

    public function __construct(PedidoRepositoryInterface $pedidoRepository)
    {
        $this->pedidoRepository = $pedidoRepository;
    }

    public function ejecutar($filtros = [])
    {
        if (!empty($filtros['estado'])) {
            return $this->pedidoRepository->obtenerPorEstado($filtros['estado']);
        }
        
        if (!empty($filtros['fecha'])) {
            return $this->pedidoRepository->obtenerPorFecha($filtros['fecha']);
        }
        
        if (!empty($filtros['cliente_id'])) {
            return $this->pedidoRepository->obtenerPorCliente($filtros['cliente_id']);
        }
        
        return $this->pedidoRepository->obtenerConTotal();
    }
}