<?php

class AutenticarUsuarioUseCase
{
    private $usuarioRepository;

    public function __construct(UsuarioRepositoryInterface $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function ejecutar($email, $password)
    {
        $usuario = $this->usuarioRepository->obtenerPorEmail($email);
        
        if (!$usuario) {
            throw new Exception("Usuario no encontrado");
        }

        if (!$usuario->verificarPassword($password)) {
            throw new Exception("Contraseña incorrecta");
        }

        return $usuario;
    }
}