<?php

namespace App\Http\Controllers\HomeController;

use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Validator;
use App\Http\HomeController\Controllers;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;

class CompanyProfilesController extends Controller
{
    public function index():JsonResponse
    {
        try {
            $companyProfiles = CompanyProfile::all();
            foreach ($customers as $customer) {
                if ($customer->img != null) {
                    $customer->img = asset("images/companyProfileImages/".$customer->img);
                }
            }
            return response()->json([
                'status'=>true,
                'data'=>$companyProfiles
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'aboutCompany not found'
            ], 404);
        }

    }
    public function show($id): JsonResponse
    {
        try {
            $companyProfile = CompanyProfile::find(1);
            if ($customer->img != null) {
                $customer->img = asset("images/companyProfileImages/".$customer->img);
            }
            return response()->json([
                'status' => true,
                'data' => $companyProfile
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'aboutCompany not found'
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
                'phone'=>'required|min:5',
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
                $companyProfile = CompanyProfile::findOrFail(1);
                if ($request->img && $request->img->isValid()) {
                    $oldImage = public_path('images/companyProfileImages/'.$companyProfile->img);
                    $file_name = date('Y-m-d_H-i-s') . "_" . time() . "." . $request->img->extension();
                    $request->img->move(public_path('images/companyProfileImages'), $file_name);
                    $path = "public/images/companyProfileImages/$file_name";
                    if (file_exists($oldImage)){
                        unlink($oldImage);
                    }
                }
                $companyProfile->update([
                    'ar_title' => $request->input('ar_title'),
                    'en_title' => $request->input('en_title'),
                    'ar_description' => $request->input('ar_description'),
                    'en_description' => $request->input('en_description'),
                    'phone' => $request->input('phone'),
                    'img' => $file_name,
                ]);
                return response()->json([
                    'status'=>true,
                    'message'=>"aboutCompany updated successfully",
                    'data'=>$companyProfile
                ]);
            }

         } catch (ModelNotFoundException $e) {
             return response()->json([
                 'status' => false,
                 'message' => 'aboutCompany not found'
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
                'phone'=>'required|min:5',
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
                if ($request->img && $request->img->isValid()) {
                    $file_name = date('Y-m-d_H-i-s') . "_" . time() . "." . $request->img->extension();
                    $request->img->move(public_path('images/companyProfileImages'), $file_name);
                    $path = "public/images/companyProfileImages/$file_name";
                }
                companyProfile::create([
                    'ar_title' => $request->input('ar_title'),
                    'en_title' => $request->input('en_title'),
                    'ar_description' => $request->input('ar_description'),
                    'en_description' => $request->input('en_description'),
                    'phone' => $request->input('phone'),
                    'img' => $file_name,

                ]);
                return response()->json([
                    'status'=>200,
                    'message'=>"aboutCompany created successfully"
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
            $companyProfile = CompanyProfile::findOrFail(2);
            $companyProfile->delete();
            return response()->json([
                'status'=>true,
                'message'=>"aboutCompany deleted successfully",
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'aboutCompany not found'
            ], 404);
        }

   }
}
