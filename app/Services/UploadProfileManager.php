<?php
namespace App\Services;

use App\UserPicture;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Filesystem\Filesystem;
use Intervention\Image\ImageManager; 

class UploadProfileManager
{
  protected $manager;
  protected $disk;

  public function __construct(ImageManager $manager)
  {
    $this->manager = $manager;
    $this->disk = Storage::disk('local');
  }

  public function uploadProfile($photo, $user_id)
  {
    if (Storage::exists('profile/tmp/'. $photo)) {
      $filename = sha1(mt_rand()) . '.jpg';
      $uploadSuccess = $this->disk->move('profile/tmp/'.$photo, 'profile/'.$filename);

      UserPicture::create([
        'user_id' => $user_id,
        'filename'=>$filename,
        'filetype' => $this->disk->mimeType('profile/'.$filename),
        'filesize' => $this->disk->size('profile/'.$filename),
      ]);
    }else{
      $uploadSuccess = false;
    }
    
    if(!$uploadSuccess){
      return Response::json([
        'error'=> true,
        'message' => 'Server error while uploading',
        'code' => 500
      ], 500);
    }

    return Response::json([
      'error'=>false,
      'code'=> 200,
      'filename' => $filename,
      'filetype' => $this->disk->mimeType('profile/'.$filename),
      'filesize' => $this->disk->size('profile/'.$filename),
    ], 200);
  }

  public function uploadTemp($form_data)
  {
    $photo = $form_data['profile_picture'];

    $originalName = $photo->getClientOriginalName();
    $originalNameWithoutExt = substr($originalName, 0, strlen($originalName) - 4);
    $filename = $this->sanitize($originalNameWithoutExt);
    $allowed_filename = $this->createUniqueFilename($filename);
    $filenameExt = $allowed_filename .'.jpg';

    $image = $this->manager->make($photo)->encode('jpg')->fit(200);

    $uploadSuccess = Storage::disk('local')->put('/profile/tmp/'.$filenameExt, $image->stream());

    if(!$uploadSuccess){
      return Response::json([
        'error'=> true,
        'message' => 'Server error while uploading',
        'code' => 500
      ], 500);
    }

    return Response::json([
      'error'=>false,
      'code'=> 200,
      'filename' => $filenameExt,
      'original_name' => $originalName,
      'filetype' => $photo->getClientMimeType(),
      'filesize' => $photo->getClientSize(),
      'urltemp'=>route('hrd.employee.profile.tmp.get', $filenameExt),
    ], 200);
  }

  public function createUniqueFilename($filename)
  {
    if (Storage::exists('profile/tmp/'.$filename.'.jpg'))
      {
        $imageToken = substr(sha1(mt_rand()), 0, 5);
        return $filename . '-' . $imageToken;
      }

      return $filename;
  }

  public function deleteProfileTemp($filename)
  {
    if (! Storage::exists('profile/tmp/'. $filename)) {
          return false;
      }

      Storage::delete('profile/tmp/'. $filename);
      return Response::json([
      'error'=>false,
      'code'=> 200,
      'message' => 'delete success',
    ], 200);  
  }
  public function deleteProfile($filename)
  {
    $profile = UserPicture::where('filename', $filename)->first();
    
    if(!$profile)
    {
      return false;
    }
    else{
      if(! Storage::exists('profile/'.$profile->filename))
      {
        return false;
      }
      Storage::delete('profile/'.$profile->filename);
      $profile->delete();
    }

    return Response::json([
      'error'=>false,
      'code'=> 200,
      'message' => 'delete success',
    ], 200);  
  }

  public function deleteProfileArray($filename)
  {
    if(! Storage::exists('profile/'.$filename))
    {
      return false;
    }
    
    Storage::delete('profile/'.$filename);

    return Response::json([
      'error'=>false,
      'code'=> 200,
      'message' => 'delete success',
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
}