<?php

namespace App\Http\Controllers;

use App\Models\Initiative;
use App\Http\Controllers\Controller;
use App\Models\Departament;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class InitiativeController extends Controller
{
    static $PATH_NAME = "initiatives";
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $initiatives = Initiative::all();

        foreach ($initiatives as $initiative) {
            $user = User::find($initiative->id_user);
            $department = Departament::find($initiative->id_department);

            $initiative->user = $user;
            $initiative->department = $department;
        }

        return response()->json($initiatives);
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
            $validateData = $request->validate([
                "name" => 'required|string',
                "description" => 'required|string',
                "id_department" => 'required|string',
                "status" => ['required', 'in:en revisión,completado,descartado'],
                "image" => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $image = $request->file('image');
            $imageName = time() . '_' .  str_replace(" ", "_", $image->getClientOriginalName());
            // $image->storeAs('public/buildings', $imageName);
            Storage::disk(self::$PATH_NAME)->put($imageName, file_get_contents($image));
            $url = Storage::disk(self::$PATH_NAME)->url($imageName);

            $token = $request->attributes->get('token');
            $user = User::find(Session::where('api_token', $token)->first()->id_user);
            $department = Departament::find($validateData['id_department']);

            if (!$user) {
                return response()->json([
                    'message' => "Usuario no encontrado"
                ], 404);
            }
            

            if (!$department) {
                return response()->json([
                    'message' => "Departamento no encontrado"
                ], 404);
            }

            $new_initiative = new Initiative([
                "name" => $validateData["name"],
                "description" => $validateData["description"],
                "id_user" => $user -> id,
                "status" => $validateData["status"],
                "id_department" => $validateData["id_department"],
                "image" => $url
            ]);

            $new_initiative->save();

            return response()->json([
                'message' => "Iniciativa guardada con exito",
                'result' => $new_initiative
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->getmessages();

            return response()->json([
                'message' => 'Error de validacion',
                'errors' => $errors
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Initiative $initiative)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Initiative $initiative)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $initiative = Initiative::find($id);

        if (!$initiative) {
            return response()->json([
                'message' => 'Iniciativa no encontrada'
            ], 404);
        }

        try {
            $validateData = $request->validate([
                "name" => 'string',
                "description" => 'string',
                "id_department" => 'integer',
                "status" => ['in:en revisión,completado,descartado'],
                "image" => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);

            // Procesar la imagen solo si se ha enviado una nueva
            if ($request->hasFile('image')) {
                // Eliminar la imagen anterior si existe
                if (Storage::disk(self::$PATH_NAME)->exists($initiative->image)) {
                    Storage::disk(self::$PATH_NAME)->delete($initiative->image);
                }

                // Guardar la nueva imagen
                $image = $request->file('image');
                $imageName = time() . '_' .  str_replace(" ", "_", $image->getClientOriginalName());
                Storage::disk(self::$PATH_NAME)->put($imageName, file_get_contents($image));
                // Obtener la URL de la imagen actualizada
                $url = Storage::disk(self::$PATH_NAME)->url($initiative->image_name);

                // Actualizar el nombre de la imagen en el modelo
                $initiative->image = $url;
            }

            // Actualizar los otros campos del modelo
            $initiative->update($request->except('image'));
            var_dump($validateData['status']);


            return response()->json([
                'message' => 'Edificio editado satisfactoriamente',
                'result' => $initiative,
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->getMessages();

            return response()->json([
                'message' => 'Error de validación',
                'errors' => $errors
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $initiative = Initiative::find($id);

        if (!$initiative) {
            return response()->json([
                'message' => 'Iniciativa no encontrada'
            ], 404);
        }

        $initiative->delete();
        return response()->json([
            'message' => 'Iniciativa borra con exito'
        ], 200);
    }
}
