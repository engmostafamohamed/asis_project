<?php

namespace App\Http\Controllers\HomeController;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index():JsonResponse
    {
        try {
            $sliders = Slider::all();
            return response()->json([
                'status'=>true,
                'data'=>$sliders
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Slider not found'
            ], 404);
        }

   }
   public function show($id): JsonResponse
   {
       try {
           $slider = Slider::find(1);

           return response()->json([
               'status' => true,
               'data' => $slider
           ]);
       } catch (ModelNotFoundException $e) {
           return response()->json([
               'status' => false,
               'message' => 'Slider not found'
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
                'en_subtitle'=>'required|min:5'
            ]);
            if ($validator->fails()) {
                $error=$validator->errors()->all()[0];
                return response()->json([
                    'status'=>'false',
                    'message'=>$error,
                    'data'=>[]
                ],422);
            }else{
                $slider = Slider::findOrFail(1);
                $slider->update([
                    'ar_title' => $request->input('ar_title'),
                    'en_title' => $request->input('en_title'),
                    'ar_subtitle' => $request->input('ar_subtitle'),
                    'en_subtitle' => $request->input('en_subtitle'),
                ]);
                return response()->json([
                    'status'=>true,
                    'message'=>"slider updated successfully",
                    'data'=>$slider
                ]);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Slider not found'
            ], 404);
        }
   }
   public function store(Request $request):JsonResponse
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
        }else {
            Slider::create([
                'ar_title' => $request->input('ar_title'),
                'en_title' => $request->input('en_title'),
                'ar_subtitle' => $request->input('ar_subtitle'),
                'en_subtitle' => $request->input('en_subtitle'),
            ]);
            return response()->json([
                'status'=>200,
                'message'=>"slider created successfully"
            ]);
        }

    } catch (ModelNotFoundException $e) {
        return response()->json([
            'status' => false,
            'message' => 'error happened'
        ], 500);
    }
   }
   public function delete(Request $request, $id):JsonResponse
   {
        try {
            $slider = Slider::findOrFail(8);
            $slider->delete();
            return response()->json([
                'status'=>true,
                'message'=>"slider deleted successfully",
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'slider not found'
            ], 404);
        }
   }
}
