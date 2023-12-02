<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::all();

        return response() -> json($users);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
        

        if(!$user) {
            return response() -> json([
                'message' => $user
            ], 404);
        }

        return response() -> json($user);
    }
    
    public function register(Request $request) {
        try {
            $validateData = $request -> validate([
               'name' => 'required|string',
               'lastname' => 'required|string',
               'email' => 'required|email|unique:users,email',
               'password' => 'required|string|min:6',
               'role_id' => 'required|exists:roles,id',
           ]);

           $user = new User([
               'name' => $validateData['name'],
               'lastname' => $validateData['lastname'],
               'email' => $validateData['email'],
               'password' => Hash::make($validateData['password']),
               'role_id' => $validateData['role_id']
           ]);

           $user -> save();

           return response() -> json([
            'message' => 'Usuario creado satisfactoriamente',
            'result' => $user
           ]);
        } catch(ValidationException $e) {
            $errors = $e -> validator -> errors() -> getMessages();

            return response() -> json([
                'message' => 'Error de validacion',
                'errors' => $errors
            ]);
        }
    }
}
