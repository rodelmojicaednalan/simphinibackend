<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Jobs\SendWelcomeEmailJob;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\Auth\ApiLoginController;
use App\Repositories\Client\UserRepositoryEloquent as User;
use App\Repositories\Admin\ClientRepositoryEloquent as Client;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct(Client $clientRepo, User $userRepo)
    {
        $this->middleware('guest');
        $this->clientRepo = $clientRepo;
        $this->userRepo = $userRepo;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function register(Request $request)
    {
        $dbdate = date('Yms');
        $arr = explode(' ',trim($request['company_name']));
        $db = $this->clean($arr[0]).$dbdate;
        $dbname = config('simphini.db_prefix').strtolower($db);

        $fullname = $request['first_name'].' '.$request['last_name'];
        $makeRequest = [
            'person_in_charge' => $fullname,
            'company_email' => $request['email'],
            'company_name' => $request['company_name'],
            'payment_method' => '', // $request['payment_method']
            'status' => 'Active',
            'db_host' => config('simphini.db_host'),
            'db_username' => config('simphini.db_username'),
            'db_password' => config('simphini.db_password'),
            'db_name' => $dbname
        ];

        $client = $this->clientRepo->create($makeRequest);
        $user = $this->userRepo->create([
            'name' => $fullname,
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'client_id' => $client->id,
            'role_id' => 1
        ]);

        DB::statement('CREATE DATABASE '.$dbname.';');
        Config::set('database.connections.client', array(
            'driver'    => 'mysql',
            'host'      => $client->db_host,
            'database'  => $dbname,
            'username'  => $client->db_username,
            'password'  => $client->db_password,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ));
        Artisan::call('migrate', ['--database'=>'client','--path'=>'database/migrations/client']);

        $datetimenow = Carbon::now()->format('Y-m-d h:i:s');
        $oauth = DB::table('oauth_access_tokens')->where('user_id', $user->id)
                ->where('expires_at', '>', $datetimenow)
                ->first();

        SendWelcomeEmailJob::dispatch($user)->delay(Carbon::now()->addSeconds(5));

        if(!empty($oauth)){
            $data['token'] = $user->access_token;
        } else {
            $data['token'] = $token = $user->createToken($user->name)->accessToken;
            $this->userRepo->queryTable()
            ->where('id', $user->id)
            ->update(['access_token' => $token]);
        }
        return response()->json($data);
    }

    protected function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

}
