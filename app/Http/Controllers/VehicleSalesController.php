<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\VehicleSales;
use App\Branch;

class VehicleSalesController extends Controller
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

        $vs = VehicleSales::whereBetween('faktur_date', [$begin, $end])->get();

        $branch_filter = [''=>'All Branch'] + Branch::lists('name','name')->all();

        return view('vehicle.sales.index',compact('vs','branch_filter', 'begin','end'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete(Request $request)
    {
        foreach ($request->input('id') as $key => $value) {
            $vs = VehicleSales::findOrFail($value);
            $vs->delete();
        }

        return redirect('marketing/vehicle/sales');
    }
}
