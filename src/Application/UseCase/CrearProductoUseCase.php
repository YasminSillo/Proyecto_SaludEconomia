<?php

class CrearProductoUseCase
{
    private $productoRepository;

    public function __construct(ProductoRepositoryInterface $productoRepository)
    {
        $this->productoRepository = $productoRepository;
    }

    public function ejecutar($codigoSku, $nombre, $categoriaId, $proveedorId)
    {
        // Verificar que el SKU no exista
        $productoExistente = $this->productoRepository->obtenerPorSku($codigoSku);
        if ($productoExistente) {
            throw new Exception("Ya existe un producto con el SKU: " . $codigoSku);
        }

        $producto = new Producto(null, $codigoSku, $nombre, $categoriaId, $proveedorId);
        
        return $this->productoRepository->guardar($producto);
    }
}