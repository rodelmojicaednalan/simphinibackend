<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Client;

class ClientController extends Controller
{
    protected $client; 

    public function __construct (Client $client) 
    {
        $this->client = $client;
    }

    public function index () 
    {
        $data['client'] = $this->client->orderBy('company_name')->get();
        $data['status'] = 200;
        return response()->json($data);
    }
}
