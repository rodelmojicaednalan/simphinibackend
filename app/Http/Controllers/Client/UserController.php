<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Client\UserRepositoryEloquent as User;

class UserController extends Controller
{
    protected $userRepo;

    function __construct(User $userRepo)
    {
        $this->userRepo = $userRepo;
        $this->middleware(function ($request, $next) {
            $this->authuser = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $client_id = $this->authuser->client_id;
        $users = $this->userRepo->rawAll('client_id', [$client_id]);
        $data['users'] = [];
        foreach ($users as $user) {
            $data['users'][] = [
                'avatar' => $user->display_photo,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ];
        }
        return response()->json($data);
    }
}
