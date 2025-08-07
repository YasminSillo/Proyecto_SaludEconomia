<?php

interface UsuarioRepositoryInterface
{
    public function obtenerPorId($id);
    public function obtenerPorEmail($email);
    public function guardar(Usuario $usuario);
    public function actualizar(Usuario $usuario);
    public function eliminar($id);
    public function obtenerTodos();
}