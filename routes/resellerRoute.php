<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Reseller\Dashboard;
use App\Http\Controllers\ResellerCustomerController;
use App\Http\Controllers\Reseller\AuthController;
use App\Http\Controllers\User\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reseller\CheckoutController;


Route::get('login', [AuthController::class, 'showLoginForm'])->name('resellerLoginForm');
Route::post('login', [AuthController::class, 'login'])->name('resellerLogin');



Route::get('register',  [AuthController::class, 'showRegisterForm'])->name('resellerRegisterForm');
Route::post('register',  [AuthController::class, 'register'])->name('resellerRegister');

Route::get('logout',  [AuthController::class, 'logout'])->name('reseller.logout');

Route::get('/', [Dashboard::class, 'index'])->name('reseller.dashboard')->middleware('reseller');
Route::get('profile', [Dashboard::class, 'myAccount'])->name('reseller.profile.view')->middleware('reseller');

Route::post('profile/update', [Dashboard::class, 'profileUpdate'])->name('reseller.profileUpdate');
Route::post('address/update', [Dashboard::class, 'addressUpdate'])->name('reseller.addressUpdate');

Route::get('my-customer', [Dashboard::class, 'myCustomer'])->name('reseller.my-customer')->middleware('reseller');

Route::post('change/profile/image/reseller', [Dashboard::class, 'changeProfileImage'])->name('reseller.changeProfileImage');

Route::get('logo-banner', [Dashboard::class, 'logoBanner'])->name('reseller.logo.banner');
Route::post('logo-banner', [Dashboard::class, 'logoBannerUpdate'])->name('reseller.logo-banner');




Route::post('orderConfirm/{resellerCustomer}', [CheckoutController::class, 'orderConfirm'])->name('reseller.orderConfirm')->middleware('reseller');
Route::get('order/{resellerCustomer}', [ResellerCustomerController::class, 'show'])->name('resellerOrder.customer');
Route::get('order/auto/confirm/{resellerCustomer}', [CheckoutController::class, 'orderConfirm'])->name('auto.confirm');
//Route::get('order/history', [CheckoutController::class, 'orderHistory'])->name('reseller.orderHistory');
Route::get('payment/{orderId}', [CheckoutController::class, 'orderPaymentGateway'])->name('resellerOrder.payment');


Route::post('payment/checkout/{orderId}', [CheckoutController::class, 'orderPayment'])->name('resellerOrder.method.payment');
Route::get('checkout/payment/confirm/{orderId}', [CheckoutController::class, 'paymentConfirm'])->name('reseller.paymentConfirm');

Route::get('order/details/{order_id?}', [CheckoutController::class, 'orderDetails'])->name('reseller.orderDetails');


//Route::get('wallet', 'CustomerWalletController@walletHistory')->name('reseller.walletHistory');
Route::get('wallet', [Dashboard::class, 'walletHistory'])->name('reseller.walletHistory');
Route::post('wallet/withdraw/request', [Dashboard::class, 'withdrawRequest'])->name('reseller.withdraw_request');



Route::get('orderList/{status?}', [CheckoutController::class, 'orderHistory'])->name('reseller.orderHistory');

Route::get('order/return/{order}', [CheckoutController::class, 'orderReturn'])->name('reseller.return.req');
Route::post('order/return/{order}', [CheckoutController::class, 'orderReturnStore'])->name('reseller.return.store');


Route::get('order/cancel/{order_id}',  [OrderController::class, 'orderCancelFormReseller'])->name('reseller.orderCancelForm');
Route::post('order/cancel/confirm', [OrderController::class, 'orderCancelReseller'])->name('reseller.orderCancel');



Route::post('resellerCustomer/store', [ResellerCustomerController::class, 'store'])->name('resellerCustomer.store');
//Route::post('reseller/shipping/register', 'User\CheckoutController@ShippingRegister')->name('shippingRegister');

Route::match(array('GET','POST'), 'password/recover/notify', [ForgotPasswordController::class, 'resellerPasswordRecoverNotify'])->name('reseller.password.recover');

Route::get('password/recover', [ForgotPasswordController::class, 'resellerPasswordRecover'])->name('reseller.passwordRecover');
Route::get('password/recover/verify', [ForgotPasswordController::class, 'resellerPasswordRecoverVerify'])->name('reseller.password.recoverVerify');

Route::post('seller/password/recover/update', [ForgotPasswordController::class,'resellerPasswordRecoverUpdate'])->name('reseller.password.recoverUpdate');

