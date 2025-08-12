<?php

class ObtenerInventarioUseCase
{
    private $productoRepository;

    public function __construct(ProductoRepositoryInterface $productoRepository)
    {
        $this->productoRepository = $productoRepository;
    }

    public function ejecutar($filtros = [])
    {
        $productos = $this->productoRepository->obtenerTodos();
        $inventario = [];
        
        foreach ($productos as $producto) {
            // Calcular stock actual basado en movimientos
            $stockActual = $this->calcularStockActual($producto->getId());
            
            $item = (object) [
                'id' => $producto->getId(),
                'codigo_sku' => $producto->getCodigoSku(),
                'nombre' => $producto->getNombre(),
                'categoria_nombre' => $this->obtenerNombreCategoria($producto->getCategoriaId()),
                'stock_actual' => $stockActual,
                'estado_stock' => $this->determinarEstadoStock($stockActual)
            ];
            
            // Aplicar filtros
            if (!empty($filtros['stock']) && $filtros['stock'] !== $item->estado_stock) {
                continue;
            }
            
            $inventario[] = $item;
        }
        
        return $inventario;
    }
    
    private function calcularStockActual($productoId)
    {
        // Por ahora retornamos un valor simulado
        // En una implementación completa, esto consultaría la tabla mov_inventario
        $valores = [0, 5, 25, 50, 100, 150, 200];
        return $valores[array_rand($valores)];
    }
    
    private function obtenerNombreCategoria($categoriaId)
    {
        // Por simplicidad, retornamos categorías genéricas
        $categorias = [
            1 => 'Medicamentos',
            2 => 'Equipos Médicos',
            3 => 'Suministros'
        ];
        
        return $categorias[$categoriaId] ?? 'Sin categoría';
    }
    
    private function determinarEstadoStock($stock)
    {
        if ($stock === 0) {
            return 'agotado';
        } elseif ($stock <= 10) {
            return 'bajo';
        } else {
            return 'normal';
        }
    }
    
    public function obtenerResumenStock()
    {
        $inventario = $this->ejecutar();
        
        $resumen = [
            'total_productos' => count($inventario),
            'stock_bajo' => 0,
            'agotados' => 0,
            'normales' => 0
        ];
        
        foreach ($inventario as $item) {
            switch ($item->estado_stock) {
                case 'agotado':
                    $resumen['agotados']++;
                    break;
                case 'bajo':
                    $resumen['stock_bajo']++;
                    break;
                case 'normal':
                    $resumen['normales']++;
                    break;
            }
        }
        
        return $resumen;
    }
}