<?php

namespace App\Http\Controllers\HomeController;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;
use App\Models\CompanyObjective;
use Illuminate\Http\Request;

class CompanyObjectiveController extends Controller
{

    public function index():JsonResponse
    {
        try {
            $companyObjectives = CompanyObjective::all();
            foreach ($customers as $customer) {
                if ($customer->img != null) {
                    $customer->img = asset("images/companyObjectiveImages/".$customer->img);
                }
            }
            return response()->json([
                'status'=>true,
                'data'=>$companyObjectives
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'companyObjectives not found'
            ], 404);
        }

    }

    public function show($id): JsonResponse
    {
        try {
            $companyObjective = CompanyObjective::find(1);
            if ($customer->img != null) {
                $customer->img = asset("images/companyObjectiveImages/".$customer->img);
            }
            return response()->json([
                'status' => true,
                'data' => $companyObjective
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'companyObjective not found'
            ], 404);
        }
    }

    public function update(Request $request,$id):JsonResponse
    {
        try {
        $validator= Validator::make($request->all(),[
            'ar_title'=>'required|min:5',
            'en_title'=>'required|min:5',
            'ar_description'=>'required|min:5',
            'en_description'=>'required|min:5',
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
            $companyObjective = CompanyObjective::findOrFail(1);
            if ($request->img && $request->img->isValid()) {
                $oldImage = public_path('images/companyObjectiveImages/'.$companyObjective->img);
                $file_name = date('Y-m-d_H-i-s') . "_" . time() . "." . $request->img->extension();
                $request->img->move(public_path('images/companyObjectiveImages'), $file_name);
                $path = "public/images/companyObjectiveImages/$file_name";
                if (file_exists($oldImage)){
                    unlink($oldImage);
                }
            }
            $companyObjective->update([
                'ar_title' => $request->input('ar_title'),
                'en_title' => $request->input('en_title'),
                'ar_description' => $request->input('ar_description'),
                'en_description' => $request->input('en_description'),
                'img' => $file_name,
            ]);
            return response()->json([
                'status'=>true,
                'message'=>"companyObjective updated successfully",
                'data'=>$companyObjective
            ]);
        }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'companyObjective not found'
            ], 404);
        }
    }

    public function store(Request $request){
        try {
            $validator= Validator::make($request->all(),[
                'ar_title'=>'required|min:5',
                'en_title'=>'required|min:5',
                'ar_description'=>'required|min:5',
                'en_description'=>'required|min:5',
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
                    $request->img->move(public_path('images/companyObjectiveImages'), $file_name);
                    $path = "public/images/companyObjectiveImages/$file_name";
                }
                CompanyObjective::create([
                    'ar_title' => $request->input('ar_title'),
                    'en_title' => $request->input('en_title'),
                    'ar_description' => $request->input('ar_description'),
                    'en_description' => $request->input('en_description'),
                    'img' => $file_name,
                ]);
                return response()->json([
                    'status'=>200,
                    'message'=>"companyObjective created successfully"
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
            $companyObjective = CompanyObjective::findOrFail(2);
            $companyObjective->delete();
            return response()->json([
                'status'=>true,
                'message'=>"companyObjective deleted successfully",
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'companyObjective not found'
            ], 404);
        }
   }
}
