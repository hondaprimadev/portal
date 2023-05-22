<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\MemoUpload;
use App\Services\UploadMemoManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class MemoUploadController extends Controller
{
	private $manager;
	private $storage;

    public function __construct(UploadMemoManager $manager)
    {
    	$this->manager = $manager;
    	$this->storage = Storage::disk('local');
    }

    public function getFile(Request $request)
    {
    	$no_memo = $request->input('no_memo');
        $memo = MemoUpload::where('no_memo', $no_memo)->get();

        return $memo;
    }

    public function postFile(Request $request)
    {
    	$files = $request->all();
    	$response = $this->manager->upload($files, $files['branch_id'], $files['no_memo']);
    	return $response;
    }

    public function showFile(Request $request,$file)
    {
        $branch_id = $request->input('branch');
        $upload = MemoUpload::where('file_name', $file)->first();
        
        if (!$upload) {
            return abort(404);
        }
        // $files = $this->storage->get('memo/'.$branch_id.'/'.$file);
        $files = $this->storage->get('memo/'.$branch_id.'/'.$upload->file_name);
        if (!$files) {
            return abort(404);
        }

        if ($upload->file_type == 'application/pdf' || $upload->file_type == 'image/jpeg') {
            return (new Response($files, 200))
              ->header('Content-Type', $upload->file_type);
        }
        else{
            $path = storage_path('app/memo/'.$branch_id.'/'.$upload->file_name);
            return response()->download($path);
        }
    }

    public function deleteFile(Request $request, $id)
    {
    	$branch_id = $request->input('branch');
        $file = $this->manager->delete($id,$branch_id);

        return $file;
    }
}
