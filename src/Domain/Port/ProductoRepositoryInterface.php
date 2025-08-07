<?php

interface ProductoRepositoryInterface
{
    public function obtenerPorId($id);
    public function obtenerPorSku($sku);
    public function guardar(Producto $producto);
    public function actualizar(Producto $producto);
    public function eliminar($id);
    public function obtenerTodos();
    public function obtenerPorCategoria($categoriaId);
    public function buscarPorNombre($nombre);
}