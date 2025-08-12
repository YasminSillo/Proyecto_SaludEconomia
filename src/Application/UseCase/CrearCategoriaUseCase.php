<?php

class CrearCategoriaUseCase
{
    private $categoriaRepository;

    public function __construct(CategoriaRepositoryInterface $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function ejecutar($datos)
    {
        // Validar que el nombre no esté vacío
        if (empty($datos['nombre'])) {
            throw new Exception("El nombre de la categoría es requerido");
        }

        // Verificar si es una subcategoría y que la categoría padre exista
        if (!empty($datos['parent_id'])) {
            $categoriaPadre = $this->categoriaRepository->obtenerPorId($datos['parent_id']);
            if (!$categoriaPadre) {
                throw new Exception("La categoría padre especificada no existe");
            }
        }

        $categoria = new Categoria(
            null,
            $datos['nombre'],
            $datos['descripcion'] ?? null,
            !empty($datos['parent_id']) ? (int)$datos['parent_id'] : null,
            true
        );
        
        return $this->categoriaRepository->guardar($categoria);
    }
}