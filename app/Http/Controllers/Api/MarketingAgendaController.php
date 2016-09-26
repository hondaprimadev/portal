<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\MarketingAgenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class MarketingAgendaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $agendas = MarketingAgenda::where('user_id', $request->input('id'));

        if (!$agendas) {
            return Response::json([
                'error'=>true,
                'message' => 'Agenda does not exist'
            ], 404);
        }

        return Response::json([
            'error'=>false,
            'data' => $agendas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $agenda = MarketingAgenda::create($request->all());

        if (!$agenda) {
            return Response::json([
                'error'=>true,
                'message'=>'failed to create agenda'
            ], 404);
        }

        return Response::json([
            'error' => false,
            'message'=> 'success create agenda',
            'data'=>$agenda
        ], 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $agenda = MarketingAgenda::findOrFail($id);
        $agenda->update($request->all());

        if (!$agenda) {
            return Response::json([
                'error'=>true,
                'message'=>'failed to update agenda'
            ], 404);
        }

        return Response::json([
            'error' => false,
            'message'=> 'success update agenda',
            'data'=>$agenda
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agenda = MarketingAgenda::findOrFail($id);
        $agenda->delete();

        if (!$agenda) {
            return Response::json([
                'error'=>true,
                'message'=>'failed to delete agenda'
            ], 404);
        }

        return Response::json([
            'error' => false,
            'message'=> 'success delete agenda',
            'data'=>$agenda
        ], 200);
    }
}
