<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ReturnRequest;
use App\Models\Transaction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ReturnRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $requestList = ReturnRequest::all();
        return view('admin.order.return-reason', compact('requestList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param ReturnRequest $returnRequest
     * @return Response
     */
    public function show(ReturnRequest $returnRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ReturnRequest $returnRequest
     * @return Application|Factory|View
     */
    public function edit(ReturnRequest $returnRequest)
    {

        return \view('admin.order.return-reason-edit', compact('returnRequest'));
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ReturnRequest $returnRequest
     * @return RedirectResponse
     */
    public function update(Request $request, ReturnRequest $returnRequest): RedirectResponse
    {
        $returnRequest->status = 0;
        $returnRequest->save();
        //try to find reseller
        $orderId = $returnRequest->order_id;

        $order = Order::where('id', $orderId)->first();
        if ($order->user_type==2){
            $resellerOrder = Order::with('reseller')->where('id', $orderId)->first();
            $resellerOrder->reseller->decrement('wallet_balance', $request->input('amount'));
            $resellerOrder->reseller->save();
        }else{
            $customerOrder = Order::with('customer')->where('id', $orderId)->first();
            $customerOrder->customer->decrement('wallet_balance', $request->input('amount'));
            $customerOrder->save();
        }

        $order->order_status = 'return';
        $order->save();


        Transaction::create([
            'type' => 'returnCharge',
            'notes' => 'Reduce balance for product return',
            'payment_method' => 'wallet-balance',
            'reseller_id' => $order->user_id,
            'amount' => $request->input('amount'),
            'status' => 'paid',
            'created_by' => Auth::id()
        ]);






        \Toastr::success("Balance reduce success");
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReturnRequest $returnRequest
     * @return Response
     */
    public function destroy(ReturnRequest $returnRequest)
    {
        //
    }
}
