<?php

namespace App\Http\Controllers;

use App\Models\Todolist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response=Todolist::all();
        if ($response->count()>0){
            return response()->json(
                [
                    'status'=>true,
                    'message'=>'your Todolist',
                    'data'=>$response
                ],
                );
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'page not found',

            ],
            404,
        );

        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'activity'=>'required',
            'description'=>'required',
            'deadline'=>'required',
            'taskStatus'=>'required'
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $data = Todolist::create([
            'activity'=>$request->activity,
            'description'=>$request->description,
            'deadline'=>$request->deadline,
            'taskStatus'=>$request->taskStatus
        ]);
        if ($data) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Created',
                    'data' => $data,
                ],
                202,
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data is Not Created',
                ],
                500,
            );
        }
    
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data=Todolist::where('id',$id)
        ->orWhere('activity','like','%'.$id.'%')
        ->get();

        if($data->count()>0){
            return response ()->json([
                'status'=>true,
                'message'=> 'data showed',
                'data'=>$data
            ],
            200,
        );
    
        }else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'data not found',
                ],
                404,
            );
        }
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator=Validator::make($request->all(),[
            'taskStatus'=>'required'
        ]);

        
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $data=Todolist::find($id);
        // return dd($data);

        $data->taskStatus=$request->taskStatus;
        $data->save();
        if ($data) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Updated',
                    'data' => $data,
                ],
                202,
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data Not Updated',
                ],
                500,
            );
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Todolist::where('id', $id)->delete();
        if ($data) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Deleted',
                ],
                202,
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data Not Deleted',
                ],
                500,
            );
        }
    }

    public function change (Request $request, string $id)
    {

        $validator=Validator::make($request->all(),[
            'activity'=>'required',
            'description'=>'required',
            'deadline'=>'required',
            'taskStatus'=>'required'
        ]);

        
        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $data=Todolist::find($id);
        // return dd($data);

        $data->deadline=$request->deadline;
        $data->activity=$request->activity;
        $data->description=$request->description;
        $data->taskStatus=$request->taskStatus;
        $data->save();
        if ($data) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Updated',
                    'data' => $data,
                ],
                202,
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data Not Updated',
                ],
                500,
            );
        }
    }
}
