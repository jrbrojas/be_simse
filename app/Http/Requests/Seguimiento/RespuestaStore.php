<?php

namespace App\Http\Requests\Seguimiento;

use Illuminate\Foundation\Http\FormRequest;

class RespuestaStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'entidad_id' => 'required',
            'categoria_responsable_id' => 'required',
            'ubigeo' => 'required',
            'provincia_idprov' => 'required',
            'departamento_iddpto' => 'required',
            'anio' => 'required',
        ];
    }
}
