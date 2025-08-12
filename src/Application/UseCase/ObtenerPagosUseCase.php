<?php

class ObtenerPagosUseCase
{
    private $pagoRepository;

    public function __construct($pagoRepository)
    {
        $this->pagoRepository = $pagoRepository;
    }

    public function ejecutar($filtros = [])
    {
        if (!empty($filtros['metodo'])) {
            return $this->pagoRepository->obtenerPorMetodo($filtros['metodo']);
        }
        
        if (!empty($filtros['fecha'])) {
            return $this->pagoRepository->obtenerPorFecha($filtros['fecha']);
        }
        
        return $this->pagoRepository->obtenerTodos();
    }

    public function obtenerResumenDiario($fecha = null)
    {
        return $this->pagoRepository->obtenerResumenDiario($fecha);
    }
}