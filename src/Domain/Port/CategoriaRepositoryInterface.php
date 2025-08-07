<?php

interface CategoriaRepositoryInterface
{
    public function obtenerPorId($id);
    public function guardar(Categoria $categoria);
    public function actualizar(Categoria $categoria);
    public function eliminar($id);
    public function obtenerTodas();
    public function obtenerActivas();
    public function obtenerSubcategorias($parentId);
    public function obtenerCategoriasPrincipales();
}