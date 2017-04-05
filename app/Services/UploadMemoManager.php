<?php
namespace App\Services;

use App\MemoUpload;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;

/**
* 
*/
class UploadMemoManager
{
	protected $manager;
  	protected $disk;

	function __construct(ImageManager $manager)
	{
		$this->manager = $manager;
		$this->disk = Storage::disk('local');
	}

	public function upload($form_data, $branch_id, $no_memo)
	{
    $validator = Validator::make($form_data, MemoUpload::$rules);

    if ($validator->fails()) {

      return Response::json([
        'error' => true,
        'message' => $validator->messages()->first(),
        'code' => 400
      ], 400);
    }

		$file = $form_data['upload_memo'];


    $originalName = $file->getClientOriginalName();
    $ext = $file->getClientOriginalExtension();
    $originalNameWithoutExt = substr($originalName, 0, strlen($originalName) - 4);
    $filename = $this->sanitize($originalNameWithoutExt);
    $allowedName = $this->createUniqueFilename($filename,$ext,$branch_id);
    $filenameExt = $allowedName.'.'.$ext;

    $uploadSuccess = Storage::disk('local')->put('/memo/'.$branch_id.'/'.$filenameExt, File::get($file));

    	if(!$uploadSuccess){
      		return Response::json([	
        		'error'=> true,
        		'message' => 'Server error while uploading',
        		'code' => 500
      		], 500);
    	}

        $memo = MemoUpload::create([
            'no_memo'=>$no_memo,
            'original_name'=>$originalName,
            'file_name'=>$filenameExt,
            'file_type'=>$file->getMimeType(),
            'file_size' => $file->getSize(),
            'branch_id'=>$branch_id,
            'token'=>md5(uniqid($filenameExt, true))
        ]);

    	return Response::json([
	      'error'=>false,
	      'code'=> 200,
        'id'=> $memo->id,
	      'file_name' => $filenameExt,
	      'original_name' => $originalName,
	      'file_type' => $file->getMimeType(),
	      'file_size' => $file->getSize(),
        'branch_id'=>$branch_id,
	    ], 200);
	}

    public function delete($id,$branch_id)
    {
        $memoUpload = MemoUpload::find($id);
        
        if(!$memoUpload)
        {
          return false;
        }
        else{
          if(! Storage::exists('memo/'.$branch_id.'/'.$memoUpload->file_name))
          {
            return false;
          }
          Storage::delete('memo/'.$branch_id.'/'.$memoUpload->file_name);
          $memoUpload->delete();
        }

        return Response::json([
          'error'=>false,
          'code'=> 200,
          'message' => 'delete memo success',
        ], 200);  

    }

	public function sanitize($string, $force_lowercase = true, $anal = false)
  	{
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
  	}

    public function createUniqueFilename($filename,$ext,$branch_id)
    {
        if (Storage::exists('memo/'.$branch_id.'/'.$filename.'.'.$ext))
        {
            $imageToken = substr(sha1(mt_rand()), 0, 5);
            return $filename . '-' . $imageToken;
        }

        return $filename;
    }
}