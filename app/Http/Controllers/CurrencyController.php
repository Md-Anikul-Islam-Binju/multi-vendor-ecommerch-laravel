<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::all();
        return view('admin.currency.currency')->with(compact('currencies'));
    }

    public function store(Request $request)
    {
        $currency = new Currency;
        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->code = $request->code;
        $currency->exchange_rate = $request->exchange_rate;
        $currency->status = ($request->status) ? 1 : 0;
        if($currency->save()){
            Toastr::success('Currency updated successfully');
            return redirect()->route('currency.list');
        }
        else {
            Toastr::error('Something went wrong');
            return redirect()->route('currency.list');
        }
    }

    public function edit($id)
    {
        $currency = Currency::find($id);
        return view('admin.currency.currency_edit', compact('currency'));
    }

    public function update(Request $request)
    {
        $currency = Currency::find($request->id);
        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->code = $request->code;
        $currency->exchange_rate = $request->exchange_rate;
        $currency->status = ($currency->status) ? 1 : 0;
        if($currency->save()){
            Toastr::success('Currency updated successfully');
            return redirect()->route('currency.list');
        }
        else {
            Toastr::success('Currency updated failed');
            return redirect()->route('currency.list');
        }
    }

    public function delete($id)
    {
        $category = Currency::find($id);

        if($category){
            $category->delete();
            $output = [
                'status' => true,
                'msg' => 'Currency deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Currency cannot deleted.'
            ];
        }
        return response()->json($output);
    }

    public function currencyDefaultSet(Request $request){

        $update = Currency::where('id', $request->id)->update(['default' => 1]);

        if($update){
            Currency::where('id', '!=', $request->id)->update(['default' => 0]);
            $output = [
                'status' => true,
                'msg' => 'Currency set default success.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Currency set default failed.'
            ];
        }

        return response()->json($output);
    }

    public function changeCurrency(Request $request){
        $output = [];
        $currency = Currency::where('code', $request->currency_code)->first();
        if($currency){
            if($currency->code == 'BDT'){
                $price = round($request->price * $currency->exchange_rate, 2);
            }elseif($currency->code == 'EUR'){
                $price = round($request->price * $currency->exchange_rate, 2);
            }elseif($currency->code == 'USD'){
                $price = round($request->price * $currency->exchange_rate, 2);
            }else{
                $price = $request->price;
            }

            $output = [
                'status' => true,
                'price' => $currency->symbol.$price
            ];
        }
        return response()->json($output);
    }
}
