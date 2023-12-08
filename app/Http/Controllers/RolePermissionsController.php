<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Http\Controllers\Controller;
use App\Models\Permissions;
use App\Models\Role;
use App\Models\RolePermissions;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RolePermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validateDate = $request -> validate([
                'permission_id' => 'required|integer',
                'role_id' => 'required|integer',
            ]);
    
            $permission = Permissions::find($validateDate['permission_id']);
            $role = Role::find($validateDate['role_id']);

            if(!$permission)
                return response() -> json([
                    'message' => "Permiso no encontrado"
                ], 404);

            if(!$role)
                return response() -> json([
                    'message' => 'Rol no encontrado'
                ], 404);

            $new_permission_role = new RolePermissions([
                'permission_id' => $permission,
                'role_id' => $role
            ]);

            $new_permission_role -> save();

            return response() -> json([
                'message' => 'Permiso asignado a rol con exito',
                'result' => $new_permission_role
            ]);
        } catch(ValidationException $e) {
            $errors = $e -> validator -> errors() -> getMessages();

            return response() -> json([
                'message' => "Error de validacion",
                'Errors' => $errors
            ]);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(RolePermissions $rolePermissions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RolePermissions $rolePermissions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRolePermissionsRequest $request, RolePermissions $rolePermissions)
    {
        //
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RolePermissions $rolePermissions)
    {
        //
    }
}
