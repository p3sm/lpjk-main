<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Pemohon;

class HomeController extends Controller
{
    public function index(){
        $data['pemohons'] = Pemohon::take(5)
        ->get();

        return view('home')->with($data);
    }
}
