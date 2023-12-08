<?php

namespace App\Http\Controllers;

use App\Models\Departament;
use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

// Se tiene que cambiar el nombre
class DepartamentController extends Controller
{
    static $PATH_NAME = 'department';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Departament::all();

        return response()->json($departments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'name' => 'required|string',
                'code_name' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);


            $department = new Departament([
                'name' => $validateData['name'],
                'code_name' => $validateData['code_name']
            ]);

            if ($request->file('image')) {
                $file = $request->file('image');
                $imageName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                Storage::disk(self::$PATH_NAME)->put($imageName, file_get_contents($file));
                $url = Storage::disk(self::$PATH_NAME)->url($imageName);
                $department->image = $url;
            }
            $department->save();

            return response()->json([
                'message' => 'Departamento creado satisfactoriamente',
                'result' => $department
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->getMessages();

            return response()->json([
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
        $departamento = Departament::find($id);

        if (!$departamento) {
            // Maneja el caso en el que el departamento no se encuentra
            return response()->json(['message' => 'Departamento no encontrado'], 404);
        }

        return response() -> json($departamento);
        // Devuelve los detalles del departamento en formato JSON
        // Además, ahora devuelve la vista Blade 'departamento.show' con la variable $departamento
        // return view('departamento.show', ['departamento' => $departamento]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departament $departament)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $department = Departament::find($id);

        if (!$department) {
            return response()->json([
                'message' => 'Departamento no encontrado'
            ], 404);
        }

        try {
            $request->validate([
                'name' => 'required|string',
                'code_name' => 'required|string',
                'image' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);

            // Procesar la imagen solo si se ha enviado una nueva
            if ($request->hasFile('image')) {
                // Eliminar la imagen anterior si existe
                if (Storage::disk(self::$PATH_NAME)->exists($department->image)) {
                    Storage::disk(self::$PATH_NAME)->delete($department->image);
                }

                // Guardar la nueva imagen
                $image = $request->file('image');
                $imageName = time() . '_' .  str_replace(" ", "_", $image->getClientOriginalName());
                Storage::disk(self::$PATH_NAME)->put($imageName, file_get_contents($image));
                // Obtener la URL de la imagen actualizada
                $url = Storage::disk(self::$PATH_NAME)->url($imageName);
                // Actualizar el nombre de la imagen en el modelo
                $department->image = $url;
            }

            $department->update($request->except('image'));

            return response() -> json([
                'message' => 'Informacion actualizada con exito',
                'result' => $department
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->getMessages();

            return response()->json([
                'message' => 'Error de validacion',
                'errors' => $errors
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $department = Departament::find($id);

        if (!$department) {
            return response()->json([
                "message" => "Departamento no encontrado"
            ], 404);
        }

        $department->delete();
        return response()->json([
            'message' => 'Departamento eliminado'
        ], 200);
    }
}
