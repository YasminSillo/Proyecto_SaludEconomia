<?php

class CrearClienteUseCase
{
    private $clienteRepository;

    public function __construct(ClienteRepositoryInterface $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function ejecutar($tipoCliente, $nombre, $email = null, $rucDni = null)
    {
        if ($rucDni) {
            $clienteExistente = $this->clienteRepository->obtenerPorRucDni($rucDni);
            if ($clienteExistente) {
                throw new Exception("Ya existe un cliente con ese RUC/DNI");
            }
        }

        $cliente = new Cliente(null, $tipoCliente, $nombre, $email, $rucDni);
        
        return $this->clienteRepository->guardar($cliente);
    }
}