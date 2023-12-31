<?php

namespace App\Http\Controllers\HomeController;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;
use App\Http\HomeController\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index():JsonResponse
    {
        try {
            $customers = Customer::all();
            foreach ($customers as $customer) {
                if ($customer->img != null) {
                    $customer->img = asset("images/customerImages/".$customer->img);
                }
            }
            return response()->json([
                'status'=>true,
                'data'=>$customers
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'customers not found'
            ], 404);
        }

    }
    public function show($id): JsonResponse
    {
        try {
            $customer = Customer::find(1);
            if ($customer->img != null) {
                $customer->img = asset("images/customerImages/".$customer->img);
            }
            return response()->json([
                'status' => true,
                'data' => $customer
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'customer not found'
            ], 404);
        }
    }
    public function update(Request $request,$id):JsonResponse
    {
        try {
            $validator= Validator::make($request->all(),[
                'ar_name'=>'required|min:5',
                'en_name'=>'required|min:5',
                'img'=>'nullable|image'
            ]);
            if ($validator->fails()) {
                $error=$validator->errors()->all()[0];
                return response()->json([
                    'status'=>'false',
                    'message'=>$error,
                    'data'=>[]
                ],422);
            }else{
                $customer = Customer::findOrFail(1);
                if ($request->img && $request->img->isValid()) {
                    $oldImage = public_path('images/customerImages/'.$customer->img);
                    $file_name = date('Y-m-d_H-i-s') . "_" . time() . "." . $request->img->extension();
                    $request->img->move(public_path('images/customerImages'), $file_name);
                    $path = "public/images/customerImages/$file_name";
                    if (file_exists($oldImage)){
                        unlink($oldImage);
                    }
                }
                $customer->update([
                'ar_name' => $request->input('ar_name'),
                'en_name' => $request->input('en_name'),
                'img' => $file_name,
                ]);
                return response()->json([
                    'status'=>true,
                    'message'=>"customer updated successfully",
                    'data'=>$customer
                ]);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'customer not found'
            ], 404);
        }
    }
    public function store(Request $request){
        try {
            $validator= Validator::make($request->all(),[
                'ar_name'=>'required|min:5',
                'en_name'=>'required|min:5',
                'img'=>'nullable|image'
            ]);
            if ($validator->fails()) {
                $error=$validator->errors()->all()[0];
                return response()->json([
                    'status'=>'false',
                    'message'=>$error,
                    'data'=>[]
                ],422);
            }else {
                if ($request->img && $request->img->isValid()) {
                    $file_name = date('Y-m-d_H-i-s') . "_" . time() . "." . $request->img->extension();
                    $request->img->move(public_path('images/customerImages'), $file_name);
                    $path = "public/images/customerImages/$file_name";
                }
                Customer::create([
                    'ar_name' => $request->input('ar_name'),
                    'en_name' => $request->input('en_name'),
                    'img' => $file_name,
                ]);
                return response()->json([
                    'status'=>200,
                    'message'=>"customer created successfully"
                ]);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'error happened'
            ], 404);
        }
    }
    public function delete(Request $request, $id):JsonResponse
   {
        try {
            $customer = Customer::findOrFail(2);
            $customer->delete();
            return response()->json([
                'status'=>true,
                'message'=>"customer deleted successfully",
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'customer not found'
            ], 404);
        }
   }
}
