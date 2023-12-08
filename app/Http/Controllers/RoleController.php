<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\SessionPermisson;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();

        return response() -> json($roles);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $validateData = $request -> validate([
                'name' => 'required|string|unique:roles,name',
                'description' => 'required|string',
                'audit' => 'required|boolean'
            ]);

            $new_role = new Role([
                'name' => $validateData['name'],
                'description' => $validateData['description'],
                'audit' => $validateData['audit'],
            ]);

            $result = $new_role -> save();

            return response() -> json([
                'message' => 'Rol creado satisfactoriamente.',
                'rol_info' => $new_role
            ]);
        } catch(ValidationException $e) {
            $errors = $e -> validator -> errors() -> getMessages();

            return response() -> json([
                'message' => 'Error de validacion',
                'errors' => $errors
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        // var_dump($role);
        try {
            if(!$role) {
                return response() -> json([
                    'message' => 'Rol no encontrado. Pruebe con otro'
                ], 404);
            }
    
            $validateData = $request -> validate([
                'name' => 'required|string',
                'description' => 'required|string'
            ]);
    
            $role -> update($validateData);
            return response() -> json([
                'message' => 'Rol actualizado con exito.',
                'result' => $role
            ],200);
        } catch(ValidationException $e) {
            $errors = $e -> validator -> errors() -> getMessages();

            return response() -> json([
                'message' =>  'Error en la actualizacion',
                'errors' => $errors
            ],401);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $role = Role::find($id);

        if(!$role) {
            return response() -> json([
                'message' => 'Rol no encontrado. Pruebe con otro'
            ], 404);
        }

        // En este punto se revisara si el rol esta relacionado a algun usuario.
        // En caso de que si lo este, se replazara a todos los usuarios por un rol nuevo 
        // que se seleccione
        $validateData = $request -> validate([
            'role_id' => 'integer'
        ]);

        $new_role = Role::find($validateData['role_id']);
        if(!$new_role) {
            return response() -> json([
                'message' => 'Rol no encontrado'
            ], 404);
        }

        User::where('role_id', $role -> id) -> update(['role_id' => $new_role -> id]);
        SessionPermisson::where('role_id', $role -> id) -> delete();

        $role -> delete();
        return response() -> json([
            'message' => 'Rol eliminado con exito.'
        ], 200);

    }
}
