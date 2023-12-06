<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    static $PATH_NAME = 'users';

    public function index()
    {
        $users = User::all();

        foreach ($users as $user) {
            $role = Role::find($user -> role_id);
            $user -> role = $role;
        }
        return response()->json($users);
    }

    public function login(Request $request) {
        try {
            $validateData = $request->validate([
                'email' => 'required|string',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $validateData['email']) -> first();

            if(!$user) {
                return response() -> json([
                    'message' => 'Usuario con ese email no existe'
                ], 401);
            } 
            $passwordValid = Hash::check($validateData['password'], $user->password);
            
            if($passwordValid) {
                $response = [
                    'id_user' => $user -> id,
                    'api_token' => Str::uuid()
                ];
                Session::create($response);

                $user -> api_token = $response['api_token'];
                $role = Role::find($user -> role_id);
                $user -> role = $role;  

                return response() -> json([
                    'message' => 'Sesión Iniciada exitosamente',
                    'result' => $user
                ]);
            }

            return response() -> json([
                'message' => 'Contraseña incorrecta',
            ], 401);

        } catch(ValidationException $e) {
            $errors = $e -> validator -> errors() -> getMessages();

            return response() -> json([
                'message' => 'Error de validacion',
                'errors' => $errors
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);


        if (!$user) {
            return response()->json([
                'message' => $user
            ], 404);
        }

        return response()->json($user);
    }

    public function register(Request $request)
    {
        try {
            if(User::where('email', $request->input('email') ) -> first()) {
                return response([
                    'message' => 'Este correo ya fue registrado',
                ], 409);
            }
            $validateData = $request->validate([
                'name' => 'required|string',
                'lastname' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'image_name' => 'image|mimes:jpeg,png,jpg|max:2048',
                'role_id' => 'required|exists:roles,id',
            ]);


            $imageName = null;
            $url = null;
            if ($request->hasFile('image_name')) {
                $image = $request -> file('image_name');
                $imageName = time() . '_' .  str_replace(" ", "_", $image->getClientOriginalName());
                Storage::disk(self::$PATH_NAME)->put($imageName, file_get_contents($image));
            }

            $user = new User([
                'name' => $validateData['name'],
                'lastname' => $validateData['lastname'],
                'email' => $validateData['email'],
                'password' => Hash::make($validateData['password']),
                'role_id' => $validateData['role_id'],
                'image_name' => $imageName
            ]);
            
            $user->save();

            $role = Role::find($user -> role_id);
            // $role -> unsetAttribute('role_id');
            $user -> role = $role;

            if(!$url) $user -> image_name = Storage::disk(self::$PATH_NAME)->url($imageName);
            $response = [
                'message' => 'Usuario creado satisfactoriamente',
                'result' => $user
            ];

            return response()->json($response);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->getMessages();

            return response()->json([
                'message' => 'Error de validacion',
                'errors' => $errors
            ], 409);
        }
    }

    public function destroy($id) {
        $user = User::find($id);

        if(!$user) {
            return response() -> json([
                'message' => 'No se encontro al usuario'
            ], 404);
        }

        $user -> delete();

        return response() -> json([
            'message' => 'Usuario eliminado exitosamente'
        ]);
    }

    public function edit(Request $request, $id) {
        $user = User::find($id);

        if(!$user) {
            return response() -> json([
                'message' => 'No se encontro al usuario'
            ], 404);
        }

        try {
            $validateData = $request->validate([
                'name' => 'string',
                'lastname' => 'string',
                'email' => 'email',
                'password' => 'string|min:6',
                'image_name' => 'image|mimes:jpeg,png,jpg|max:2048',
                'role_id' => 'exists:roles,id',
            ]);

            // $user = new User([
            //     'name' => $validateData['name'],
            //     'lastname' => $validateData['lastname'],
            //     'email' => $validateData['email'],
            //     'password' => Hash::make($validateData['password']),
            //     'role_id' => $validateData['role_id']
            // ]);

            $imageName = $user -> image_name;
            $url = null;
            
            if ($request->hasFile('image_name')) {
                if(Storage::disk(self::$PATH_NAME)->exists($user->image_name)) {
                    Storage::disk(self::$PATH_NAME)->delete($user->image_name);
                }
                
                $image = $request -> file('image_name');
                $imageName = time() . '_' .  str_replace(" ", "_", $image->getClientOriginalName());
                Storage::disk(self::$PATH_NAME)->put($imageName, file_get_contents($image));
            }
            
            $user -> image_name = $imageName;
            $user -> update($request->except('image_name', 'password'));
            
            $user -> image_url = Storage::disk(self::$PATH_NAME)->url($imageName);
            if($request -> input('password')) {
                $user -> password = Hash::make($request-> input('password'));
            };
            $response = [
                'message' => 'Usuario creado satisfactoriamente',
                'result' => $user
            ];

            return response()->json($response);
        } catch(ValidationException $e) {
            $errors = $e -> validator -> errors() -> getMessages();

            return response() -> json([
                'message' => 'Error de validacion',
                'errors' => $errors
            ]);
        }
    }
}
