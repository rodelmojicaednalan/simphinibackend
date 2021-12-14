<?php

namespace App\Http\Controllers\Picklists;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Admin\Picklists\CountryRepositoryEloquent as Repository;

class CountryController extends Controller
{
    protected $repository;

    public function __construct (Repository $repository)
    {
        $this->repository = $repository;
    }

    public function index () 
    {
        $output['data'] = $this->repository->all('name', 'asc', ['id', 'name', 'code', 'nationality']);
        $output['status'] = 200; // OK
        return response()->json($output);
    }

    public function store (Request $request) 
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'code' => 'required|min:2|max:3',
            'nationality' => 'required|min:3|max:255'
        ], 
        [
            'name.required' => 'Country name is a required field.',
            'name.min' => 'Country name must be more than 3 characters.',
            'name.max' => 'Country name must be less than 255 characters.',
            'code.required' => 'Country code is a required field.',
            'code.min' => 'Country code must be more than 2 characters.',
            'code.max' => 'Country code must be less than 3 characters.',
            'nationality.required' => 'Nationality is a required field.',
            'nationality.min' => 'Nationality must be more than 2 characters.',
            'nationality.max' => 'Nationality must be less than 3 characters.',
        ]);
        if (!$validation->fails()) {
            $this->repository->create($request->all());
            $output['message'] = $request->input('name').' has been successfully saved in Country Picklists';
            $output['status'] = 200; // Ok
        } else {
            $output['errors'] = $validation->errors();
            $output['status'] = 412; // Precondition Failed
        }
        return response()->json($output);
    }

    public function edit ($hashedId) 
    {
        $id = app('App\Http\Controllers\ComponentController')->decodeHashid($hashedId);
        $data = $this->repository->findOnly($id);
        if ($data) {
            $output['data'] = $data;
            $output['status'] = 200;
        } else {
            $output['status'] = 404;
        }
        return response()->json($output);
    }

    public function update ($hashedId, Request $request) 
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'code' => 'required|min:2|max:3',
            'nationality' => 'required|min:3|max:255'
        ], 
        [
            'name.required' => 'Country name is a required field.',
            'name.min' => 'Country name must be more than 3 characters.',
            'name.max' => 'Country name must be less than 255 characters.',
            'code.required' => 'Country code is a required field.',
            'code.min' => 'Country code must be more than 2 characters.',
            'code.max' => 'Country code must be less than 3 characters.',
            'nationality.required' => 'Nationality is a required field.',
            'nationality.min' => 'Nationality must be more than 2 characters.',
            'nationality.max' => 'Nationality must be less than 3 characters.',
        ]);
        if (!$validation->fails()) {

            $id = app('App\Http\Controllers\ComponentController')->decodeHashid($hashedId);
            if ($this->repository->findOnly($id)) {
                $makeRequest = [
                    'name' => $request['name'],
                    'code' => $request['code'],
                    'nationality' => $request['nationality']
                ];
                $this->repository->update($makeRequest, $id);

                $output['message'] = $request->input('name').' has been successfully updated';
                $output['status'] = 200;
            } else {
                $output['status'] = 404;
            }
        } else {
            $output['errors'] = $validation->errors();
            $output['status'] = 412; // Precondition Failed
        }
        return response()->json($output);
    }

    public function delete ($hashedId) 
    {
        $id = app('App\Http\Controllers\ComponentController')->decodeHashid($hashedId);
        $this->repository->delete($id);
        $output['status'] = 200;
        $output['message'] = 'Record has been successfully deleted';
        return response()->json($output);
    }
}
