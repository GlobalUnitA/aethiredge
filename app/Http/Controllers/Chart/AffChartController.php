<?php

namespace App\Http\Controllers\Chart;

use App\Models\AthUser;
use App\Models\Chart;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AffChartController extends Controller
{
 
    public function __construct()
    {
        
    }
   
    public function index(Request $request)
    {
        $chart = new Chart();
        $chart->mode = 'aff';

        if(Auth::user()->is_admin == 1){
            $chart->is_admin = 1;
            $user_id = 2000011;
        } else {
            $user_id = Auth::user()->id;
        }
        
        $user_id = $request->search ? $request->search : $user_id;
        
        $chart->getChartData($user_id);
       
        return view('chart.chart', ['chartData' => $chart->data]);
      
    }

}
