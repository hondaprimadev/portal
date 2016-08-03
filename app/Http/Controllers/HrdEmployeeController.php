<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Http\Requests;
use App\Services\UploadProfileManager;
use App\User;
use App\UserDepartment;
use App\UserPicture;
use App\UserPosition;
use Illuminate\Http\Request;

class HrdEmployeeController extends Controller
{
    private $manager;

    public function __construct(UploadProfileManager $manager)
    {
        $this->manager = $manager;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('hrd.employee.open');

        $begin = $request->input('begin');
        $end  = $request->input('end');
        if (!$begin && !$end) {
            $begin = "2016-07-01";
            $end = "2016-07-31";
        }
        $employee = User::all();
        $branches = [''=>'All Branch'] + Branch::lists('name','name')->all();
        
        return view('hrd.employee.index', compact('employee', 'begin','end','branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('hrd.employee.create');
        
        $branch = [''=>'---'] + Branch::lists('name', 'id')->all();
        $depts = [''=>'---'] + UserDepartment::lists('name', 'id')->all();
        $position = [''=>'---'] + UserPosition::lists('name', 'id')->all();

        return view('hrd.employee.create', compact('branch','depts','position'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('hrd.employee.create');

        $photo = $request->input('profile_text');

        $user = new User($request->all());
        // $fam = [];
        // foreach($request->input('name_fam') as $key=>$val)
        // {
        //     $fam = [
        //         'nik'=> $request->input('nik'),
        //         'name'=>$val,
        //         'birthday'=>$request->input('birthday_fam')[$key],
        //         'birthplace'=> $request->input('birthplace_fam')[$key],
        //         'gender'=>$request->input('gender_fam')[$key],
        //         'occupation'=>$request->input('occupation_fam')[$key],
        //         'blood_type'=>$request->input('blood_type_fam')[$key],
        //     ];

        //     if($val !='')
        //     {
        //         HrmFamily::create($fam);
        //     }
        // }
        
        if ($request->input("nik_auto") == true) {
            $user->id = $this->getNik();
            $user->save();
        }else{
            $npk = $request->input('nik');
            $user = User::create($request->all());
        }
        
        $uploadProfile = $this->manager->uploadProfile($photo,$user->id);

        session()->flash('flash_message', 'Your Employee has been created!');

        return redirect('/hrd/employee');
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
        $this->authorize('hrd.employee.edit');

        $user = User::findOrFail($id);
        $branch = [''=>'---'] + Branch::lists('name', 'id')->all();
        $depts = [''=>'---'] + UserDepartment::lists('name', 'id')->all();
        $position = [''=>'---'] + UserPosition::lists('name', 'id')->all();

        return view('hrd.employee.edit',compact('user','branch','depts','position'));
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
        $this->authorize('hrd.employee.edit');

        $photo = $request->input('profile_text');

        // $fam = [];
        // foreach($request->input('name_fam') as $key=>$val)
        // {
        //     $id_fam = $request->input('id_fam')[$key];
        //     $fam = [
        //         'nik'=> $request->input('nik'),
        //         'name'=>$val,
        //         'birthday'=>$request->input('birthday_fam')[$key],
        //         'birthplace'=> $request->input('birthplace_fam')[$key],
        //         'gender'=>$request->input('gender_fam')[$key],
        //         'occupation'=>$request->input('occupation_fam')[$key],
        //         'blood_type'=>$request->input('blood_type_fam')[$key],
        //     ];

        //     if($val !='')
        //     {
        //         if($id_fam !='')
        //         {
        //             $fams = HrmFamily::findOrFail($id_fam);
        //             $fams->update($fam);
        //         }
        //         else{
        //             HrmFamily::create($fam);
        //         }

        //     }
        // }

        $user = User::findOrFail($id);
        $user->update($request->all());

        if(!empty($photo)){
            $uploadProfile = $this->manager->uploadProfile($photo,$user->id);
        }

        session()->flash('flash_message', 'Your Employee has been updated!');

        return redirect('/hrd/employee');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('hrd.employee.delete');

        $hrm = User::findOrFail($id);
        $hrm->delete();

        session()->flash('flash_message', 'Your Employee has been deleted!');
        return redirect('/hrd/employee');
    }

    public function delete(Request $request)
    {
        $this->authorize('hrd.employee.delete');

        foreach($request->input('id') as $key=>$val)
        {
            $user = User::findOrFail($val);
            $up = UserPicture::where('user_id',$user->id)->first();
            if ($up) {
                $this->manager->deleteProfileArray($up->filename);
            }
            $user->delete();
        }
        session()->flash('flash_message','Your Employee has been deleted!');

        return redirect('/hrd/employee');
    }

    public function addUser(Request $request)
    {
        $this->authorize('hrd.employee.add.user');

        foreach ($request->input('id') as $key => $value) {
            $user = User::findOrFail($value);
            $user->is_user = true;
            $user->password = bcrypt('1234567890');
            $user->token = md5(uniqid($user->id, true));
            $user->save();
        }

        session()->flash('flash_message', "Your Employee has been added to User Sistem");

        return redirect('/hrd/employee');
    }
    public function getNik()
    {
        $this->authorize('hrd.employee.open');

        $max_nik = User::max('id');
        return $max_nik + 1;
    }
}
