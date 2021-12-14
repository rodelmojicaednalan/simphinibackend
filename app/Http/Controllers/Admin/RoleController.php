<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateRoleRequest;
use App\Models\Admin\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Return list of roles
     * 
     * @return response
     */
    public function index()
    {
        try {
            $roles = Role::orderBy('name')->get(['id','name']);

            return response()->json([
                "status"    => true,
                "message"   => "success",
                "data"      => $roles,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status"    => false,
                "message"   => $e->getMessage(),
                "data"      => [],
            ]);
        }
    }

    /**
     * Create a new role
     * 
     * @param Request
     * 
     * @return response
     */
    public function store(CreateRoleRequest $request)
    {
        try {

            $role = Role::create([
                "name" => name_formatter($request->role),
            ]);
    
            return response()->json([
                "status"    => true,
                "message"   => "successfully created",
                "role"      => $role
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "status"    => false,
                "message"   => $e->getMessage(),
            ]);

        }
    }

}
