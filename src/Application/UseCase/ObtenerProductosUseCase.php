<?php

class ObtenerProductosUseCase
{
    private $productoRepository;
    private $categoriaRepository;

    public function __construct(ProductoRepositoryInterface $productoRepository, CategoriaRepositoryInterface $categoriaRepository)
    {
        $this->productoRepository = $productoRepository;
        $this->categoriaRepository = $categoriaRepository;
    }

    public function ejecutar($filtros = [])
    {
        $categoria = $filtros['categoria'] ?? null;
        $busqueda = $filtros['busqueda'] ?? null;

        if ($busqueda) {
            return $this->productoRepository->buscarPorNombre($busqueda);
        }

        if ($categoria) {
            return $this->productoRepository->obtenerPorCategoria($categoria);
        }

        return $this->productoRepository->obtenerTodos();
    }

    public function obtenerCategorias()
    {
        return $this->categoriaRepository->obtenerActivas();
    }
}