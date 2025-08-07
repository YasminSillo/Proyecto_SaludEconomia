<?php

class Email
{
    private $valor;

    public function __construct($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email inválido: " . $email);
        }
        $this->valor = $email;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function equals(Email $otroEmail)
    {
        return $this->valor === $otroEmail->valor;
    }

    public function __toString()
    {
        return $this->valor;
    }
}