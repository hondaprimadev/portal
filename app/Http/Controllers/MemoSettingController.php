<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\JournalAccount;
use App\MemoCategory;
use App\UserDepartment;
use Illuminate\Http\Request;

class MemoSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $this->authorize('memo.super');

        $mc = MemoCategory::all();
        $journal = JournalAccount::all();

        $ja = [''=>'--Account--'] + JournalAccount::lists('account_name','account_name')->all();
        $department = [''=>'--Department--'] + UserDepartment::lists('name','name')->all();

        $jaccount = JournalAccount::lists('account_name','id')->all();
        $dept = UserDepartment::lists('name','id')->all();

        if (!$request->session()->has('tab')) {
            $request->session()->put('tab','category');
        }

        return view('memo.setting.index',compact('mc','ja','acc','department','journal','jaccount','dept'));
    }
}
