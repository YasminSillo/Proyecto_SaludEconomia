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

    public function ejecutar($datos, $archivosImagenes = null, $imagenPrincipalIndex = 0)
    {
        // Verificar que el SKU no exista
        $productoExistente = $this->productoRepository->obtenerPorSku($datos['codigo_sku']);
        if ($productoExistente) {
            throw new Exception("Ya existe un producto con el SKU: " . $datos['codigo_sku']);
        }

        // Compatibilidad con versión anterior (imagen única)
        if ($archivosImagenes && !is_array($archivosImagenes['name'])) {
            $nombreImagen = null;
            if ($archivosImagenes['error'] === UPLOAD_ERR_OK) {
                $nombreImagen = $this->imagenRepository->subirImagen($archivosImagenes, 'productos');
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

        // Manejo de múltiples imágenes
        $imagenesSubidas = [];
        $imagenPrincipal = null;
        
        if ($archivosImagenes && is_array($archivosImagenes['name'])) {
            for ($i = 0; $i < count($archivosImagenes['name']); $i++) {
                if ($archivosImagenes['error'][$i] === UPLOAD_ERR_OK) {
                    $archivo = [
                        'name' => $archivosImagenes['name'][$i],
                        'type' => $archivosImagenes['type'][$i],
                        'tmp_name' => $archivosImagenes['tmp_name'][$i],
                        'error' => $archivosImagenes['error'][$i],
                        'size' => $archivosImagenes['size'][$i]
                    ];
                    
                    $nombreImagen = $this->imagenRepository->subirImagen($archivo, 'productos');
                    $imagenesSubidas[] = [
                        'nombre_archivo' => $nombreImagen,
                        'orden' => $i,
                        'es_principal' => ($i === $imagenPrincipalIndex) ? 1 : 0
                    ];
                    
                    // Guardar la primera imagen para compatibilidad
                    if ($i === $imagenPrincipalIndex) {
                        $imagenPrincipal = $nombreImagen;
                    }
                }
            }
        }

        // Crear producto con imagen principal
        $producto = new Producto(
            null,
            $datos['codigo_sku'],
            $datos['nombre'],
            $datos['categoria_id'],
            $datos['proveedor_id'],
            $datos['descripcion'] ?? null,
            $datos['precio'] ?? null,
            $imagenPrincipal
        );
        
        $resultado = $this->productoRepository->guardar($producto);
        
        // Guardar imágenes adicionales en la nueva tabla (si existe)
        if (!empty($imagenesSubidas) && $resultado) {
            $this->guardarImagenesProducto($producto->getId(), $imagenesSubidas);
        }
        
        return $resultado;
    }

    private function guardarImagenesProducto($productoId, $imagenes)
    {
        // TODO: Implementar cuando se ejecute la migración de la tabla producto_imagenes
        // Por ahora solo loggeamos
        error_log("Imágenes para producto $productoId: " . json_encode($imagenes));
    }
}