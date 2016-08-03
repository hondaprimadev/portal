<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Crm;
use App\Crmtype;
use App\Branch;
use DB;

use Gate;

class CrmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->authorize('crm.open');
        
        if (Gate::allows('crm.super')) {
            $crms = Crm::with(['crmtypes' => function($query){
                $query->where('name', 'Customer');
            }])->get();
            if (auth()->user()->branch->id == '100') {
                $branch_select = '';
            }else{
                $branch_select = auth()->user()->branch->name;
            }
        }
        else{
            $crms = Crm::with(['crmtypes' => function($query){
                $query->where('name', 'Customer');
            }])->CrmBranch()->get();
            $branch_select = auth()->user()->branch->name;
        }

        // return $crms;
        $type_filter = [''=>'Type Customer'] + Crmtype::lists('name','id')->all();
        $branch_filter = [''=>'All Branch'] + Branch::lists('name','name')->all();

        return view('crm.index', compact('crms', 'branch_filter', 'branch_select', 'type_filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('crm.create');


        $crmtypes = Crmtype::lists('name','id')->all();
        $branches = Branch::lists('name', 'id')->all();

        return view('crm.create', compact('crmtypes','branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->authorize('crm.create');

        $this->validate($request, ['type_list'=>'required', 'nomor_crm'=>'required']);
        $crm = Crm::create($request->all());
        $crm->crmtypes()->sync($request->input('type_list'));
        session()->flash('flash_message', 'Your Customer has been created!');
        
        return redirect('/crm');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $this->authorize('crm.edit');

        $crm = Crm::findOrFail($id);
        $crmtypes = Crmtype::lists('name','id')->all();
        $branches = Branch::lists('name', 'id')->all();
        
        return view('crm.edit', compact('crm','crmtypes', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('crm.edit');

        $crm = Crm::findOrFail($id);
        $crm->update($request->all());
        $crm->crmtypes()->sync($request->input('type_list'));

        return redirect('/crm');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete(Request $request)
    {
        $this->authorize('crm.delete');

        foreach($request->input('id') as $key=>$val)
        {
            $crm = Crm::findOrFail($val);
            $crm->delete();
        }
        
        session()->flash('flash_message','Your Customer has been deleted!');

        return redirect('/crm');
    }

    public function search(Request $request)
    {
        $name = $request->input('name_supplier');
        $no = $request->input('nomor_supplier');
        $type = $request->input('type_customer');

        if ($type == 'Group') 
        {
            if ($name!='' || $no!='') {
                $search = Crm::where('name_group', 'LIKE', '%'. $name . '%')
                            ->where('nomor_crm', 'LIKE', '%' . $no . '%')
                            ->get();
            }
            else
            {
                $search = Crm::where('type_customer', 'Group')->get();
            }
        }
        else
        {
            if ($name!='' || $no!='') {
                $search = Crm::where('name_personal', 'LIKE', '%'. $name . '%')
                            ->where('nomor_crm', 'LIKE', '%' . $no . '%')
                            ->get();
            }
            else
            {
                $search = Crm::where('type_customer', 'Personal')->get();
            }   
        }

        return $search;
    }

    public function getNomor(Request $request)
    {
        $no = $request->input('nomor_supplier');
        return Crm::MaxNumber();
    }
}