<?php
/**
* Set any link as active by adding active class.
* @param [uri] $uri Current URI.
* @param string $output CSS class name.
*/

function set_active($uri, $output =  'active')
{
	if (is_array($uri)) {
		foreach ($uri as $u) {
			if (Route::is($u)) {
				return $output;
			}
		}
	} else{
		if (Route::is($uri)) {
			return $output;
		}
	}
}

function to_currency($currency,$delimiter='.',$kurung=false)
{
    if($currency == '' || $currency == 0)
    {
        $rupiah = '0';
        return $rupiah;
    }
    $neg = false;
    if($currency<0)
    {
        $neg = true;
        $currency = abs($currency);
    }
    $rupiah = number_format($currency,0,',',$delimiter);
    if($neg && $kurung)
    {
        $rupiah = '('.$rupiah.')';
    }
    /*
    if($neg && $kurung)
    {
        $rupiah = '<font color="red">-'.$rupiah.'</font>';
    }
    */
    return $rupiah;
}

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' kB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }

    return $bytes;
}

function getMime($file) {
    switch ($file) {
        case 'image/jpeg':
            return '<i class="fa fa-file-image-o fa-blue" aria-hidden="true"></i>';
            break;
        case 'application/octet-stream':
            return '<i class="fa fa-file-excel-o fa-green" aria-hidden="true"></i>';
            break;
        case 'application/CDFV2-corrupt':
            return '<i class="fa fa-file-excel-o fa-green" aria-hidden="true"></i>';
            break;
        case 'application/pdf':
            return '<i class="fa fa-file-pdf-o fa-red" aria-hidden="true"></i>';
        case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
            return '<i class="fa fa-3x" aria-hidden="true"></i>';
            break;

        default:
            return '<i class="fa fa-file-o fa-blue" aria-hidden="true"></i>';
    }
}