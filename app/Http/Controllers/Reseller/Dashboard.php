<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Notification;
use App\Models\PaymentGateway;
use App\Models\ResellerCustomer;
use App\Models\State;
use App\Models\Transaction;
use App\Traits\CreateSlug;
use App\User;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Order;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Vendor;
use App\Models\Reseller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Image;


class Dashboard extends Controller{

    use CreateSlug;

    public function index()
    {
        $user_id = Auth::guard('reseller')->id();
        $data['profile'] = Reseller::find($user_id);
        $data['orders'] = Order::with(['order_details.product:id,title,slug,feature_image'])->where('user_id', $user_id)->orderBy('id', 'desc')->where('payment_method', '!=', 'pending')->take(10)->get();
        return view('reseller.dashboard.dashboard')->with($data);  
    }

    public function logoBanner(){
        return view('reseller.logo');
    }
    public function logoBannerUpdate(Request $request){
        $vendor_id  = Auth::guard('reseller')->id();
        $profile = Reseller::find($vendor_id);
        if ($request->hasFile('logo')) {
            //delete image from folder
            $image_path = public_path('upload/vendors/logo/'. $profile->logo);
            if($profile->logo && file_exists($image_path)){
                unlink($image_path);
            }
            $image = $request->file('logo');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/vendors/logo/'), $new_image_name);

            $profile->logo = $new_image_name;
        }
        if ($request->hasFile('banner')) {
            //delete image from folder
            $image_path = public_path('upload/vendors/banner/'. $profile->banner);
            if($profile->banner && file_exists($image_path)){
                unlink($image_path);
            }
            $image = $request->file('banner');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/vendors/banner/'), $new_image_name);

            $profile->banner = $new_image_name;
        }
        $update = $profile->save();
        if($update){
            Toastr::success('Update success.');
        }else{
            Toastr::success('Update failed.');
        }

        return back();
    }


    public function changeProfileImage(Request $request){
        $this->validate($request, [
            'profileImage' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);

            $user = Reseller::find(Auth::guard('reseller')->id());


        //profile image
        if ($request->hasFile('profileImage')) {
            //delete image from folder
            $getimage_path = public_path('upload/users/'. $user->photo);
            if(file_exists($getimage_path) && $user->photo){
                unlink($getimage_path);
            }
            $image = $request->file('profileImage');
            $new_image_name = $this->uniqueImagePath('resellers', 'photo', $image->getClientOriginalName());


            $image_path = public_path('upload/users/' . $new_image_name);
            $image_resize = Image::make($image);
            $image_resize->resize(150, 150);
            $image_resize->save($image_path);
            $user->photo = $new_image_name;
            $user->save();
            Toastr::success('Your profile image update success.');
            return back();
        }
        Toastr::error('Please select any image');
        return back();
    }


    public function myAccount()
    {
        $user = Auth::guard('reseller')->user();
        //$user = User::find(Auth::id());
        $states = State::where('country_id', config('siteSetting.country'))->where('status', 1)->get();
        $cities = City::where('state_id', $user->region )->where('status', 1)->get();
        $areas = Area::where('city_id', $user->city )->where('status', 1)->get();
        return view('reseller.my-account', compact('user', 'states', 'cities', 'areas'));
    }

    //update user profile
    public function profileUpdate(Request $request){

        $request->validate([
            'shop_name' => 'required',
            'mobile' => ['required','unique:resellers,mobile,'.Auth::guard('reseller')->id()],
            'email' => ['required','email','max:255','unique:resellers,email,'.Auth::guard('reseller')->id()],
        ]);

        $user = Reseller::find(Auth::guard('reseller')->id());
        $user->shop_name = $request->shop_name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->link_address = $request->link_address;

        $update =$user->save();
        if($update){
            Toastr::success('Your profile update successful.');
        }else{
            Toastr::error('Sorry profile can\'t update.');
        }
        return back();
    }

    //update payment address
    public function addressUpdate(Request $request){
        $request->validate([
            'state' => 'required',
            'city' => ['required'],
            'area' => ['required'],
            'address' => ['required'],
        ]);
        $user = Reseller::find(Auth::guard('reseller')->id());
        $user->state = $request->state;
        $user->city = $request->city;
        $user->area = $request->area;
        $user->address= $request->address;
        $update = $user->save();
        if($update){
            Toastr::success('Your address update successful.');
        }else{
            Toastr::error('Sorry address can\'t update.');
        }
        return back();
    }

    public function myCustomer()
    {
        return view('reseller.my-customer', ['myCustomer' => ResellerCustomer::all()->where('reseller_id', Auth::guard('reseller')->id())]);
    }



    public function resellerList(Request $request, $status=''){
        $vendors  = Reseller::with(['allproducts:vendor_id','allorders:vendor_id']);
        if($status){
            $vendors->where('status', $status);
        }
        if(!$status && $request->status && $request->status != 'all'){
            $vendors->where('status', $request->status);
        }if($request->shop_name && $request->shop_name != 'all'){
            $vendors->where('shop_name', 'LIKE', '%'. $request->shop_name .'%');
        }if($request->location && $request->location != 'all'){
            $vendors->where('city', $request->location);
        }

        $vendors  = $vendors->orderBy('id', 'desc')->paginate(20);
        $locations = City::orderBy('name', 'asc')->get();
        return view('admin.reseller.resellers')->with(compact('vendors','locations'));
    }

    public function walletChangeView(Reseller $reseller)
    {

        return view('admin.reseller.wallet', compact('reseller'));
    }

    public function walletChangeUpdate(Request  $request, Reseller  $reseller)
    {

        try {

            $request->validate([
                'amount' => 'required',
                'note' => 'required'
            ]);

            DB::beginTransaction();



            if ($request->input('type')==0){
                $reseller->increment('wallet_balance', $request->input('amount'));
            }elseif ($request->input('type')==1){
                $reseller->decrement('wallet_balance', $request->input('amount'));
            }
            $reseller->save();


            Transaction::create([
                'type' => 'adminUpdate',
                'notes' => $request->input('note'),
                'payment_method' => 'wallet-balance',
                'reseller_id' => $reseller->id,
                'amount' => $request->input('amount'),
                'status' => 'paid',
                'created_by' => Auth::id()
            ]);
            DB::commit();
            Toastr::success("Operation Success");
        }catch (\Exception $exception){
            DB::rollBack();
            Toastr::error("failed ".$exception->getMessage());
        }

        return back();
    }

    public function resellerSecretLogin($id)
    {
        $user = Reseller::findOrFail(decrypt($id));
        auth()->guard('reseller')->login($user, true);
        Toastr::success('Reseller panel login success.');
        return redirect()->route('reseller.dashboard');

    }

    public function resellerProfile(Reseller $reseller){
         $reseller = Reseller::where('id', $reseller->id)->with('orders', function ($q){$q->where('user_type',2);})->first();
        return view('admin.reseller.resellerProfile')->with(compact('reseller'));
    }
 


    public function vendor_commission(){
        $commission = SiteSetting::where('type', 'vendor_commission')->get()->toArray();
        return view('admin.vendor.commission')->with(compact('commission'));
    }
    public function vendorCommissionUpdate(Request $request){
        SiteSetting::where('type', 'vendor_commission')->update(['value' => $request->seller_commission]);
        Toastr::success('Commission update success');
        return back();
    }

    public function sellerSecretLogin($id)
    {
        $seller = Reseller::findOrFail(decrypt($id));
        auth()->guard('reseller')->login($seller, true);
        Toastr::success('Seller panel login success');
        return redirect()->route('vendor.dashboard');
    }

    public function delete($id){
        $user = Reseller::find($id);
        if($user){
            $user->delete();
            $output = [
                'status' => true,
                'msg' => 'User deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'User cannot deleted.'
            ];
        }
        return response()->json($output);
    }

    public function walletHistory(Request $request){
        //$customer_id = Auth::id();
        $reseller_id = Auth::guard('reseller')->id();
        $wallets = Transaction::with(['reseller:id,shop_name,username,mobile', 'paymentGateway'])
            ->where('reseller_id', $reseller_id)
            ->whereIn('type', ['wallet', 'withdraw', 'returnCharge', 'adminUpdate']);
        if($request->withdraw && $request->withdraw != 'all'){
            $wallets->where('transactions.status', $request->withdraw);
        }
        $data['wallets'] =   $wallets->orderBy('id', 'desc')->get();
        $data['paymentGateways'] = PaymentGateway::where('method_for', 'payment')->where('status', 1)->get();
        $data['withdraw_configure'] = SiteSetting::where('type', 'customer_withdraw_configure')->first();
        return view('reseller.wallet.wallet')->with($data);
    }

    public function withdrawRequest(Request $request){
        $withdraw = SiteSetting::where('type', 'customer_withdraw_configure')->where('status', 1)->first();
        //check withdraw request active or deactivate
        if(!$withdraw){
            return redirect()->back();
        }
        $request->validate([
            'payment_method' => ['required'],
            'amount' => ['required'],
            'account_no' => ['required'],
            'password' => ['required'],
        ]);
        // if occur error open model
        Session::put('submitType', 'withdraw_request');
        $customer_id = Auth::guard('reseller')->id();
        $amount = $request->amount;
        $user = Reseller::where('id', $customer_id)->first();
        if($user && Hash::check($request->password, $user->password)) {
            //Minimum withdrawal amount
            $withdrawalConfig = SiteSetting::where('type', 'customer_withdraw_configure')->first();

            if($amount < $withdrawalConfig->value2){
                $msg = 'Minimum withdrawal amount '. Config::get('siteSetting.currency_symble') . $withdrawalConfig->value2;
                Toastr::error($msg);
            }
            elseif($request->amount > $user->wallet_balance){
                $msg = 'Insufficient Your Wallet Balance.';
                Toastr::error($msg);
            }
            else {

                //minus customer balance
                $user->wallet_balance = $user->wallet_balance - $request->amount;
                $user->save();
                //calculate commission
                //$commission = ($withdrawalConfig->value > 0) ? round(($amount * $withdrawalConfig->value)/100, 2) : 0;
                //minus commission

                $invoice_id = 'W'.Auth::guard('reseller')->id() . strtoupper(substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), -6));
                //insert transaction
                $withdraw = new Transaction();
                $withdraw->type = 'withdraw';
                $withdraw->payment_method = $request->payment_method;
                $withdraw->reseller_id = $customer_id;
                $withdraw->item_id = $invoice_id;
                $withdraw->amount = $amount;
                $withdraw->commission = 0;
                $withdraw->account_no = $request->account_no;
                $withdraw->notes = $request->notes;
                $withdraw->status = 'pending';
                $withdraw->save();

                //insert notification in database
                Notification::create([
                    'type' => 'withdraw',
                    'fromUser' => $customer_id,
                    'toUser' => null,
                    'item_id' => $withdraw->id,
                    'notify' => 'withdraw request',
                ]);
                $msg = 'Withdrawal request successfully submitted.';
                Toastr::success($msg);
                return redirect()->back()->with('success', $msg);
            }
        }else{
            $msg = 'Sorry invalid password.!.';
            Toastr::error($msg);
        }
        return redirect()->back()->withInput()->with('error', $msg);

    }

}
