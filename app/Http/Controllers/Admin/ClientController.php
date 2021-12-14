<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Client;
use App\Repositories\Admin\ClientRepositoryEloquent as AdminClient;

class ClientController extends Controller
{
    protected $client;

    public function __construct(AdminClient $clientRepo)
    {
        $this->clientRepo = $clientRepo;
    }

    public function index(){
        $columns = ['id', 'company_name', 'company_email', 'company_address', 'status', 'created_at'];
        $data['data'] = $this->clientRepo->paginate(10, null, null, $columns);
        $data['status'] = true;
        return response()->json($data,200);
    }
}
