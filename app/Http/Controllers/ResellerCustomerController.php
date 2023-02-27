<?php

namespace App\Http\Controllers;

use App\Models\ResellerCustomer;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\ShippingAddress;
use App\Models\ShippingMethod;
use App\Models\State;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class ResellerCustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('reseller');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'nullable',
            'region' => 'required',
            'city' => 'required',
            'area' => 'required',
            'address' => 'required'
        ]);

        $attributes['reseller_id'] = Auth::guard('reseller')->id();

        $rc = new ResellerCustomer();
        $rc->reseller_id = Auth::guard('reseller')->id();
        $rc->name = $request->input('name');
        $rc->mobile = $request->input('mobile');
        $rc->email = $request->input('email');
        $rc->region = $request->input('region');
        $rc->city = $request->input('city');
        $rc->area = $request->input('area');
        $rc->address = $request->input('address');



        if($rc->save()){
            $last_id = $rc->id;

            return redirect()->route('auto.confirm', $last_id);
        }else{
            Toastr::error("failed to process");
            return back();
        }
        


        
    }

    /**
     * Display the specified resource.
     *
     * @param ResellerCustomer $resellerCustomer
     * @return Application|Factory|View
     */
    public function show(ResellerCustomer $resellerCustomer)
    {
        $user_id = 0;
        if (Auth::check()) {
            $user_id = Auth::id();
        } else {
            $user_id = (Cookie::has('user_id') ? Cookie::get('user_id') :  Session::get('user_id'));
        }
        $data = [];
        $cartItems = Cart::with('get_product:id,selling_price,shipping_cost,discount,discount_type')->where('user_id', $user_id);
        //check direct checkout
        if (Cookie::has('direct_checkout_product_id') || Session::get('direct_checkout_product_id')) {
            $direct_checkout_product_id = (Cookie::has('direct_checkout_product_id') ? Cookie::get('direct_checkout_product_id') :  Session::get('direct_checkout_product_id'));
            $cartItems = $cartItems->where('product_id', $direct_checkout_product_id);
        }
        $data['cartItems'] =  $cartItems->orderBy('id', 'desc')->get();

        if (count($data['cartItems']) > 0) {
            return view('reseller.order', compact('resellerCustomer'))->with($data);
        } else {
            Toastr::error("Your shopping cart is empty. You don\'t have any product to checkout.");
            return redirect('/');
        }
    }





























    /**
     * Show the form for editing the specified resource.
     *
     * @param ResellerCustomer $resellerCustomer
     * @return Response
     */
    public function edit(ResellerCustomer $resellerCustomer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ResellerCustomer $resellerCustomer
     * @return Response
     */
    public function update(Request $request, ResellerCustomer $resellerCustomer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ResellerCustomer $resellerCustomer
     * @return Response
     */
    public function destroy(ResellerCustomer $resellerCustomer)
    {
        //
    }
}
