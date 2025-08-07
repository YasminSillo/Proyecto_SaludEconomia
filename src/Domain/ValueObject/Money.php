<?php

class Money
{
    private $cantidad;
    private $moneda;

    public function __construct($cantidad, $moneda = 'PEN')
    {
        if ($cantidad < 0) {
            throw new InvalidArgumentException("La cantidad no puede ser negativa");
        }
        $this->cantidad = round($cantidad, 2);
        $this->moneda = $moneda;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function getMoneda()
    {
        return $this->moneda;
    }

    public function sumar(Money $otroMoney)
    {
        if ($this->moneda !== $otroMoney->moneda) {
            throw new InvalidArgumentException("No se pueden sumar cantidades de diferentes monedas");
        }
        return new Money($this->cantidad + $otroMoney->cantidad, $this->moneda);
    }

    public function multiplicar($factor)
    {
        return new Money($this->cantidad * $factor, $this->moneda);
    }

    public function equals(Money $otroMoney)
    {
        return $this->cantidad === $otroMoney->cantidad && $this->moneda === $otroMoney->moneda;
    }

    public function __toString()
    {
        return number_format($this->cantidad, 2) . ' ' . $this->moneda;
    }
}