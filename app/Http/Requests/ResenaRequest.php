<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResenaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'calificacion' => ['required', 'numeric', 'min:0.5', 'max:5', 'multiple_of:0.5'],
            'comentario' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
