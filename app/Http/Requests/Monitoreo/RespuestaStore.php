<?php

namespace App\Http\Requests\Monitoreo;

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
            // formulario de la izquierda
            'entidad_id' => 'required',
            'categoria_responsable_id' => 'required',
            'ubigeo' => 'required',
            'provincia_idprov' => 'required',
            'departamento_iddpto' => 'required',
            'anio' => 'required',
            'que_implementa' => 'required',
            'sustento' => 'required',
            'n_personas_en_la_instancia' => 'required',
            'n_personas_grd' => 'required',
            'archivo' => 'nullable|file',

            // formulario de la derecha
            'respuestas' => 'required',
            'respuestas.*.codigo' => 'required',
            'respuestas.*.op' => 'required',
            'respuestas.*.titulo' => 'required',
            'respuestas.*.pregunta' => 'required',
            'respuestas.*.type' => 'required',
            'respuestas.*.respuesta' => 'required|in:si,no',
            'respuestas.*.cantidad_evidencias' => 'required',
            'respuestas.*.porcentaje' => 'required',
        ];
    }
}
