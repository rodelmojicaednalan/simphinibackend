<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash, Image;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Admin\AdminUserRepositoryEloquent as AdminUser;

class UserController extends Controller
{
    protected $adminRepo;

    function __construct(AdminUser $adminRepo)
    {
        $this->adminRepo = $adminRepo;
        $this->middleware(function ($request, $next) {
            $this->authadmin = Auth::user();
            return $next($request);
        });
    }
  
    public function index(Request $request)
    {
        $columns = ['id', 'name', 'email', 'photo', 'created_at'];
        $users = $this->adminRepo->paginate(10, null, null, $columns);
        return response()->json([
            "status" => true,
            "data" => $users,
        ], 200);
    }

    public function store(CreateAdminRequest $request)
    {
        $user = $this->adminRepo->create([
            "name"      => "{$request->firstname} {$request->lastname}",
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            "role_id"   => $request->role,
            "email"     => $request->email,
            "password"  => bcrypt($request->password),
            "username"  => $request->username,
            "photo"     => $request->photo ? $request->photo : "",
        ]);

        return response()->json([
            "status"    => true,
            "message"   => "successfully created",
            "user"      => $user,
        ]);
    }

    public function update(Request $request)
    {
        try {

            $user = $this->authadmin;
            $path = 'uploads/admins';
            $field = $request->file('image');
            $hasfile = $request->hasFile('image');
            $image = fileUpload($path, $field, $hasfile);

            $user->update([
                "name"      => $request->name,
                "password"  => bcrypt($request->password),
                "role_id"   => $request->role_id,
                "photo"     => $image ?? "",
            ]);

            return response()->json([
                "status"    => true,
                "message"   => "successfully updated",
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "status"    => false,
                "message"   => $e->getMessage(),
            ]);

        }
    }

    /**
     * Delete a user via ID
     * 
     * @param int $id
     * 
     * @return response
     */
    public function delete($id)
    {
        try {
            $user = $this->adminRepo->find($id);

            if(!$user){
                return response()->json([
                    "status"    => false,
                    "message"   => "No user found",
                ]);
            }

            // $user->delete();

            return response()->json([
                "status"    => true,
                "message"   => "successfully deleted",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status"    => false,
                "message"   => $e->getMessage()
            ]);
        }
    }
}
