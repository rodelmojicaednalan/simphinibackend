<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\ClientRepositoryEloquent as Client;

class DashboardController extends Controller
{
    protected $clientRepo;

    function __construct(Client $clientRepo)
    {
        $this->clientRepo = $clientRepo;
    }

    public function index()
    {
        $clients = $this->clientRepo->rawAll("status = ?", ['Active']);
        $collection = collect($clients)->map(function ($client) {
            return [
                'name' => $client->company_name,
                'subscription' => $client->subscription ?? 'Basic',
                'storage' => $client->storage_used.'G/'.$client->storage.'G' ?? '2G',
                'transaction' => rand(20, 500)
            ];
        });
        return response()->json($collection);
    }
}
