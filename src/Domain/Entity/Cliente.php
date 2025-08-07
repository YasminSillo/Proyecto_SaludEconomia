<?php

class Cliente
{
    private $id;
    private $tipoCliente;
    private $nombre;
    private $email;
    private $rucDni;

    public function __construct($id, $tipoCliente, $nombre, $email = null, $rucDni = null)
    {
        $this->id = $id;
        $this->tipoCliente = $tipoCliente;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->rucDni = $rucDni;
    }

    public function getId() { return $this->id; }
    public function getTipoCliente() { return $this->tipoCliente; }
    public function getNombre() { return $this->nombre; }
    public function getEmail() { return $this->email; }
    public function getRucDni() { return $this->rucDni; }

    public function esPersonaNatural()
    {
        return $this->tipoCliente === 'natural';
    }

    public function esPersonaJuridica()
    {
        return $this->tipoCliente === 'juridico';
    }
}