<?php

class ObtenerComprasUseCase
{
    private $compraRepository;

    public function __construct($compraRepository)
    {
        $this->compraRepository = $compraRepository;
    }

    public function ejecutar($filtros = [])
    {
        if (!empty($filtros['estado'])) {
            return $this->compraRepository->obtenerPorEstado($filtros['estado']);
        }
        
        if (!empty($filtros['proveedor_id'])) {
            return $this->compraRepository->obtenerPorProveedor($filtros['proveedor_id']);
        }
        
        return $this->compraRepository->obtenerTodas();
    }
}