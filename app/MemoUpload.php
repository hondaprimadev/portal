<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemoUpload extends Model
{
    protected $fillable = ['no_memo','original_name','file_name','file_type','file_size','branch_id','token'];

    public static $rules = [
        'upload_memo' => 'required',
        'branch_id'=>'required',
        'no_memo'=>'required'
    ];
    public static $messages = [
        'file.mimes' => 'Uploaded file is not in format',
        'file.required' => 'File type is required'
    ];

    public function getFileSizeAttribute($value)
    {
        return formatSizeUnits($value);
    }
}
