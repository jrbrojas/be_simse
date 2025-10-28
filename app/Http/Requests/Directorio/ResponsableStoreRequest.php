<?php

namespace App\Http\Requests\Directorio;

use Illuminate\Foundation\Http\FormRequest;

class ResponsableStoreRequest extends FormRequest
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
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|min:8',
            'email' => 'required|email',
            'telefono' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'fecha_registro' => 'required|date',
            'id_entidad' => 'required|exists:Entidades,id',
            'id_cargo' => 'required|exists:cargos,id',
            'id_categoria' => 'required|exists:categorias,id',
            'id_rol' => 'required|exists:roles_responsables,id',
            'id_departamento' => 'required|exists:departamentos,id',
            'id_provincia' => 'required|exists:provincias,id',
            'id_entidad' => 'required',
        ];
    }
}
