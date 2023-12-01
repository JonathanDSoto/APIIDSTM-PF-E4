<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SubjectController extends Controller
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
            $validateData = $request -> validate([
               'name' => 'required|string',
               'id_departament' => 'required'
           ]);

           $subject = new Subject([
               'name' => $validateData['name'],
               'id_departament' => $validateData['id_departament'],
            //    'url_image' => $validateData['url_image']
           ]);

           $subject -> save();

           $departmentClass = new DepartamentController();
           $department = $departmentClass -> show($subject -> id);

           return response() -> json([
            'message' => 'Materia creada satisfactoriamente',
            'result' => [
                'id' => $subject -> id,
                'name' => $subject -> name,
                'department' => $department -> original
            ]
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
    public function update(Request $request, Subject $subject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        //
    }
}
