<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CartButton;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CartButtonController extends Controller
{
    use createSlug;
    //Cart button lists
    public function index()
    {
        $cartButtons = CartButton::orderBy('position', 'asc')->get();
        return view('admin.product.cartButton.cartButton')->with(compact('cartButtons'));
    }

    //insert Cart button
    public function store(Request $request)
    {
        $cartBtn = new CartButton();
        $cartBtn->btn_name = $request->btn_name;
        $cartBtn->slug = $this->createSlug('cart_buttons', $request->btn_name);
        $cartBtn->status = ($request->status) ? 1 : 0;
        $store = $cartBtn->save();
        Toastr::success('Cart Button Insert Success.');
        return back();
    }

    //edit Cart button
    public function edit($id)
    {
        $data = CartButton::find($id);
        echo view('admin.product.cartButton.cartButtonEdit')->with(compact('data'));
    }
    //update data
    public function update(Request $request)
    {
        $cartBtn = CartButton::find($request->id);
        $cartBtn->btn_name = $request->btn_name;
        $cartBtn->status = ($request->status) ? 1 : 0;
        $store = $cartBtn->save();
        Toastr::success('Cart Button update Success.');
        return back();

    }

    //delate cart button
    public function delete($id)
    {
        $delate = CartButton::where('id', $id)->where('is_default' == null)->delete();

        if($delate){
            $output = [
                'status' => true,
                'msg' => 'Cart button deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Cart button cannot deleted.'
            ];
        }
        return response()->json($output);
    }
}
