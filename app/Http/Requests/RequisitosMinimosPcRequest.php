<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RequisitosMinimosPcRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // La relación es 1:1: un videojuego solo puede tener una ficha (se ignora la actual al editar).
            'videojuego_id' => [
                'required',
                'exists:videojuegos,id',
                Rule::unique('requisitos_minimos_pc', 'videojuego_id')->ignore($this->route('requisito')),
            ],
            'sistema_operativo' => ['required', 'string', 'max:255'],
            'procesador' => ['required', 'string', 'max:255'],
            'memoria_ram' => ['required', 'string', 'max:255'],
            'tarjeta_grafica' => ['required', 'string', 'max:255'],
            'almacenamiento' => ['required', 'string', 'max:255'],
            'directx' => ['nullable', 'string', 'max:255'],
        ];
    }
}
