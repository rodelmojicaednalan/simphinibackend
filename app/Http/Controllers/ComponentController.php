<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vinkla\Hashids\HashidsManager;
use App\Models\Tablelist;

class ComponentController extends Controller
{
    protected $hashids;
    protected $tablelist;

    public function __construct (HashidsManager $hashids, TableList $tablelist) 
    {
        $this->hashids = $hashids;
        $this->tablelist = $tablelist;
    }


    public function encodeHashid ($id) 
    {
        return $this->hashids->encode($id);
    }


    public function decodeHashid ($hashid) 
    {
        $decode = $this->hashids->decode($hashid);
        $output = $decode[0];
        return $output;
    }

    public function encrypt ($str) 
    {
        return Crypt::encryptString($str);
    }

    public function decrypt ($str) 
    {
        return $encrypted = Crypt::decryptString($str);
    }

    public function generateUUID () 
    {
        $bytes = random_bytes(5);
        return strtoupper(bin2hex($bytes));
    }

    public function generateLongUUID () 
    {
        $bytes = random_bytes(20);
        return strtoupper(bin2hex($bytes));
    }

    public function verificationCode () 
    {
        return mt_rand(1000, 9999);
    }
}
