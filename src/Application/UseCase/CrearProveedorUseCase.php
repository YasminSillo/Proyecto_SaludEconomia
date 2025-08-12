<?php

class CrearProveedorUseCase
{
    private $proveedorRepository;

    public function __construct(ProveedorRepositoryInterface $proveedorRepository)
    {
        $this->proveedorRepository = $proveedorRepository;
    }

    public function ejecutar($datos)
    {
        // Validar que el nombre de empresa no esté vacío
        if (empty($datos['nombre_empresa'])) {
            throw new Exception("El nombre de la empresa es requerido");
        }

        // Validar que el contacto no esté vacío
        if (empty($datos['contacto_nombre'])) {
            throw new Exception("El nombre del contacto es requerido");
        }

        // Verificar que el RUC no exista si se proporciona
        if (!empty($datos['ruc'])) {
            $proveedorExistente = $this->proveedorRepository->obtenerPorRuc($datos['ruc']);
            if ($proveedorExistente) {
                throw new Exception("Ya existe un proveedor con el RUC: " . $datos['ruc']);
            }
        }

        // Validar formato de email si se proporciona
        if (!empty($datos['email']) && !filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El formato del email no es válido");
        }

        $proveedor = new Proveedor(
            null,
            $datos['nombre_empresa'],
            $datos['contacto_nombre'],
            !empty($datos['email']) ? $datos['email'] : null,
            !empty($datos['ruc']) ? $datos['ruc'] : null
        );
        
        return $this->proveedorRepository->guardar($proveedor);
    }
}