<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoJuegoRequest extends FormRequest
{
    // El acceso ya lo restringe el middleware 'admin' de las rutas.
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:255'],
            'plataforma' => ['required', 'string', 'max:100'],
            'precio' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'descripcion' => ['nullable', 'string'],
            'imagen' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
