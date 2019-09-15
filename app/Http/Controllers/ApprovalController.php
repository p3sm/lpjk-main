<?php

namespace App\Http\Controllers;

use App\ApprovalTransaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function report(Request $request)
    {
      $user = Auth::user();
      
      $from = $request->from ? Carbon::createFromFormat("d/m/Y", $request->from) : Carbon::now();
      $to = $request->to ? Carbon::createFromFormat("d/m/Y", $request->to) : Carbon::now();

      if($user->role->id == 1){
        $data['transactions'] = ApprovalTransaction::whereMonth("created_at", ">=", $from->format('m'))
        ->whereMonth("created_at", "<=", $to->format('m'))
        ->orderByDesc("created_at")
        ->get();
      } else {
        $data['transactions'] = ApprovalTransaction::where("created_by", $user->id)
        ->whereMonth("created_at", ">=", $from->format('m'))
        ->whereMonth("created_at", "<=", $to->format('m'))
        ->orderByDesc("created_at")
        ->get();
      }

      $data['from'] = $from;
      $data['to'] = $to;

    	return view('approval/report')->with($data);
    }
}
