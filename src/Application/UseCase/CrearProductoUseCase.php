<?php

class CrearProductoUseCase
{
    private $productoRepository;
    private $imagenRepository;

    public function __construct(ProductoRepositoryInterface $productoRepository, ImagenRepositoryInterface $imagenRepository)
    {
        $this->productoRepository = $productoRepository;
        $this->imagenRepository = $imagenRepository;
    }

    public function ejecutar($datos, $archivoImagen = null)
    {
        // Verificar que el SKU no exista
        $productoExistente = $this->productoRepository->obtenerPorSku($datos['codigo_sku']);
        if ($productoExistente) {
            throw new Exception("Ya existe un producto con el SKU: " . $datos['codigo_sku']);
        }

        // Subir imagen si se proporcionó
        $nombreImagen = null;
        if ($archivoImagen && $archivoImagen['error'] === UPLOAD_ERR_OK) {
            $nombreImagen = $this->imagenRepository->subirImagen($archivoImagen, 'productos');
        }

        $producto = new Producto(
            null,
            $datos['codigo_sku'],
            $datos['nombre'],
            $datos['categoria_id'],
            $datos['proveedor_id'],
            $datos['descripcion'] ?? null,
            $datos['precio'] ?? null,
            $nombreImagen
        );
        
        return $this->productoRepository->guardar($producto);
    }
}