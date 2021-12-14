<?php

namespace App\Http\Controllers\Picklists;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Admin\Picklists\TreatmentRepositoryEloquent as Repository;

class TreatmentController extends Controller
{
    protected $repository;

    public function __construct (Repository $repository)
    {
        $this->repository = $repository;
    }

    public function index () 
    {
        $output['data'] = $this->repository->all('name', 'asc', ['id', 'name', 'description', 'status']);
        $output['status'] = 200; // OK
        return response()->json($output);
    }

    public function store (Request $request) 
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'description' => 'required',
            'status' => 'required'
        ], 
        [
            'name.required' => 'Treatment name is a required.',
            'description.required' => 'Treatment description is a required.',
            'status.required' => 'Status is a required.',
        ]);
        if (!$validation->fails()) {
            $this->repository->create($request->all());
            $output['message'] = $request->input('name').' has been successfully saved in Treatment Picklists';
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
            'description' => 'required',
            'status' => 'required'
        ], 
        [
            'name.required' => 'Treatment name is a required.',
            'description.required' => 'Treatment description is a required.',
            'status.required' => 'Status is a required.',
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

            $output['message'] = $request->input('name').' has been successfully saved in Treatment Picklists';
            $output['status'] = 200; // Ok
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
