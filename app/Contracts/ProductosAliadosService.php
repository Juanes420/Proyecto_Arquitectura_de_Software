<?php

namespace App\Contracts;

interface ProductosAliadosService
{
    public function obtener(): array;

    public function origen(): string;
}
