<?php

use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\CustomerWalletController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;




Route::get('login', 'User\UserLoginController@LoginForm')->name('LoginForm');
Route::post('user/login', 'User\UserLoginController@login')->name('userLogin');
Route::get('register', 'User\UserRegController@RegisterForm')->name('userRegisterForm');
Route::post('user/register', 'User\UserRegController@register')->name('userRegister');
Route::get('user/logout', 'User\UserLoginController@logout')->name('userLogout');


Route::get('resend/account/verify', 'User\UserRegController@resendVerifyToken')->name('resendVerifyToken');
Route::get('account/verify', 'User\UserRegController@userAccountVerify')->name('userAccountVerify');

//reset for
Route::get('password/recover', 'Auth\ForgotPasswordController@passwordRecover')->name('password.form.recover');
//forgot password notify send
Route::match(array('GET', 'POST'), 'password/recover/notify', 'Auth\ForgotPasswordController@passwordRecoverNotify')->name('password.recover');
//verify token or otp
Route::get('password/recover/verify', 'Auth\ForgotPasswordController@passwordRecoverVerify')->name('password.recoverVerify');
//passord update
Route::post('password/recover/update', 'Auth\ForgotPasswordController@passwordRecoverUpdate')->name('password.recoverUpdate');


Route::get('checkout/get/city/{state_id?}', 'User\CheckoutController@get_city')->name('checkout.get_city');
Route::post('user/shipping/register', 'User\CheckoutController@ShippingRegister')->name('shippingRegister');
// get shipping address by shipping id
Route::get('get/shipping/address/{shipping_id}', [CheckoutController::class, 'getShippingAddress'])->name('getShippingAddress');

Route::get('addto/compare/{product_id}', 'User\CompareController@addToCompare')->name('addToCompare');
Route::get('compare/product', 'User\CompareController@compare')->name('productCompare');
Route::get('compare/product/remove/{product_id}', 'User\CompareController@remove')->name('productCompareRemove');

route::group(['middleware' => ['auth']], function () {

	//return routes
	Route::get('order/return/{order_id}/{product_slug}', 'RefundController@orderReturn')->name('user.orderReturn');
	Route::post('order/return/request/send', 'RefundController@sendReturnRequest')->name('user.sendReturn_request');
	Route::get('order/return/requests', 'RefundController@userReturnRequestList')->name('user.return_request');

	//product review
	route::get('product/review/form', 'ReviewController@getReviewForm')->name('getReviewForm');
	Route::post('product/review/insert', 'ReviewController@reviewInsert')->name('review.insert');



	route::group(['namespace' => 'User'], function () {
		//user account
		Route::get('dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');


		Route::get('user/profile', [UserController::class, 'myAccount'])->name('user.myAccount');

		Route::post('user/profile/update', [UserController::class, 'profileUpdate'])->name('user.profileUpdate');
		Route::post('user/address/update', [UserController::class,'addressUpdate'])->name('user.addressUpdate');

		Route::get('user/change-password', 'UserController@changePasswordForm')->name('user.change.password');
		Route::post('user/change-password', 'UserController@changePassword')->name('user.change-password');
		//profile image change for all user
		//Route::post('change/profile/image', 'UserController@changeProfileImage')->name('changeProfileImage');
		Route::post('change/profile/image', [UserController::class, 'changeProfileImage'])->name('changeProfileImage');

		Route::match(['get', 'post'], 'change/shipping/address/{order_id}', 'ShippingAddressController@changeShippingAddress')->name('user.changeShippingAddress');
		//user shipping address book
		Route::get('shipping/address/book', 'ShippingAddressController@addressBook')->name('user.addressBook');
		Route::get('shipping/address/edit/{id}', 'ShippingAddressController@shippingAddressEdit')->name('shippingAddress.edit');
		Route::post('shipping/address/update', 'ShippingAddressController@shippingAddressUpdate')->name('shippingAddress.update');
		Route::get('shipping/address/delete/{id}', 'ShippingAddressController@shippingAddressDelete')->name('shippingAddress.delete');

		Route::get('addto/wishlist', 'WishlistController@store')->name('wishlist.add');
		Route::get('wishlist', 'WishlistController@index')->name('wishlists');
		Route::get('wishlist/remove/{id}', 'WishlistController@remove')->name('wishlist.remove');

		//checkout routes
		Route::get('checkout/shipping/review', [CheckoutController::class,'shippingReview'])->name('shippingReview');
//		Route::post('checkout/order/confirm', 'OrderController@orderConfirm')->name('orderConfirm');
		Route::post('checkout/order/confirm', [OrderController::class, 'orderConfirm'])->name('orderConfirm');
		//Route::get('checkout/payment/{orderId}', 'PaymentController@orderPaymentGateway')->name('order.paymentGateway');
		Route::get('checkout/payment/{orderId}', [PaymentController::class, 'orderPaymentGateway'])->name('order.paymentGateway');
		//Route::post('checkout/payment/{orderId}', 'PaymentController@orderPayment')->name('order.payment');
		Route::post('checkout/payment/{orderId}', [PaymentController::class, 'orderPayment'])->name('order.payment');
		//Route::get('checkout/payment/confirm/{orderId}', 'PaymentController@paymentConfirm')->name('order.paymentConfirm');
		Route::get('checkout/payment/confirm/{orderId}', [PaymentController::class, 'paymentConfirm'])->name('order.paymentConfirm');

		// Cash  payment 
		Route::post('order/cash/payment/{orderId}', 'PaymentController@handCashPayment')->name('handCashPayment');

		//order routes
		//Route::get('order/history/{status?}', 'OrderController@orderHistory')->name('user.orderHistory');
        Route::get('order/history/{status?}', [OrderController::class, 'orderHistory'])->name('user.orderHistory');
		//Route::get('order/details/{order_id?}', 'OrderController@orderDetails')->name('user.orderDetails');
        Route::get('order/details/{order_id?}', [OrderController::class, 'orderDetails'])->name('user.orderDetails');







		//voucher
		Route::get('voucher/history/{status?}', 'VoucherController@voucherHistory')->name('user.voucherHistory');
		Route::get('voucher/details/{order_id?}', 'VoucherController@voucherDetails')->name('user.voucherDetails');
		Route::get('order/downloadable/{status?}', 'OrderController@orderDownloadable')->name('user.orderDownloadable');

		Route::get('order/cancel/{order_id}', 'OrderController@orderCancelForm')->name('user.orderCancelForm');
		Route::post('order/cancel/confirm', 'OrderController@orderCancel')->name('user.orderCancel');
		Route::get('order/invoice/{order_id}', 'OrderController@orderInvoice')->name('user.orderInvoice');

		Route::get('user/wallet', [CustomerWalletController::class, 'walletHistory'])->name('customer.walletHistory');
		Route::post('user/wallet/withdraw/request', [CustomerWalletController::class, 'withdrawRequest'])->name('customer.withdraw_request');
	});
});
