<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class CompareController extends Controller
{
    public function compare()
    {
        $compare = Session::has('compare') ? Session::get('compare') : [];
        $products = Product::whereIn('id', array_keys($compare))->get();
        return view('users.compare')->with(compact('products'));
    }
    public function addToCompare($product_id){

        //check weather compare array have product or empty
        $compare = Session::has('compare') ? Session::get('compare') : [];
        //check product id already exists
        if (!array_key_exists($product_id, $compare)) {
            $compare[$product_id] = [
                'product_id' => $product_id,
            ];
            session(['compare' => $compare]);

            $output = array(
                'status' => 'success',
                'msg' => 'Product Added To Compare'
            );
        }else{
            $output = array(
                'status' => 'success',
                'msg' => 'Already Added To Compare !!'
            );
        }

        return response()->json($output);
    }

    //remove product
    public function remove($product_id)
    {
        $compare = Session::has('compare') ? Session::get('compare') : [];
        if($compare){
            unset($compare[$product_id]);
            session(['compare' => $compare]);
            $output = array(
                'status' => 'success',
                'msg' => 'Product Remove From Compare'
            );
        }else{
            $output = array(
                'status' => false,
                'msg' => 'Product con\'t remove from compare.'
            );
        }
        return response()->json($output);
    }
}
