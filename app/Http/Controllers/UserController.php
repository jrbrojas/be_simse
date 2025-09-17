<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(UserStoreRequest $request)
    {
        $data = $request->all();
        unset($data['password_confirmation']);
        $entidad = new User();
        $entidad->fill($data);
        $entidad->save();
        return $entidad;
    }

    public function show(User $usuario)
    {
        return $usuario;
    }

    public function update(UserStoreRequest $request, User $usuario)
    {
        $data = $request->all();
        unset($data['password_confirmation']);
        $usuario->update($data);
        return $usuario;
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return $usuario;
    }
}
