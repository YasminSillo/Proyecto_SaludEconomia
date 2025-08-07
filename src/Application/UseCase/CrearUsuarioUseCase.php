<?php

class CrearUsuarioUseCase
{
    private $usuarioRepository;

    public function __construct(UsuarioRepositoryInterface $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function ejecutar($nombre, $email, $password, $rol = 'vendedor')
    {
        $usuarioExistente = $this->usuarioRepository->obtenerPorEmail($email);
        if ($usuarioExistente) {
            throw new Exception("Ya existe un usuario con ese email");
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $usuario = new Usuario(null, $nombre, $email, $passwordHash, $rol);
        
        return $this->usuarioRepository->guardar($usuario);
    }
}