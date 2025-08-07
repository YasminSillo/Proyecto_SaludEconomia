<?php

class Usuario
{
    private $id;
    private $nombre;
    private $email;
    private $passwordHash;
    private $rol;
    private $createdAt;

    public function __construct($id, $nombre, $email, $passwordHash, $rol, $createdAt = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->rol = $rol;
        $this->createdAt = $createdAt;
    }

    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getEmail() { return $this->email; }
    public function getPasswordHash() { return $this->passwordHash; }
    public function getRol() { return $this->rol; }
    public function getCreatedAt() { return $this->createdAt; }

    public function cambiarPassword($nuevoPasswordHash)
    {
        $this->passwordHash = $nuevoPasswordHash;
    }

    public function verificarPassword($password)
    {
        return password_verify($password, $this->passwordHash);
    }
}