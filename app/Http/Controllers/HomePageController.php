<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{
    public function fetchData():JsonResponse
    {
        $result = [];
        $result['heroSection'] = DB::table('sliders')->select('id','ar_title', 'en_title', 'ar_subtitle', 'en_subtitle')->find(1);
        $result['servicesSection'] = DB::table('company_services')->select('id','ar_title', 'en_title','ar_subtitle','en_subtitle')->take(3)->get();
        $result['aboutSection'] = DB::table('company_profiles')->select('id','ar_title', 'en_title','ar_description','en_description','phone','img')->find(1);
        if ($result['aboutSection']->img != null) {
            $result['aboutSection']->img = asset("images/companyProfileImages/".$result['aboutSection']->img);
        }
        $result['customers'] = DB::table('customers')->select('id','ar_name', 'en_name','img')->take(3)->get();

        foreach ($result['customers']  as $customer) {
            if ($customer->img != null) {
                $customer->img = asset("images/customerImages/".$customer->img);
            }
        }

        $result['projects'] = DB::table('company_objectives')->select('id','ar_title', 'en_title','ar_description','en_description','img')->take(3)->get();
        foreach ($result['projects']as $project) {
            if ($project->img != null) {
                $project->img = asset("images/companyObjectiveImages/".$project->img);
            }
        }
        return response()->json($result);
    }
}
