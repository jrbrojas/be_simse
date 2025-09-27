<?php

namespace App\Http\Requests\Supervision;

use Illuminate\Foundation\Http\FormRequest;

class RespuestaStore extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para la request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Cabecera de la entidad registrada
            'entidad_id'              => 'required|integer|exists:entidades,id',
            'categoria_responsable_id'=> 'required|integer|exists:categorias_responsables,id',
            'ubigeo'                  => 'required|string',
            'provincia_idprov'        => 'required|string',
            'departamento_iddpto'     => 'required|string',
            'anio'                    => 'required|integer',

            // Estructura de supervisión
            'secciones'               => 'required|array',
            'secciones.*.nombre'      => 'required|string',
            'secciones.*.promedio'    => 'nullable|numeric',

            'secciones.*.items'                     => 'required|array',
            'secciones.*.items.*.nombre'            => 'required|string',
            'secciones.*.items.*.porcentaje'        => 'nullable|numeric',
            'secciones.*.items.*.respuesta'         => 'required|in:si,no',
            'secciones.*.items.*.observacion'       => 'nullable|string',

            // Validación de archivos adjuntos
            'secciones.*.items.*.files'             => 'nullable|array',
            'secciones.*.items.*.files.*.file'      => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
            'secciones.*.items.*.files.*.descripcion'=> 'nullable|string',
            'secciones.*.items.*.files.*.aprobado'  => 'nullable|in:si,no',
        ];
    }
}

