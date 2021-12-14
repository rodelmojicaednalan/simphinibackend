<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Image;

class ProfileController extends Controller
{
    /**
     * Update user profile
     * 
     * @param Request
     * 
     * @return response
     */
    public function update(ProfileUpdateRequest $request)
    {
        $admin = Auth::user();
        if(!$admin){
            return response()->jsons([
                "status" => false,
                "message" => "Not authenticated"
            ]);
        }

        $image = null;
        if($request->has('image')){
            $image = $request->file('image');
            $filename = time()."_".$image->getClientOriginalExtension();
            Image::make($image)->save(public_path()."/uploads/admin/{$filename}");
            $image = url("uploads/{$filename}");
        }

        $admin->update([
            "firstname" => $request->firstname,
            'lastname'  => $request->lastname,
            'email'     => $request->email,
            'photo'     => $image ? $image : $admin->photo,
        ]);

        return response()->json([
            'status'    => true,
            'request'   => $request->all(),
            'user' => $admin,
        ]);
    }
}
