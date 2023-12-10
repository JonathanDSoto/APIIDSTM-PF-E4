<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Controllers\Controller;
use App\Models\Departament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SubjectController extends Controller
{
    static $PATH_NAME = "subjects";
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();

        foreach ($subjects as $subject) {
            $department = Departament::find($subject->id_departament);

            $subject->department = $department;
        }

        return response()->json($subjects);
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
                'name' => 'required|string',
                'description' => 'required|string',
                'id_departament' => 'required|integer|exists:departaments,id',
                'status' => ['required', 'in:en revisión,aprobado,descartado'],
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $subject = new Subject([
                'name' => $validateData['name'],
                'description' => $validateData['description'],
                'id_departament' => $validateData['id_departament'],
            ]);

            if ($request->file('image')) {
                $file = $request->file('image');
                $imageName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                Storage::disk(self::$PATH_NAME)->put($imageName, file_get_contents($file));
                $url = Storage::disk(self::$PATH_NAME)->url($imageName);
                $subject->image = $url;
            }
            $subject->save();

            // $departmentClass = new DepartamentController();
            // $department = $departmentClass->show($subject->id);

            return response()->json([
                'message' => 'Materia creada satisfactoriamente',
                'result' => $subject
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->getMessages();

            return response()->json([
                'message' => 'Error de validacion',
                'errors' => $errors
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $subject = Subject::find($id);

        if(!$subject) {
            return response() -> json([
                'message' => 'Materia no encontrada'
            ], 404);
        } 

        try {
            $validateData = $request -> validate([
                'name' => 'string',
                'description' => 'string',
                'id_departament' => 'integer|exists:departaments,id',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);
    
            // Procesar la imagen solo si se ha enviado una nueva
            if ($request->hasFile('image')) {
                // Eliminar la imagen anterior si existe
                if (Storage::disk(self::$PATH_NAME)->exists($subject->image)) {
                    Storage::disk(self::$PATH_NAME)->delete($subject->image);
                }
    
                // Guardar la nueva imagen
                $image = $request->file('image');
                $imageName = time() . '_' .  str_replace(" ", "_", $image->getClientOriginalName());
                Storage::disk(self::$PATH_NAME)->put($imageName, file_get_contents($image));
                // Obtener la URL de la imagen actualizada
                $url = Storage::disk(self::$PATH_NAME)->url($imageName);
                // Actualizar el nombre de la imagen en el modelo
                $subject->image = $url;
            }
            $subject -> update($request -> except('image'));
    
            return response() -> json([
                'message' => 'Informacion de materia actualizada con exito',
                'result' => $subject
            ]);

        } catch(ValidationException $e) {
            $errors = $e -> validator -> errors() -> getMessages();

            return response() -> json([
                'message' => 'Error de validacion',
                'errors' => $errors
            ], 400);   
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subject = Subject::find($id);

        if(!$subject) {
            return response() -> json([
                'message' => 'Materia no encontrada'
            ], 404);
        }

        $subject -> delete();
        return response() -> json([
            'message' => "Materia eliminada con exito"
        ]);
    }
}
