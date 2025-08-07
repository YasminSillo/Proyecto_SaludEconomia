<?php

class Proveedor
{
    private $id;
    private $nombreEmpresa;
    private $contactoNombre;
    private $email;
    private $ruc;

    public function __construct($id, $nombreEmpresa, $contactoNombre, $email = null, $ruc = null)
    {
        $this->id = $id;
        $this->nombreEmpresa = $nombreEmpresa;
        $this->contactoNombre = $contactoNombre;
        $this->email = $email;
        $this->ruc = $ruc;
    }

    public function getId() { return $this->id; }
    public function getNombreEmpresa() { return $this->nombreEmpresa; }
    public function getContactoNombre() { return $this->contactoNombre; }
    public function getEmail() { return $this->email; }
    public function getRuc() { return $this->ruc; }

    public function actualizarContacto($nuevoContacto)
    {
        $this->contactoNombre = $nuevoContacto;
    }
}