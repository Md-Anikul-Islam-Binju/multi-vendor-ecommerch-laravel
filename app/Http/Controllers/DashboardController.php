<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(){
        $data= [];
        $data['products'] = Product::count();
        return $data;
        return view('admin.dashboard')->with($data);

    }


}
