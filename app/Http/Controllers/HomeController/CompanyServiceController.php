<?php

namespace App\Http\Controllers\HomeController;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;
use App\Http\HomeController\Controllers;
use App\Models\CompanyService;
use Illuminate\Http\Request;


class CompanyServiceController extends Controller
{
    public function index():JsonResponse
    {
        try {
            $companyServices = CompanyService::all();
            foreach ($customers as $customer) {
                if ($customer->img != null) {
                    $customer->img = asset("images/companyServiceImages/".$customer->img);
                }
            }
            return response()->json([
                'status'=>true,
                'data'=>$companyServices
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'companyServices not found'
            ], 404);
        }

    }
    public function show($id): JsonResponse
    {
        try {
            $companyService = CompanyService::find(1);
            if ($customer->img != null) {
                $customer->img = asset("images/companyServiceImages/".$customer->img);
            }
            return response()->json([
                'status' => true,
                'data' => $companyService
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'companyService not found'
            ], 404);
        }
    }

    public function update(Request $request,$id):JsonResponse
    {
         try {
            $validator= Validator::make($request->all(),[
                'ar_title'=>'required|min:5',
                'en_title'=>'required|min:5',
                'ar_subtitle'=>'required|min:5',
                'en_subtitle'=>'required|min:5',
            ]);
            if ($validator->fails()) {
                $error=$validator->errors()->all()[0];
                return response()->json([
                    'status'=>'false',
                    'message'=>$error,
                    'data'=>[]
                ],422);
            }else{
                $companyService = CompanyService::findOrFail(1);
                $companyService->update([
                    'ar_title' => $request->input('ar_title'),
                    'en_title' => $request->input('en_title'),
                    'ar_subtitle' => $request->input('ar_subtitle'),
                    'en_subtitle' => $request->input('en_subtitle'),
                ]);
                return response()->json([
                    'status'=>true,
                    'message'=>"companyService updated successfully",
                    'data'=>$companyService
                ]);
            }
         } catch (ModelNotFoundException $e) {
             return response()->json([
                 'status' => false,
                 'message' => 'CompanyService not found'
             ], 404);
         }
    }

    public function store(Request $request){
        try {
            $validator= Validator::make($request->all(),[
                'ar_title'=>'required|min:5',
                'en_title'=>'required|min:5',
                'ar_subtitle'=>'required|min:5',
                'en_subtitle'=>'required|min:5',
            ]);
            if ($validator->fails()) {
                $error=$validator->errors()->all()[0];
                return response()->json([
                    'status'=>'false',
                    'message'=>$error,
                    'data'=>[]
                ],422);
            }else{
                CompanyService::create([
                    'ar_title' => $request->input('ar_title'),
                    'en_title' => $request->input('en_title'),
                    'ar_subtitle' => $request->input('ar_subtitle'),
                    'en_subtitle' => $request->input('en_subtitle')
                ]);
                return response()->json([
                    'status'=>200,
                    'message'=>"companyService created successfully"
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
            $companyService = CompanyService::findOrFail(2);
            $companyService->delete();
            return response()->json([
                'status'=>true,
                'message'=>"companyService deleted successfully",
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'companyService not found'
            ], 404);
        }

   }
}
