<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\MarketingAgenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class MarketingAgendaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $begin = $request->input('b');
        $end = $request->input('e');

        if(!$begin && !$end)
        {
            $now = date('Y-m-');
            $d1 = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
            $begin = new \DateTime($now.'01');
            $end = new \DateTime($now.$d1);
        }else{
            $begin = new \DateTime($begin);
            $end = new \DateTime($end);
        }

        $agendas = MarketingAgenda::with('histories')
                    ->where('user_id', $request->input('id'))
                    ->orderBy('name', 'asc')
                    ->get();

        if ($agendas->count() == null || !$request->input('id')) {
            return Response::json([
                'status' => '404',
                'message'=>'failed to fetch agenda',
                'data'=>[]
            ], 404);
        }
        return Response::json([
            'status' => '200',
            'message' => 'success fetch agenda',
            'data'=> $this->transformCollection($agendas)
        ], 200);
    }

    public function show($id)
    {
        $agenda = MarketingAgenda::with('histories')
                    ->findOrFail($id);
        if (!$agenda) {
            return Response::json([
                'status'=> '404',
                'message' => 'cannot fetch this data',
                'data' => []
            ],404);
        }else{
            return Response::json([
                'status'=> '200',
                'message' => 'Agenda fetch Succesfully',
                'data' => [$this->transformId($agenda)]
            ],200);
        }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return Response::json([
                'status'=>'404',
                'message'=>$validator->errors(),
                'data'=>[]
            ], 404);
        }
        
        $agenda = MarketingAgenda::create($request->all());
        if ($request->input('notes') != '') {
            $agenda->histories()->create(['notes'=>$request->input('notes')]);   
        }
        
        if (!$agenda) {
            return Response::json([
                'status'=> '404',
                'message' => 'cannot save this data',
                'data' => []
            ],404);
        }else{
            return Response::json([
                'status'=> '200',
                'message' => 'Agenda Created Succesfully',
                'data' => [$this->transformId($agenda)]
            ],200);
        }
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
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return Response::json([
                'status'=>'404',
                'message'=>$validator->errors(),
                'data'=>[]
            ], 404);
        }
        $agenda = MarketingAgenda::findOrFail($id);
        $agenda->update($request->all());

        if ($request->input('notes') != '') {
            $agenda->histories()->create(['notes'=>$request->input('notes')]);   
        }

        if (!$agenda) {
            return Response::json([
                'status'=> '404',
                'message' => 'cannot update this data',
                'data' => []
            ],404);
        }else{
            return Response::json([
                'status'=> '200',
                'message' => 'Agenda Updated Succesfully',
                'data' => [$this->transformId($agenda)]
            ],200);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(!$id){
            return Response::json([
                'status'=>'404',
                'message'=>'id required',
                'data'=>[]
            ], 404);
        }

        $agenda = MarketingAgenda::findOrFail($id);
        $agenda->delete();

        if (!$agenda) {
            return Response::json([
                'status'=>'404',
                'message'=>'failed to delete agenda',
                'data'=>[]
            ], 404);
        }

        return Response::json([
            'status' => '200',
            'message'=> 'success delete agenda',
            'data'=> [$this->transformId($agenda)]
        ], 200);
    }

    private function validator($data)
    {
        return Validator::make($data, [
            'user_id' => 'required',
            'name'=> 'required',
            'phone'=>'required'
        ]);
    }

    public function transformCollection($agendas)
    {
        return array_map([$this, 'transform'], $agendas->toArray());
    }

    public function transform($agenda)
    {
        return [
            "id"=>$agenda['id'],
            "user_id"=>$agenda['user_id'],
            "branch_id"=>$agenda['branch_id'],
            "name"=>ucwords($agenda['name']),
            "phone"=>$agenda['phone'],
            "email"=>$agenda['email'],
            "address"=>$agenda['address'],
            "id_number"=>$agenda['id_number'],
            "city" => $agenda['city'],
            "name_stnk"=>$agenda['name_stnk'],
            "phone_stnk"=>$agenda['phone_stnk'],
            "email_stnk"=>$agenda['email_stnk'],
            "address_stnk"=>$agenda['address_stnk'],
            "id_number_stnk"=>$agenda['id_number_stnk'],
            "city_stnk"=>$agenda['city_stnk'],
            "type_payment"=>$agenda['type_payment'],
            "downpayment"=>$agenda['downpayment'],
            "price_otr"=>$agenda['price_otr'],
            "price_disc"=>$agenda['price_disc'],
            "leasing_id"=>$agenda['leasing_id'],
            "leasing_payment"=>$agenda['leasing_payment'],
            "leasing_tenor"=>$agenda['leasing_tenor'],
            "program_marketing"=>$agenda['program_marketing'],
            "motor_type"=>$agenda['motor_type'],
            "motor_color"=>$agenda['motor_color'],
            "status"=>$agenda['status'],
            "longitude"=>$agenda['longitude'],
            "latitude"=>$agenda['latitude'],
            "active"=>$agenda['active'],
            "created_at"=>date('Y-m-d', strtotime($agenda['created_at'])),
            "histories"=>$this->transformCollectionHistories($agenda['histories']),
        ];
    }

    public function transformId($agenda)
    {
        return [
            "id"=>$agenda['id'],
            "user_id"=>$agenda['user_id'],
            "branch_id"=>$agenda['branch_id'],
            "name"=>ucwords($agenda['name']),
            "phone"=>$agenda['phone'],
            "email"=>$agenda['email'],
            "address"=>$agenda['address'],
            "id_number"=>$agenda['id_number'],
            "city" => $agenda['city'],
            "name_stnk"=>$agenda['name_stnk'],
            "phone_stnk"=>$agenda['phone_stnk'],
            "email_stnk"=>$agenda['email_stnk'],
            "address_stnk"=>$agenda['address_stnk'],
            "id_number_stnk"=>$agenda['id_number_stnk'],
            "city_stnk"=>$agenda['city_stnk'],
            "type_payment"=>$agenda['type_payment'],
            "downpayment"=>$agenda['downpayment'],
            "price_otr"=>$agenda['price_otr'],
            "price_disc"=>$agenda['price_disc'],
            "leasing_id"=>$agenda['leasing_id'],
            "leasing_payment"=>$agenda['leasing_payment'],
            "leasing_tenor"=>$agenda['leasing_tenor'],
            "program_marketing"=>$agenda['program_marketing'],
            "motor_type"=>$agenda['motor_type'],
            "motor_color"=>$agenda['motor_color'],
            "status"=>$agenda['status'],
            "longitude"=>$agenda['longitude'],
            "latitude"=>$agenda['latitude'],
            "active"=>$agenda['active'],
            "created_at"=>date('Y-m-d', strtotime($agenda['created_at'])),
            "histories"=>$this->transformCollectionHistoriesId($agenda['histories']),
        ];
    }

    public function transformCollectionHistoriesId($histories)
    {
        return array_map([$this, 'transformHistories'], $histories->toArray());
        
    }

    public function transformCollectionHistories($histories)
    {
        return array_map([$this, 'transformHistories'], $histories);
        
    }

    public function transformHistories($histories)
    {
        return [
            "id"=>$histories['id'],
            "agenda_id"=>$histories['agenda_id'],
            "notes"=>$histories['notes'],
            "created_at"=>date("Y-m-d", strtotime($histories['created_at']))
        ];
    }
}