<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Controllers\Controller;
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
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}
