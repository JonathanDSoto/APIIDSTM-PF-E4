<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::all();

        foreach ($reports as $report) {
            $user = User::find($report->id_user);
            $building = Place::find($report->id_building);

            $report->user = $user;
            $report->building = $building;
        }

        return response()->json($reports);
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
                "title" => 'required|string',
                "description" => 'required|string',
                "id_building" => 'required|integer',
                "status" => ['required', 'in:en revisión,completado,Descartado']
            ]);

            $token = $request->attributes->get('token');

            $user = User::find(Session::where('api_token', $token)->first()->id_user);
            $building = Place::find($validateData['id_building']);

            if (!$user) {
                return response()->json([
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            if (!$building) {
                return response()->json([
                    'message' => 'Edificio  no encontrado'
                ], 404);
            }

            $new_report = new Report([
                "title" => $validateData['title'],
                "description" => $validateData['description'],
                "id_user" => $user->id,
                "id_building" => $validateData['id_building'],
                "status" => $validateData['status'],
            ]);

            $new_report->save();

            return response()->json([
                "message" => 'Reporte registrado con exito',
                'result' => $new_report
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->getMessages();

            return response()->json([
                'message' => 'Error de validacion',
                'erors' => $errors
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
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
        try {
            $validateData = $request->validate([
                "title" => 'required|string',
                "description" => 'required|string',
                "id_building" => 'required|integer',
                "status" => ['required', 'in:en revisión,completado,Descartado']
            ]);

            $report = Report::find($id);
            if ($report) {
                $token = $request->attributes->get('token');
                $user = User::find(Session::where('api_token', $token)->first()->id_user);
                $building = Place::find($validateData['id_building']);
                
                if (!$user) {
                    return response()->json([
                        'message' => 'Usuario no encontrado'
                    ], 404);
                }

                if (!$building) {
                    return response()->json([
                        'message' => 'Edificio  no encontrado'
                    ], 404);
                }

                $report->update($validateData);

                return response()->json([
                    "message" => 'Reporte actualizado con exito',
                    'result' => $report
                ]);
            }

            return response()->json([
                'message' => 'Reporte  no encontrado'
            ], 404);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->getMessages();

            return response()->json([
                'message' => 'Error de validacion',
                'erors' => $errors
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $report = Report::find($id);

        if (!$report) {
            return response()->json([
                'message' => 'Reporte no encontrado'
            ]);
        }

        $report->delete();
        return response()->json([
            'message' => 'Reporte borrado con exito'
        ]);
    }
}
