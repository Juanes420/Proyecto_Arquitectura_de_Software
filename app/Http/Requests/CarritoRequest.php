<?php

namespace App\Http\Requests;

use App\Services\CarritoService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarritoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipo' => ['required', Rule::in(array_keys(CarritoService::TIPOS))],
            'id' => ['required', 'integer', 'min:1'],
            'cantidad' => ['nullable', 'integer', 'min:0', 'max:' . CarritoService::MAXIMO_POR_PRODUCTO],
        ];
    }

    public function tipo(): string
    {
        return $this->validated('tipo');
    }

    public function producto(): int
    {
        return (int) $this->validated('id');
    }

    public function cantidad(int $porDefecto = 1): int
    {
        return (int) ($this->validated('cantidad') ?? $porDefecto);
    }
}
