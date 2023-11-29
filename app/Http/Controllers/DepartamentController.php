<?php

namespace App\Http\Controllers;

use App\Models\Departament;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepartamentController extends Controller
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
    public function create(Request $request)
    {
        try {
            $validateData = $request -> validate([
               'name' => 'required|string',
               'url_image' => 'string'
           ]);

           $user = new Departament([
               'name' => $validateData['name'],
            //    'url_image' => $validateData['url_image']
           ]);

           $user -> save();

           return response() -> json([
            'message' => 'Departamento creado satisfactoriamente',
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
    public function show(Departament $departament)
    {
        //
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
    public function update(Request $request, Departament $departament)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departament $departament)
    {
        //
    }
}
