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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buidings = Place::all();

        return response() -> json($buidings);
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
        // $table->string('name');
        //     $table->string('lenght');
        //     $table->string('latitude');
        //     $table->integer('radius');
        //     $table->string('url_image');
        try {
            $validateData = $request->validate([
                'name' => 'required|string',
                'code_name' => 'required|string',
                'latitude' => 'required|string',
                'altitude' => 'required|string',
                'radius' => 'required|integer',
                'image_name' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $image = $request->file('image_name');
            $imageName = time() . '_' .  str_replace(" ", "_" ,$image-> getClientOriginalName()) ;
            // $image->storeAs('public/buildings', $imageName);
            Storage::disk('buildings')->put($imageName, file_get_contents($image));
            $url = Storage::disk('buildings')->url($imageName);

            $place = new Place([
                'name' => $validateData['name'],
                'code_name' => $validateData['code_name'],
                'latitude' => $validateData['latitude'],
                'altitude' => $validateData['altitude'],
                'radius' => $validateData['radius'],
                'image_name' => $imageName,
            ]);

            $place->save();


            return response()->json([
                'message' => 'Edificio creado satisfactoriamente',
                'result' => [
                    'id'    => $place -> id,
                    'name'  => $place -> name,
                    'latitude'  => $place -> latitude,
                    'altitude'  => $place -> altitude,
                    'radius'    => $place -> radius,
                    'image_name'=> $place -> image_name,
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
        $place = Place::find($id);

        if(!$place) {
            return response() -> json([
                'message' => 'Edificio no encontrado'
            ],404);
        }

        $request->validate([
            'name' => 'required|string',
            'code_name' => 'required|string',
            'latitude' => 'required|string',
            'altitude' => 'required|string',
            'radius' => 'required|integer',
            'image_name' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // $image = $request->file('image_name');
        // $imageName = time() . '_' .  str_replace(" ", "_" ,$image-> getClientOriginalName()) ;
        // // $image->storeAs('public/buildings', $imageName);
        // Storage::disk('buildings')->put($imageName, file_get_contents($image));
        $url = Storage::disk('buildings')->url($place -> image_name);

        // $place = new Place([
        //     'name' => $validateData['name'],
        //     'code_name' => $validateData['code_name'],
        //     'latitude' => $validateData['latitude'],
        //     'altitude' => $validateData['altitude'],
        //     'radius' => $validateData['radius'],
        //     // 'image_name' => $imageName,
        // ]);

        $place->fill($request -> all()) -> save();


        return response()->json([
            'message' => 'Edificio creado satisfactoriamente',
            'result' => [
                'id'    => $place -> id,
                'name'  => $place -> name,
                'latitude'  => $place -> latitude,
                'altitude'  => $place -> altitude,
                'radius'    => $place -> radius,
                'image_name'=> $place -> image_name,
                'image_url' => $url
            ],
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Place $place)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Place $place)
    {
        //
    }
}
