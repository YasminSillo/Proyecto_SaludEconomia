<?php

interface ClienteRepositoryInterface
{
    public function obtenerPorId($id);
    public function obtenerPorRucDni($rucDni);
    public function guardar(Cliente $cliente);
    public function actualizar(Cliente $cliente);
    public function eliminar($id);
    public function obtenerTodos();
    public function buscarPorNombre($nombre);
}