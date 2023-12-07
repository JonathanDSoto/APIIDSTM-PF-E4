<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PlaceController extends Controller
{
    static $PATH_NAME = "buildings";
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buidings = Place::all();

        foreach ($buidings as $building) {
            $image_url = Storage::disk(self::$PATH_NAME)->url($building->image_name);
            $building->image_url = $image_url;
        }

        return response()->json($buidings);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
                'latitude' => 'required|string',
                'altitude' => 'required|string',
                'radius' => 'required|integer',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $image = $request->file('image');
            $imageName = time() . '_' .  str_replace(" ", "_", $image->getClientOriginalName());
            // $image->storeAs('public/buildings', $imageName);
            Storage::disk(self::$PATH_NAME)->put($imageName, file_get_contents($image));
            $url = Storage::disk(self::$PATH_NAME)->url($imageName);

            $place = new Place([
                'name' => $validateData['name'],
                'code_name' => $validateData['code_name'],
                'latitude' => $validateData['latitude'],
                'altitude' => $validateData['altitude'],
                'radius' => $validateData['radius'],
                'image' => $imageName,
            ]);

            $place->save();


            return response()->json([
                'message' => 'Edificio creado satisfactoriamente',
                'result' => [
                    'id'    => $place->id,
                    'name'  => $place->name,
                    'latitude'  => $place->latitude,
                    'altitude'  => $place->altitude,
                    'radius'    => $place->radius,
                    'image_name' => $place->image_name,
                    'image_url' => $url
                ],
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
    public function show(Place $place)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $place = Place::find($id);

        if (!$place) {
            return response()->json([
                'message' => 'Edificio no encontrado'
            ], 404);
        }

        try {
            $request->validate([
                'name' => 'string',
                'code_name' => 'string',
                'latitude' => 'string',
                'altitude' => 'string',
                'radius' => 'integer',
                'image_name' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);

            // Procesar la imagen solo si se ha enviado una nueva
            if ($request->hasFile('image_name')) {
                // Eliminar la imagen anterior si existe
                if (Storage::disk(self::$PATH_NAME)->exists($place->image_name)) {
                    Storage::disk(self::$PATH_NAME)->delete($place->image_name);
                }

                // Guardar la nueva imagen
                $image = $request->file('image_name');
                $imageName = time() . '_' .  str_replace(" ", "_", $image->getClientOriginalName());
                Storage::disk(self::$PATH_NAME)->put($imageName, file_get_contents($image));

                // Actualizar el nombre de la imagen en el modelo
                $place->image_name = $imageName;
            }

            // Actualizar los otros campos del modelo
            $place->update($request->except('image_name'));

            // Obtener la URL de la imagen actualizada
            $url = Storage::disk(self::$PATH_NAME)->url($place->image_name);

            return response()->json([
                'message' => 'Edificio editado satisfactoriamente',
                'result' => [
                    'id' => $place->id,
                    'name' => $place->name,
                    'latitude' => $place->latitude,
                    'altitude' => $place->altitude,
                    'radius' => $place->radius,
                    'image_name' => $place->image_name,
                    'image_url' => $url
                ],
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
        // Encuentra el registro por su ID
        $place = Place::find($id);

        // Verifica si el registro existe
        if (!$place) {
            return response()->json([
                'message' => 'Edificio no encontrado',
            ], 404);
        }

        // Elimina el registro de la base de datos
        $place->delete();

        // Retorna una respuesta exitosa
        return response()->json([
            'message' => 'Edificio eliminado satisfactoriamente',
        ]);
    }
}
