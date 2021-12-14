<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Storage;

function encode($id){
    return Hashids::encode($id,0,5,0,6,9);
}

function decode($id){
    return Hashids::decode($id)[0];
}

function fileUpload($path, $field, $hasfile, $default = '', $type = ''){
    switch ($type) {
    case 'S3':
      # code...
      break;
    
    default:
    
      $destinationPath = $path;
      if($hasfile){
        if($field->isValid()){
          $filename = $field->getClientOriginalName();
          $extension = $field->getClientOriginalExtension();
          $file = $destinationPath.'/'.pathinfo(str_replace(' ', '_', $filename), PATHINFO_FILENAME).'_'.Carbon::now()->format('Ymdhis').'.'.$extension;
          $field->move($destinationPath, $file);
        }
      } else {
        $file = $default;
      }
      return isset($file) ? $file : '';
  
      break;
    }
  }
  
  function multipleFileUpload($path, $fields, $hasfile, $type = '') {
    switch ($type) {
      case 'S3':
        # code...
        break;
      
      default:
      
        $destinationPath = $path;
        $files = [];
        if($hasfile){
          foreach ($fields as $field) {
            $filename = $field->getClientOriginalName();
            $extension = $field->getClientOriginalExtension();
            $file = $destinationPath.'/'.pathinfo(str_replace(' ', '_', $filename), PATHINFO_FILENAME).'_'.Carbon::now()->format('Ymdhis').'.'.$extension;
            $field->move($destinationPath, $file);
            $files[] = $file;
          }
        }
        return $files;
        break;
    }
  }
  
  function resizeFileUpload($path, $field, $hasfile, $width, $small_default = '', $default = '', $type = ''){
    switch ($type) {
      case 'S3':
        if($hasfile){
          if($field->isValid()){
            $imgproperties = getimagesize($field);
            $smallwidth = $width;
            $smallheight = ($imgproperties[0] / $imgproperties[1]) * $smallwidth;
            $filename = $field->getClientOriginalName();
            $extension = $field->getClientOriginalExtension();
            $file = $path.'/'.pathinfo(str_replace(' ', '_', $filename), PATHINFO_FILENAME).'.'.$extension;
  
            $small = Image::make($field->getRealPath())->resize($smallheight, $smallwidth);
            $imgsmall = $small->stream();
  
            $full = Image::make($field->getRealPath());
            $imgfull = $full->stream();
            Storage::disk('s3')->put($path.'/'.pathinfo(str_replace(' ', '_', $filename), PATHINFO_FILENAME).'.'.$extension, $imgsmall->__toString(), 'public');
            Storage::disk('s3')->put($path.'/'.pathinfo(str_replace(' ', '_', $filename), PATHINFO_FILENAME).'.'.$extension, $imgfull->__toString(), 'public');
  
            return [
              'small' => Storage::cloud()->url($path.'/'.pathinfo(str_replace(' ', '_', $filename), PATHINFO_FILENAME).'.'.$extension),
              'full' => Storage::cloud()->url($path.'/'.pathinfo(str_replace(' ', '_', $filename), PATHINFO_FILENAME).'.'.$extension)
            ];
          }
        } else {
          $file = $default;
        }
        return isset($file) ? $file : '';
      break;
      
      default:
      
      $destinationPath = public_path().'/'.$path;
      if($hasfile){
        if($field->isValid()){
          $imgproperties = getimagesize($field);
          $smallwidth = $width;
          $smallheight = ($imgproperties[0] / $imgproperties[1]) * $smallwidth;
          $filename = $field->getClientOriginalName();
          $extension = $field->getClientOriginalExtension();
          $file = $destinationPath.'/'.pathinfo(str_replace(' ', '_', $filename), PATHINFO_FILENAME).'.'.$extension;
  
          $small = Image::make($field->getRealPath())->resize($smallheight, $smallwidth);
          $small->save($destinationPath.'/'.pathinfo(str_replace(' ', '_', $filename), PATHINFO_FILENAME).'.'.$extension, 100);
          $field->move($destinationPath, $file);
  
          return [
            'small' => $path.'/'.pathinfo(str_replace(' ', '_', $filename), PATHINFO_FILENAME).'.'.$extension,
            'full' => $path.'/'.pathinfo(str_replace(' ', '_', $filename), PATHINFO_FILENAME).'.'.$extension
          ];
        }
      } else {
        $smallfile = $small_default;
        $file = $default;
      }
      return [
        'small' => isset($smallfile) ? $smallfile : '',
        'full' => isset($file) ? $file : ''
      ];
  
      break;
    }
  }

function setConnection(){
    $clientuser = Auth::user()->client;
    \Config::set('database.connections.client', array(
        'driver'    => 'mysql',
        'host'      => $clientuser->db_host,
        'database'  => $clientuser->db_name,
        'username'  => $clientuser->db_username,
        'password'  => $clientuser->db_password,
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ));
    
    return \DB::connection('client');
}

function db_connect2($id){
    $clientuser = \DB::table('clients')->where('id', $id)->first();
    \Config::set('database.connections.client', array(
        'driver'    => 'mysql',
        'host'      => $clientuser->db_host,
        'database'  => $clientuser->db_name,
        'username'  => $clientuser->db_username,
        'password'  => $clientuser->db_password,
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ));
}

function xml2array($xmlObject, $out = []){
    foreach ((array) $xmlObject as $index => $node){
        $out[$index] = (is_object( $node)) ? xml2array($node) : $node;
    }
    return $out;
}

function array2csv($array, $filename){
	if (count($array) == 0) {
		return null;
	}

	ob_start();
	$df = fopen($filename, 'w');
	$array = str_replace('"', '', $array);
	fputcsv($df, array_keys(reset($array)));
	foreach ($array as $row) {
		fputcsv($df, $row);
	}
	fclose($df);
	ob_get_clean();

	$file = fopen($filename, 'r');
	while (($line = fgetcsv($file)) !== FALSE) {
	  $data[] = $line;
	}
	fclose($file);
	array_shift($data);

	$file = fopen($filename, 'w');
	foreach ($data as $fields) {
	    fputcsv($file, $fields);
	}
	fclose($file);
}

/**
 * @param string $string
 * @param string $delimeter
 * 
 * @return string
 */
function name_formatter($string,$delimiter = "_"){
    return str_replace(['-',' '], $delimiter, $string);
}