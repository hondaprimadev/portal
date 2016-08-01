<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\UploadProfileManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Request as Req;


class UserPictureController extends Controller
{
	private $pmanager;
	private $Storage;

	public function __construct(UploadProfileManager $pmanager)
	{
		$this->pmanager = $pmanager;
		$this->storage = Storage::disk('local');
	}

    public function postPicture()
    {
    	$photo = Input::all();
        $response = $this->pmanager->uploadTemp($photo);

        // $file = Req::file('profile_picture');
        // $extension = $file->getClientOriginalExtension();
        // Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));

        return $response;
    }

    public function getPicture($file)
    {
    	$files = $this->storage->get('profile/'.$file);
 
        return (new Response($files, 200))
              ->header('Content-Type', 'image/jpg');	
    }

    public function getTmpPicture($file)
    {
    	$files = $this->storage->get('profile/tmp/'.$file);
 
        return (new Response($files, 200))
              ->header('Content-Type', 'image/jpg');
    }

    public function deleteProfile($file)
    {
        $profile = $this->pmanager->deleteProfileTemp($file);
        if ($profile === false) {
            $pro = $this->pmanager->deleteProfile($file);
            if ($pro === false) {
                abort(403, 'Unauthorized action.');
            }
            return $pro;
        }

        return $profile;
    }
}
