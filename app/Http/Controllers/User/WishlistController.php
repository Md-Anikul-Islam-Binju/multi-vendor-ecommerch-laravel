<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    //display wishlist
    public function index()
    {
        $wishlists = Wishlist::with('get_product:id,title,slug,selling_price,discount,stock,feature_image')->where('user_id', Auth::id())->paginate(15);

        return view('users.wishlist', compact('wishlists'));
    }

    //insert wishlist
    public function store(Request $request)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->where('product_id', $request->product_id)->first();
        if(!$wishlist){
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'date' => now(),
            ]);

            $output = array(
                'status' => 'success',
                'msg' => 'Product Added To Wishlist.'
            );
        }else{
            $output = array(
                'status' => 'error',
                'msg' => 'Already Added To Wishlist !!'
            );
        }
        return response()->json($output);
    }

    //remove product
    public function remove($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->where('id', $id)->first();
        if($wishlist){
            $wishlist->delete();
            $output = array(
                'status' => 'success',
                'msg' => 'Product Remove From Wishlist !!'
            );
        }else{
            $output = array(
                'status' => 'error',
                'msg' => 'Product con\'t remove from wishlist.'
            );
        }
        return response()->json($output);
    }


}
