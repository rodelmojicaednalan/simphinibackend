<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Repositories\Admin\ClientRepositoryEloquent as Client;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Client $clientRepo)
    {
        $this->middleware('guest')->except('logout');
        $this->clientRepo = $clientRepo;
    }

    public function login(Request $request)
    {
        $datetimenow = Carbon::now()->format('Y-m-d h:i:s');
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);

        $user = User::where('email', $request['email'])->first();
        if(!$user || !Hash::check($request['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credential is incorrect.']
            ]);
        }

        $client = $this->clientRepo->find($user->client_id);
        Config::set('database.connections.client', array(
            'driver'    => 'mysql',
            'host'      => $client->db_host,
            'database'  => $client->db_name,
            'username'  => $client->db_username,
            'password'  => $client->db_password,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ));
        Artisan::call('migrate', ['--database'=>'client','--path'=>'database/migrations/client']);

        $oauth = DB::table('oauth_access_tokens')->where('user_id', $user->id)
                ->where('expires_at', '>', $datetimenow)
                ->first();

        if(!empty($oauth)){
            $data['token'] = $user->access_token;
        } else {
            $data['token'] = $token = $user->createToken($user->name)->accessToken;
            User::where('id', $user->id)->update(['access_token' => $token]);
        }
        return response()->json($data);
    }
}
