<?php

interface ProveedorRepositoryInterface
{
    public function obtenerPorId($id);
    public function obtenerPorRuc($ruc);
    public function guardar(Proveedor $proveedor);
    public function actualizar(Proveedor $proveedor);
    public function eliminar($id);
    public function obtenerTodos();
    public function buscarPorNombre($nombre);
}