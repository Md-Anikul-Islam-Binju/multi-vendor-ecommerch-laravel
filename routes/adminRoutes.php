<?php

use App\Http\Controllers\Admin\AdminVendorController;
use App\Http\Controllers\Admin\OrderCancelReasonController;
use App\Http\Controllers\Admin\OrderStatusController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ShippingChargeController;
use App\Http\Controllers\Reseller\Dashboard;
use App\Http\Controllers\ReturnRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/login', 'Admin\AdminLoginController@LoginForm')->name('adminLoginForm');
Route::post('/login', 'Admin\AdminLoginController@login')->name('adminLogin');
Route::get('/register', 'Admin\AdminLoginController@RegisterForm')->name('adminRegisterForm');
Route::post('/register', 'Admin\AdminLoginController@register')->name('adminRegister');
Route::get('/logout', 'Admin\AdminLoginController@logout')->name('adminLogout');

Route::prefix('reseller')->group(function () {
	Route::get('/ok', function () {
		return "ok";
	});

	Route::get('/resellerList', [Dashboard::class, 'resellerList'])->name('resellerList');
    Route::get('wallet-change/{reseller}', [Dashboard::class, 'walletChangeView'])->name('reseller.wallet');
    Route::put('wallet-change/{reseller}', [Dashboard::class, 'walletChangeUpdate'])->name('reseller.wallet.update');
    //Route::get('vendor/list/{status?}', [AdminVendorController::class, 'vendorList'])->name('vendor.list');

	Route::get('/reseller/{id}/edit', 'Reseller\Dashboard@edit')->name('reseller.edit');



	//Route::get('/profile/{slug}', [Dashboard::class, 'vendorProfile'])->name('reseller.profile');
    Route::get('profile/{reseller}', [Dashboard::class, 'resellerProfile'])->name('reseller.profile');

    Route::get('secret/login/{id}', [Dashboard::class, 'resellerSecretLogin'])->name('admin.resellerSecretLogin');


	Route::get('/logout', 'Reseller\AuthController@logout')->name('resellerLogout');
});

Route::group(['middleware' => ['auth:admin', 'admin']], function () {
	//setting
	Route::get('general/setting', 'GeneralSettingController@generalSetting')->name('generalSetting');
	Route::post('general/setting/update/{id}', 'GeneralSettingController@generalSettingUpdate')->name('generalSettingUpdate');

	Route::get('logo/setting', 'GeneralSettingController@logoSetting')->name('logoSetting');
	Route::post('logo/setting/update/{id}', 'GeneralSettingController@logoSettingUpdate')->name('logoSettingUpdate');

	Route::match(['get', 'post'], 'google/setting', 'GeneralSettingController@googleSetting')->name('googleSetting');
	Route::match(['get', 'post'], 'google/recaptcha', 'SiteSettingController@google_recaptcha')->name('google_recaptcha');
	Route::match(['get', 'post'], 'seo/setting', 'GeneralSettingController@seoSetting')->name('seoSetting');
	Route::post('sitemap/setting', 'SitemapController@sitemapSetting')->name('sitemapSetting');

	Route::get('header/setting', 'GeneralSettingController@headerSetting')->name('headerSetting');
	Route::post('header/setting/update/{id}', 'GeneralSettingController@headerSettingUpdate')->name('headerSettingUpdate');
	Route::get('footer/setting', 'GeneralSettingController@footerSetting')->name('footerSetting');
	Route::post('footer/setting/update/{id}', 'GeneralSettingController@footerSettingUpdate')->name('footerSettingUpdate');


	Route::get('profile/update', 'Admin\AdminController@profileEdit')->name('admin.profile.update');
	Route::post('profile/update', 'Admin\AdminController@profileUpdate')->name('admin.profileUpdate');

	Route::get('change/password', 'Admin\AdminController@passwordChange')->name('admin.password.change');
	Route::post('change/password', 'Admin\AdminController@passwordUpdate')->name('admin.passwordChange');
	Route::post('reset/password', 'Admin\AdminController@resetPassword')->name('admin.resetPassword');

	Route::get('social/login/setting', 'Admin\SocialController@socialLoginSetting')->name('socialLoginSetting');
	Route::post('social/login/setting/update', 'Admin\SocialController@socialLoginSettingUpdate')->name('socialLoginSettingUpdate');

	Route::get('social/setting', 'Admin\SocialController@socialSetting')->name('socialSetting');
	Route::post('social/setting/store', 'Admin\SocialController@socialSettingStore')->name('socialSettingStore');
	Route::get('social/setting/edit/{id}', 'Admin\SocialController@socialSettingEdit')->name('socialSettingEdit');
	Route::post('social/setting/update/{id}', 'Admin\SocialController@socialSettingUpdate')->name('socialSettingUpdate');
	Route::get('social/setting/delete/{id}', 'Admin\SocialController@socialSettingDelete')->name('socialSettingDelete');

	// site setting
	Route::get('site/setting', 'SiteSettingController@siteSettings')->name('site_settings');
	Route::get('smtp/configurations', 'SiteSettingController@smtp_settings')->name('smtp_settings');
	Route::match(['get', 'post'], 'otp/configurations', 'SiteSettingController@otp_configurations')->name('otp_configurations');
	Route::post('env_key_update', 'SiteSettingController@env_key_update')->name('env_key_update');

	Route::get('site/setting/update/status', 'SiteSettingController@siteSettingActiveDeactive')->name('siteSettingActiveDeactive');
	Route::match(['get', 'post'], 'site/setting/update', 'SiteSettingController@siteSettingUpdate')->name('siteSettingUpdate');

	//refund
	Route::get('refund/request/{status?}', 'RefundController@adminReturnRequestList')->name('admin.refundRequest');
	Route::get('refund/request/status/{id}', 'RefundController@refundRequestStatus')->name('admin.refundRequestStatus');
	Route::get('refund/request/details/{id}', 'RefundController@refundRequestDetails')->name('admin.refundRequestDetails');
	Route::get('refund/request/approved/{id}/{status}', 'RefundController@refundRequestApproved')->name('admin.refundRequestApproved');

	//seller withdraw request
	//Route::get('seller/withdraw/request', 'WithdrawController@sellerWithdrawRequest')->name('sellerWithdrawRequest');
	Route::get('seller/withdraw/request', [\App\Http\Controllers\WithdrawController::class, 'sellerWithdrawRequest'])->name('sellerWithdrawRequest');
	Route::get('reseller/withdraw/request', [\App\Http\Controllers\WithdrawController::class, 'resellerWithdrawRequest'])->name('resellerWithdrawRequest');
	Route::get('seller/wallet/history', 'Admin\WalletController@sellerWalletHistory')->name('sellerWalletHistory');


	//customer withdraw request list
	Route::get('customer/wallet/withdraw/request', 'WithdrawController@customerWithdrawRequest')->name('customerWithdrawRequest')->middleware('adminPermission');
	Route::get('customer/wallet/history', 'Admin\WalletController@customerWalletHistory')->name('customerWalletHistory')->middleware('adminPermission');

	Route::get('customer/wallet/information', 'Admin\WalletController@customerWalletInfo')->name('customer.walletInfo');
	Route::post('customer/wallet/recharge', 'Admin\WalletController@walletRecharge')->name('customer.walletRecharge')->middleware('adminPermission');

	Route::get('customer/wallet/withdraw/configuration', 'WithdrawController@customerWithdrawConfigure')->name('customer.withdrawConfigure');

	//Route::match(['get', 'post'], 'withdraw/request/update', 'Admin\WalletController@changeWithdrawStatus')->name('admin.changeWithdrawStatus');
	Route::match(['get', 'post'], 'withdraw/request/update', [\App\Http\Controllers\Admin\WalletController::class,'changeWithdrawStatus'])->name('admin.changeWithdrawStatus');

	Route::get('withdraw/make/withdraw/details/{withdraw_id}', 'Admin\WalletController@withdrawMakePaymentDetails')->name('admin.withdrawMakePaymentDetails');
	Route::get('withdraw/history/{user_id}', 'Admin\WalletController@getWithdrawHistory')->name('admin.getWithdrawHistory');
	Route::get('transactions', 'TransactionController@admin_transactions')->name('admin.transactions');


	//product review
	route::get('product/review', 'ReviewController@reviewList')->name('adminReviewList');

	route::get('order/review/form', 'ReviewController@adminGetReviewForm')->name('adminGetReviewForm');
	route::post('order/review/insert', 'ReviewController@adminReviewInsert')->name('adminReviewInsert');

	//insert fake review
	route::post('product/review/insert', 'ReviewController@reviewInsert')->name('productReviewInsert');

	route::get('product/review/edit/{id}', 'ReviewController@reviewEdit')->name('adminReviewEdit');
	route::post('product/review/update', 'ReviewController@reviewUpdate')->name('adminReviewUpdate');
	route::get('product/review/delete/{id}', 'ReviewController@reviewDelete')->name('adminReviewDelete');
	route::get('product/review/reply/{id}', 'ReviewController@reviewReplyList')->name('reviewReplyList');
	route::post('product/review/reply/{id}', 'ReviewController@reviewReply')->name('reviewReply');


	route::get('message/{username?}', 'MessageController@message')->name('messageAdmin');

	// brand routes
	Route::get('brand', 'BrandController@index')->name('brand');
	Route::post('brand/store', 'BrandController@store')->name('brand.store');
	Route::get('brand/list', 'BrandController@index')->name('brand.list');
	Route::get('brand/edit/{id}', 'BrandController@edit')->name('brand.edit');
	Route::post('brand/update', 'BrandController@update')->name('brand.update');
	Route::get('brand/delete/{id}', 'BrandController@delete')->name('brand.delete');
	// currency route
	Route::get('currency/list', 'CurrencyController@index')->name('currency.list');
	Route::post('currency/store', 'CurrencyController@store')->name('currency.store');
	Route::get('currency/edit/{id}', 'CurrencyController@edit')->name('currency.edit');
	Route::post('currency/update', 'CurrencyController@update')->name('currency.update');
	Route::get('currency/delete/{id}', 'CurrencyController@delete')->name('currency.delete');
	Route::get('currency/default/set', 'CurrencyController@currencyDefaultSet')->name('currency.defaultSet');
});

// authenticate routes & check role admin
Route::group(['middleware' => ['auth:admin', 'admin'], 'namespace' => 'Admin'], function () {
	Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('admin.dashboard');
	//module
	Route::get('module/list', 'ModuleController@index')->name('module.list');
	Route::post('module/store', 'ModuleController@store')->name('admin.module.store');
	Route::get('module/edit/{id}', 'ModuleController@edit')->name('admin.module.edit');
	Route::post('module/update', 'ModuleController@update')->name('admin.module.update');
	Route::get('module/delete/{id}', 'ModuleController@delete')->name('admin.module.delete');

	//sub module
	Route::get('submodule/list', 'ModuleController@submoduleIndex')->name('admin.submodule.list');
	Route::post('submodule/store', 'ModuleController@submoduleStore')->name('admin.submodule.store');
	Route::get('submodule/edit/{id}', 'ModuleController@submoduleEdit')->name('admin.submodule.edit');
	Route::post('submodule/update', 'ModuleController@submoduleUpdate')->name('admin.submodule.update');
	Route::get('submodule/delete/{id}', 'ModuleController@submoduleDelete')->name('admin.submodule.delete');

	// role routes
	Route::get('role/list', 'RoleController@index')->name('role.list');
	Route::post('role/store', 'RoleController@store')->name('role.store');
	Route::get('role/{id}/edit', 'RoleController@edit')->name('role.edit');
	Route::post('role/update', 'RoleController@update')->name('role.update');
	Route::get('role/delete/{id}', 'RoleController@delete')->name('role.delete');

	Route::get('role/permission/{slug}', 'RoleController@permissionIndex')->name('role.permission');
	Route::post('role/permission/store', 'RoleController@permissionStore')->name('role.permission.store');

	//category routes
	Route::get('category', 'CategoryController@category')->name('category');
	Route::get('get/category', 'CategoryController@getcategory')->name('getcategory');
	Route::post('category/store', 'CategoryController@category_store')->name('category.store');
	Route::get('category/edit/{id}', 'CategoryController@category_edit')->name('category.edit');
	Route::post('category/update', 'CategoryController@category_update')->name('category.update');
	Route::get('category/delete/{id}', 'CategoryController@category_delete')->name('category.delete');

	// sub category routes
	Route::get('subcategory', 'CategoryController@subcategory')->name('subcategory');

	Route::post('subcategory/store', 'CategoryController@subcategory_store')->name('subcategory.store');
	Route::get('subcategory/list', 'CategoryController@subcategory_index')->name('subcategory.list');
	Route::get('subcategory/edit/{id}', 'CategoryController@subcategory_edit')->name('subcategory.edit');
	Route::post('subcategory/update', 'CategoryController@subcategory_update')->name('subcategory.update');
	Route::get('subcategory/delete/{id}', 'CategoryController@subcategory_delete')->name('subcategory.delete');

	Route::get('get/subcategory/{id}', 'CategoryController@get_subcategory')->name('get_subcategory');

	Route::get('subchild/category', 'CategoryController@subchildcategory')->name('subchildcategory');
	Route::post('subchild/category/store', 'CategoryController@subchildcategory_store')->name('subchildcategory.store');

	Route::get('subchild/category/edit/{id}', 'CategoryController@subchildcategory_edit')->name('subchildcategory.edit');

	Route::post('subchild/category/update', 'CategoryController@subchildcategory_update')->name('subchildcategory.update');
	Route::get('subchild/category/delete/{id}', 'CategoryController@subchildcategory_delete')->name('subchildcategory.delete');

	Route::get('category/sorting', 'CategoryController@categorySorting')->name('categorySorting');
	Route::get('get/category/banner/{slug}', 'CategoryController@getCategoryBanner')->name('getCategoryBanner');

	// productAttribute routes
	Route::get('product/attribute', 'ProductAttributeController@attribute_create')->name('productAttribute');
	Route::post('product/attribute/store', 'ProductAttributeController@attribute_store')->name('productAttribute.store');

	Route::get('product/attribute/edit/{id}', 'ProductAttributeController@attribute_edit')->name('productAttribute.edit');
	Route::post('product/attribute/update', 'ProductAttributeController@attribute_update')->name('productAttribute.update');
	Route::get('product/attribute/delete/{id}', 'ProductAttributeController@attribute_delete')->name('productAttribute.delete');

	// productAttributeValue routes
	Route::get('product/attributevalue/{attribute_slug}/list', 'ProductAttributeController@attributevalue')->name('productAttributeValue');
	Route::post('product/attributevalue/store', 'ProductAttributeController@attributevalue_store')->name('productAttributeValue.store');
	Route::get('product/attributevalue/list', 'ProductAttributeController@attributevalue_list')->name('productAttributeValue.list');
	Route::get('product/attributevalue/edit/{id}', 'ProductAttributeController@attributevalue_edit')->name('productAttributeValue.edit');
	Route::post('product/attributevalue/update', 'ProductAttributeController@attributevalue_update')->name('productAttributeValue.update');
	Route::get('product/attributevalue/delete/{id}', 'ProductAttributeController@attributevalue_delete')->name('productAttributeValue.delete');

	// predefined Feature routes
	Route::get('predefined/feature', 'PredefinedFeatureController@index')->name('predefinedFeature');
	Route::post('predefined/feature/store', 'PredefinedFeatureController@store')->name('predefinedFeature.store');
	Route::get('predefined/feature/list', 'PredefinedFeatureController@index')->name('predefinedFeature.list');
	Route::get('predefined/feature/edit/{id}', 'PredefinedFeatureController@edit')->name('predefinedFeature.edit');
	Route::post('predefined/feature/update', 'PredefinedFeatureController@update')->name('predefinedFeature.update');
	Route::get('predefined/feature/delete/{id}', 'PredefinedFeatureController@delete')->name('predefinedFeature.delete');

	// cart button route
	Route::get('cart/button/list', 'CartButtonController@index')->name('cartBtn');
	Route::post('cart/button/store', 'CartButtonController@store')->name('cartBtn.store');
	Route::get('cart/button/edit/{id}', 'CartButtonController@edit')->name('cartBtn.edit');
	Route::post('cart/button/update', 'CartButtonController@update')->name('cartBtn.update');
	Route::get('cart/button/delete/{id}', 'CartButtonController@delete')->name('cartBtn.delete');

	// product routes
	Route::get('product/upload', 'ProductController@upload')->name('admin.product.upload');
	Route::post('product/store', 'ProductController@store')->name('admin.product.store');

    Route::get('test', [ProductController::class, 'test']);

	Route::get('product/{status?}', [ProductController::class, 'index'])->name('admin.product.list');
	Route::get('product-import', [ProductController::class, 'productImport'])->name('admin.product.import');
	Route::post('product-import', [ProductController::class, 'productImportUpload'])->name('admin.product.import.upload');
	Route::get('product-import/example/download', [ProductController::class, 'download'])->name('excel.download');


	Route::get('product/edit/{slug}', [ProductController::class, 'edit'])->name('admin.product.edit');
	Route::get('product/clone/{slug}', 'ProductController@clone')->name('admin.product.clone');


	Route::post('product/update/{product_id}', 'ProductController@update')->name('admin.product.update');
	Route::get('product/delete/{id}', 'ProductController@delete')->name('admin.product.delete');
	//get highlight popup
	Route::get('product/highlight/popup/{id}', 'ProductController@highlight')->name('product.highlight');
	//add/remove highlight product
	Route::get('product/highlight/addRemove', 'ProductController@highlightAddRemove')->name('highlightAddRemove');
	//upload product gallery image
	Route::get('product/gallery/image/{product_id}', 'ProductController@getGalleryImage')->name('product.getGalleryImage');
	Route::post('product/gallery/image', 'ProductController@storeGalleryImage')->name('product.storeGalleryImage');
	Route::get('product/gallery/image/delete/{id}', 'ProductController@deleteGalleryImage')->name('product.deleteGalleryImage');

	// slider routes
	Route::get('slider/create', 'SliderController@index')->name('slider.create');
	Route::post('slider/store', 'SliderController@store')->name('slider.store');
	Route::get('manage/slider', 'SliderController@index')->name('slider.list');
	Route::get('slider/edit/{id}', 'SliderController@edit')->name('slider.edit');
	Route::post('slider/update', 'SliderController@update')->name('slider.update');
	Route::get('slider/delete/{id}', 'SliderController@delete')->name('slider.delete');


	// homepage routes
	Route::get('homepage/section', 'HomepageSectionController@index')->name('admin.homepageSection');
	Route::post('homepage/section/store', 'HomepageSectionController@store')->name('admin.homepageSection.store');
	Route::get('homepage/section/edit/{id}', 'HomepageSectionController@edit')->name('admin.homepageSection.edit');
	Route::post('homepage/section/update', 'HomepageSectionController@update')->name('admin.homepageSection.update');
	Route::get('homepage/section/delete/{id}', 'HomepageSectionController@delete')->name('admin.homepageSection.delete');
	Route::get('homepage/section/image/delete/{id}', 'HomepageSectionController@sectionImageDelete')->name('sectionImageDelete');

	// homepage section routes
	Route::get('homepage/section/item/{slug?}', 'HomepageSectionItemController@index')->name('admin.homepageSectionItem');
	Route::post('homepage/section/item/store', 'HomepageSectionItemController@store')->name('admin.homepageSectionItem.store');
	Route::get('homepage/section/item/edit/{id}', 'HomepageSectionItemController@edit')->name('admin.homepageSectionItem.edit');
	Route::post('homepage/section/item/update', 'HomepageSectionItemController@update')->name('admin.homepageSectionItem.update');
	Route::get('homepage/section/item/remove/{id}', 'HomepageSectionItemController@itemRemove')->name('admin.homepageSectionItem.remove');

	Route::get('homepage/section/get/single-product', 'HomepageSectionController@getSingleProduct')->name('admin.getSingleProduct');

	Route::get('homepage/section/sorting', 'HomepageSectionController@homepageSectionSorting')->name('admin.homepageSectionSorting');

	// category section routes
	Route::get('category/section', 'CategorySectionController@index')->name('admin.categorySection');
	Route::post('category/section/store', 'CategorySectionController@store')->name('admin.categorySection.store');
	Route::get('category/section/edit/{id}', 'CategorySectionController@edit')->name('admin.categorySection.edit');
	Route::post('category/section/update', 'CategorySectionController@update')->name('admin.categorySection.update');
	Route::get('category/section/delete/{id}', 'CategorySectionController@delete')->name('admin.categorySection.delete');
	Route::get('get/sub-child-category', 'CategorySectionController@getSubChildcategory')->name('admin.getSubChildcategory');


	// offer routes
	Route::get('offer/type/list', 'OfferTypeController@offerTypeIndex')->name('offerType.list');
	Route::post('offer/type/store', 'OfferTypeController@offerTypeStore')->name('offerType.store');
	Route::get('offer/type/{id}/edit', 'OfferTypeController@offerTypeEdit')->name('offerType.edit');
	Route::post('offer/type/update', 'OfferTypeController@offerTypeUpdate')->name('offerType.update');
	Route::get('offer/type/delete/{id}', 'OfferTypeController@offerTypeDelete')->name('offerType.delete');

	Route::get('offer', 'OfferController@index')->name('admin.offer');
	Route::post('offer/store', 'OfferController@store')->name('admin.offer.store');
	Route::get('offer/list', 'OfferController@index')->name('admin.offer.list');
	Route::get('offer/edit/{id}', 'OfferController@editOffer')->name('admin.offer.edit');
	Route::post('offer/update', 'OfferController@updateOffer')->name('admin.offer.update');
	Route::get('offer/delete/{id}', 'OfferController@delete')->name('admin.offer.delete');
	//get product ajax request
	Route::get('offer/get/all/product', 'OfferController@getAllProducts')->name('offer.getAllProducts');

	//disply offer product list
	Route::get('offer/{offer_slug}/product', 'OfferController@offerProducts')->name('admin.offerProducts')->middleware('adminPermission');
	Route::get('offer/product/edit/{id}', 'OfferController@offerProductEdit')->name('admin.offerProduct.edit');
	Route::post('offer/product/update', 'OfferController@offerProductUpdate')->name('admin.offerProduct.update');
	Route::get('offer/product/remove/{id}', 'OfferController@offerProductRemove')->name('admin.offerProduct.remove');
	Route::get('offer/product/seller/price/{id}', 'OfferController@setProductPrice')->name('admin.setProductPrice');

	Route::get('offer/single/product/store', 'OfferController@offerSingleProductStore')->name('admin.offerSingleProductStore');
	Route::post('offer/product/store', 'OfferController@offerMultiProductStore')->name('admin.offerMultiProductStore');
	Route::post('offer/product/store', 'OfferController@offerMultiProductStore')->name('admin.offerMultiProductStore');

	Route::get('offer/{offer_slug}/order/{status?}', 'OfferController@offerOrder')->name('admin.offerOrder');
	Route::get('offer/{offer_slug}/order/details/{username}', 'OfferController@showOfferOrderDetails')->name('admin.getOfferOrderDetails');

	Route::get('offer/{offer_slug}/order/invoice/{customer_name}', 'OfferController@offerOrderInvoice')->name('admin.offerOrderInvoice');

	Route::get('offer/{offer_slug}/product/{product_slug}', 'OfferController@offerOrderProducts')->name('admin.offerOrderProducts');


	// page routes
	Route::get('page/create', 'PageController@create')->name('page.create');
	Route::post('page/store', 'PageController@store')->name('page.store');
	Route::get('page/list', 'PageController@index')->name('page.list');
	Route::get('page/{slug}/edit', 'PageController@edit')->name('page.edit');
	Route::post('page/update/{id}', 'PageController@update')->name('page.update');
	Route::get('page/delete/{id}', 'PageController@delete')->name('page.delete');
	Route::get('page/slug/create', 'PageController@getSlug')->name('page.slug');

	Route::get('page/status/{id}', 'PageController@status')->name('page.status');
	Route::get('page/homepage-status/{id}', 'PageController@homepageStatus')->name('page.homepageStatus');


	// menu routes
	Route::get('menu', 'MenuController@index')->name('menu');
	Route::post('menu/store', 'MenuController@store')->name('menu.store');
	Route::get('menu/list', 'MenuController@index')->name('menu.list');
	Route::get('menu/edit/{id}', 'MenuController@edit')->name('menu.edit');
	Route::post('menu/update', 'MenuController@update')->name('menu.update');
	Route::get('menu/delete/{id}', 'MenuController@delete')->name('menu.delete');

	// user routes

	Route::post('customer/store', 'CustomerController@store')->name('customer.store');
	Route::get('customer/{id}/edit', 'CustomerController@edit')->name('customer.edit');
	Route::post('customer/update', 'CustomerController@update')->name('customer.update');
	Route::get('customer/delete/{id}', 'CustomerController@delete')->name('customer.delete');

	Route::get('customer/list/{status?}', 'CustomerController@customerList')->name('customer.list');
	Route::get('customer/secret/login/{id}', 'CustomerController@customerSecretLogin')->name('admin.customerSecretLogin');
	Route::get('customer/profile/{username}', 'CustomerController@customerProfile')->name('customer.profile');


	Route::post('vendor/store', 'AdminVendorController@store')->name('vendor.store');
	Route::get('vendor/{id}/edit', 'AdminVendorController@edit')->name('vendor.edit');
	Route::post('vendor/update', 'AdminVendorController@update')->name('vendor.update');
	Route::get('vendor/delete/{id}', 'AdminVendorController@delete')->name('vendor.delete');

	Route::get('vendor/list/{status?}', [AdminVendorController::class, 'vendorList'])->name('vendor.list');

	Route::get('vendor/profile/{slug}', 'AdminVendorController@vendorProfile')->name('admin.vendor.profile');
	Route::get('vendor/secret/login/{id}', 'AdminVendorController@sellerSecretLogin')->name('admin.sellerSecretLogin');

	Route::get('vendor/commission', 'AdminVendorController@vendor_commission')->name('vendor.commission');
	Route::post('vendor/commission', 'AdminVendorController@vendorCommissionUpdate')->name('vendor.commission.store');




	// staff routes
	Route::get('staff/create', 'AdminStaffController@create')->name('staff.create');
	Route::post('staff/store', 'AdminStaffController@store')->name('staff.store');
	Route::get('staff/list', 'AdminStaffController@staffList')->name('staff.list');
	Route::get('staff/{id}/edit', 'AdminStaffController@edit')->name('staff.edit');
	Route::post('staff/update', 'AdminStaffController@update')->name('staff.update');
	Route::get('staff/delete/{id}', 'AdminStaffController@delete')->name('staff.delete');
	Route::get('staff/profile/{username}', 'AdminStaffController@staffProfile')->name('staff.profile');
	Route::get('staff/secret/login/{id}', 'AdminStaffController@staffSecretLogin')->name('admin.staffSecretLogin');

	// banner routes
	Route::get('banner/list/{type?}', 'BannerController@index')->name('banner');
	Route::post('banner/store', 'BannerController@store')->name('banner.store');

	Route::get('banner/{id}/edit', 'BannerController@edit')->name('banner.edit');
	Route::post('banner/update', 'BannerController@update')->name('banner.update');
	Route::get('banner/delete/{id}', 'BannerController@delete')->name('banner.delete');
	Route::get('banner/image/delete', 'BannerController@bannerImage_delete')->name('bannerImage_delete');

	// label routes
	Route::post('label/store', 'LabelController@store')->name('label.store');
	Route::get('label/list', 'LabelController@index')->name('label.list');
	Route::get('label/{id}/edit', 'LabelController@edit')->name('label.edit');
	Route::post('label/update', 'LabelController@update')->name('label.update');
	Route::get('label/delete/{id}', 'LabelController@delete')->name('label.delete');

	// service routes
	Route::post('service/store', 'ServicesController@store')->name('service.store');
	Route::get('service/list', 'ServicesController@index')->name('service.list');
	Route::get('service/{id}/edit', 'ServicesController@edit')->name('service.edit');
	Route::post('service/update', 'ServicesController@update')->name('service.update');
	Route::get('service/delete/{id}', 'ServicesController@delete')->name('service.delete');

	// coupon routes
	Route::get('coupon', 'CouponController@index')->name('coupon');
	Route::post('coupon/store', 'CouponController@store')->name('coupon.store');
	Route::get('coupon/{id}/edit', 'CouponController@edit')->name('coupon.edit');
	Route::post('coupon/update', 'CouponController@update')->name('coupon.update');
	Route::get('coupon/delete/{id}', 'CouponController@delete')->name('coupon.delete');

	Route::get('shipping/method', 'ShippingMethodController@shipping_method')->name('shipping_method.list');
	Route::post('shipping/method/store', 'ShippingMethodController@store')->name('shipping_method.store');
	Route::get('shipping/method/{id}/edit', 'ShippingMethodController@edit')->name('shipping_method.edit');
	Route::post('shipping/method/update', 'ShippingMethodController@update')->name('shipping_method.update');
	Route::get('shipping/method/delete/{id}', 'ShippingMethodController@delete')->name('shipping_method.delete');

	Route::post('shipping/method/active', [ShippingChargeController::class, 'activeShippingMethod'])->name('activeShippingMethod');

	Route::get('shipping/charge', [ShippingChargeController::class,'index'])->name('shipping_charge');
	Route::post('shipping/charge/store', [ShippingChargeController::class,'store'])->name('shipping_charge.store');
	Route::get('shipping/charge/{id}/edit', [ShippingChargeController::class, 'edit'])->name('shipping_charge.edit');
	Route::post('shipping/charge/update', [ShippingChargeController::class, 'update'])->name('shipping_charge.update');
	Route::get('shipping/charge/delete/{id}', [ShippingChargeController::class, 'delete'])->name('shipping_charge.delete');


	//packaging
	Route::get('packaging', 'LocationController@index')->name('packagings');
	Route::post('packaging/store', 'LocationController@store')->name('packaging.store');
	Route::get('packaging/edit/{id}', 'LocationController@edit')->name('packaging.edit');
	Route::post('packaging/update', 'LocationController@update')->name('packaging.update');
	Route::get('packaging/delete/{id}', 'LocationController@delete')->name('packaging.delete');

	//location all routes
	Route::get('pickup/point', 'LocationController@state')->name('pickupPoints');
	Route::post('pickup/point/store', 'LocationController@pickupPoints_store')->name('pickupPoints.store');
	Route::get('pickup/point/edit/{id}', 'LocationController@pickupPoints_edit')->name('pickupPoints.edit');
	Route::post('pickup/point/update', 'LocationController@pickupPoints_update')->name('pickupPoints.update');
	Route::get('pickup/point/delete/{id}', 'LocationController@pickupPoints_delete')->name('pickupPoints.delete');


	//state
	Route::get('state', 'LocationController@state')->name('state');
	Route::post('state/store', 'LocationController@state_store')->name('state.store');
	Route::get('state/edit/{id}', 'LocationController@state_edit')->name('state.edit');
	Route::post('state/update', 'LocationController@state_update')->name('state.update');
	Route::get('state/delete/{id}', 'LocationController@state_delete')->name('state.delete');

	// city route
	Route::get('city', 'LocationController@city')->name('city');
	Route::post('city/store', 'LocationController@city_store')->name('city.store');
	Route::get('city/edit/{id}', 'LocationController@city_edit')->name('city.edit');
	Route::post('city/update', 'LocationController@city_update')->name('city.update');
	Route::get('city/delete/{id}', 'LocationController@city_delete')->name('city.delete');

	// area route
	Route::get('area', 'LocationController@area')->name('area');
	Route::post('area/store', 'LocationController@area_store')->name('area.store');
	Route::get('area/edit/{id}', 'LocationController@area_edit')->name('area.edit');
	Route::post('area/update', 'LocationController@area_update')->name('area.update');
	Route::get('area/delete/{id}', 'LocationController@area_delete')->name('area.delete');

	// payment route
	Route::get('payment/gateway', 'PaymentGatewayController@index')->name('paymentGateway');
	Route::post('payment/gateway/store', 'PaymentGatewayController@store')->name('paymentGateway.store');
	Route::get('payment/gateway/edit/{id}', 'PaymentGatewayController@edit')->name('paymentGateway.edit');
	Route::post('payment/gateway/update', 'PaymentGatewayController@update')->name('paymentGateway.update');
	Route::get('payment/gateway/delete/{id}', 'PaymentGatewayController@delete')->name('paymentGateway.delete');
	Route::get('payment/gateway/mode/change', 'PaymentGatewayController@paymentModeChange')->name('paymentModeChange');
	//seller payment route
	Route::get('payment/gateway/seller', 'PaymentGatewayController@sellerPaymentGateway')->name('sellerPaymentGateway');
	//order list

	Route::get('order/{status?}', [\App\Http\Controllers\Admin\AdminOrderController::class,'orderHistory'])->name('admin.orderList');

	Route::get('order/details/{order_id}', [\App\Http\Controllers\Admin\AdminOrderController::class, 'showOrderDetails'])->name('admin.getOrderDetails');
	//Route::get('order/invoice/{order_id?}', 'AdminOrderController@orderInvoice')->name('admin.orderInvoice');

	Route::get('order/invoice/{order_id?}', [\App\Http\Controllers\Admin\AdminOrderController::class, 'orderInvoice'])->name('admin.orderInvoice');

	//voucher order list
	Route::get('voucher/order/{status?}', 'VoucherAdminController@orderHistory')->name('admin.voucherOrderList');
	Route::get('voucher/order/details/{order_id}', 'VoucherAdminController@showOrderDetails')->name('admin.voucherDetails');
	Route::get('voucher/delivery/timelines', 'VoucherAdminController@voucherTimelines')->name('admin.voucherTimelines');
	Route::get('voucher/delivery/timelines/{order_id}', 'VoucherAdminController@voucherTimelineDetails')->name('admin.voucherTimelineDetails');
	Route::get('voucher/rate/set', 'VoucherAdminController@voucherRate')->name('admin.voucherRate');
	Route::post('voucher/invoice/generate/{order_id}', 'VoucherAdminController@voucherInvoiceGenerate')->name('admin.voucherInvoiceGenerate');
	Route::get('voucher/invoice/{order_id?}', 'VoucherAdminController@voucherInvoice')->name('admin.voucherInvoice');
	Route::get('voucher/invoice/print/{order_id?}', 'VoucherAdminController@voucherInvoicePrintBy')->name('admin.voucherInvoicePrintBy');
	Route::get('voucher/status/change', 'VoucherAdminController@changeVoucherStatus')->name('admin.changeVoucherStatus');
	Route::get('voucher/timelines/export', 'VoucherAdminController@exportVoucherTimeline')->name('admin.exportVoucherTimeline');

	//change or add shipping method
	Route::get('order/shipping/method', 'OrderStatusController@shippingMethod')->name('admin.shippingMethod');
	Route::get('order/information/added', 'AdminOrderController@addedOrderInfo')->name('admin.addedOrderInfo');

	//change payment status
	//Route::post('payment/status/change', 'OrderStatusController@changePaymentStatus')->name('admin.changePaymentStatus');
	Route::post('payment/status/change', [\App\Http\Controllers\Admin\OrderStatusController::class, 'changePaymentStatus'])->name('admin.changePaymentStatus');
	//Route::get('payment/details/check/{order_id}', 'OrderStatusController@orderPaymentDetails')->name('admin.orderPaymentDetails');
	Route::get('payment/details/check/{order_id}', [\App\Http\Controllers\Admin\OrderStatusController::class, 'orderPaymentDetails'])->name('admin.orderPaymentDetails');

	//set product attribute size , color etc
	Route::get('order/attribute/update', 'AdminOrderController@orderAttributeUpdate')->name('admin.orderAttribute.update');

	//change order status
	Route::get('order/status/change', [OrderStatusController::class,'changeOrderStatus'])->name('admin.changeOrderStatus');


	Route::match(['get', 'post'], 'change/shipping/address/{order_id}', 'ShippingMethodController@changeShippingAddress')->name('admin.changeShippingAddress');
	Route::match(['get', 'post'], 'orderReturn/{order}', 'ShippingMethodController@orderReturn')->name('admin.orderReturn');

	Route::get('order/product/status/change', 'OrderStatusController@changeProductOrderStatus')->name('admin.changeProductOrderStatus');

	Route::get('order/cancel/{order_id?}', 'OrderStatusController@orderCancel')->name('admin.orderCancel');
	Route::get('order/invoice/print/{order_id?}', 'AdminOrderController@invoicePrintBy')->name('admin.invoicePrintBy');



    Route::get('order/return/reason/list', [ReturnRequestController::class, 'index'])->name('order.return.list');
    Route::get('order/return/approve/form/{returnRequest}', [ReturnRequestController::class, 'edit'])->name('order.return.approve.form');
    Route::post('order/return/approve/{returnRequest}', [ReturnRequestController::class, 'update'])->name('order.return.approve.form.update');

	// order cancel reason route
	Route::get('order/cancel/reason/list', 'OrderCancelReasonController@orderCancelReason')->name('orderCancelReason.list');
	Route::post('order/cancel/reason/store', 'OrderCancelReasonController@reasonStore')->name('orderCancelReason.store');
	Route::get('order/cancel/reason/edit/{id}', 'OrderCancelReasonController@reasonEdit')->name('orderCancelReason.edit');
	Route::post('order/cancel/reason/update', 'OrderCancelReasonController@reasonUpdate')->name('orderCancelReason.update');
	Route::get('order/cancel/reason/delete/{id}', 'OrderCancelReasonController@reasonDelete')->name('orderCancelReason.delete');

	Route::get('report/order', 'ReportController@orderReport')->name('admin.order.report');



	// refund Config route
	Route::get('refund/configuration', 'RefundReasonController@refundConfig')->name('admin.refundConfig');
	Route::post('refund/configuration/update', 'RefundReasonController@refundConfigUpdate')->name('admin.refundConfigUpdate');

	// refund reason route
	Route::get('return/order/reason', 'RefundReasonController@index')->name('returnReason');
	Route::post('return/order/reason/store', 'RefundReasonController@store')->name('returnReason.store');
	Route::get('return/order/reason/edit/{id}', 'RefundReasonController@edit')->name('returnReason.edit');
	Route::post('return/order/reason/update', 'RefundReasonController@update')->name('returnReason.update');
	Route::get('return/order/reason/delete/{id}', 'RefundReasonController@delete')->name('returnReason.delete');
});
