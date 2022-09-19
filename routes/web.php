<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BusinessProfileController as AdminBusinessProfileController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\ProductController;
//use App\Http\Controllers\Admin\BackendRfqController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\QueryController;
use App\Http\Controllers\Admin\PaymentTermController;
use App\Http\Controllers\Admin\ShipmentTypeController;
use App\Http\Controllers\Admin\ShipmentTermController;
use App\Http\Controllers\Admin\ShippingChargeController;
use App\Http\Controllers\Admin\ShippingMethodController;
use App\Http\Controllers\Admin\ProFormaTermAndConditionController;
// use App\Http\Controllers\Admin\ProFormaInvoiceController as AdminProFormaInvoiceController;
use App\Http\Controllers\Admin\AdminPoController;
use App\Http\Controllers\Admin\MerchantAssistanceController;
use App\Http\Controllers\Admin\UomContorller;
use App\Http\Controllers\Admin\UserController as AdminUserController;

use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\CertificationController as AdminCertificationController;
use App\Http\Controllers\Admin\ManageBusinessProfileController;
use App\Http\Controllers\Admin\NewUserRequestController;
use App\Http\Controllers\Admin\BackendRfqController as AdminRfqController;
use App\Http\Controllers\Admin\BusinessMappingTreeController;
use App\Http\Controllers\BusinessProfileController;
use App\Http\Controllers\BusinessProfile\ProformaOrderController;
use App\Http\Controllers\BusinessProfile\RfqController;
use App\Http\Controllers\BusinessProfile\UserProfileController;
use App\Http\Controllers\ProductionFlowAndManpowerController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\MainBuyerController;
use App\Http\Controllers\ExportDestinationController;
use App\Http\Controllers\AssociationMembershipController;
use App\Http\Controllers\PressHighlightController;
use App\Http\Controllers\BusinessTermController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\Manufacture\PoController;
use App\Http\Controllers\SamplingController;
use App\Http\Controllers\SpecialCustomizationController;
use App\Http\Controllers\SustainabilityCommitmentController;
use App\Http\Controllers\WalfareController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\CompanyFactoryTourController;
use App\Http\Controllers\ManageBusinessProfileController as UsersManageBusinessProfileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\ProductTagController;
use App\Http\Controllers\Admin\ProductTypeMappingController;
use App\Http\Controllers\BusinessProfile\BusinessProfileController as BusinessProfileBusinessProfileController;
use App\Http\Controllers\Manufacture\ProductController as ManufactureProductController;
use App\Http\Controllers\MyOrderController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\ProductCartController;
use App\Http\Controllers\ProductReviewController;

use App\Http\Controllers\QueryController as UserQueryController;
use App\Http\Controllers\VendorReviewController;
use App\Http\Controllers\ProductWishlistController;
use App\Http\Controllers\SubscribedUserEmailController;
use App\Http\Controllers\OrderModificationRequestController;
use App\Http\Controllers\OrderController as UserOrderController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\TinyMcController;
use App\Http\Controllers\Wholesaler\OrderController as WholesalerOrderController;
use App\Http\Controllers\Wholesaler\ProductController as WholesalerProductController;
use App\Http\Controllers\Wholesaler\ProfileInfoController;
use App\Http\Controllers\RfqBidController;
use App\Http\Controllers\BusinessProfile\QuerybidController;
use App\Http\Controllers\DesignersController;


use App\Models\BusinessProfile;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('jsonDataForVerifiedBusinessProfiles', function(){

    $exportData = array();
    $businessProfiles = BusinessProfile::with('companyOverview')->where('is_business_profile_verified', 1)->get();
    foreach($businessProfiles as $k => $businessProfile)
    {
        $dataArr = array();
        $dataArr['profile_name'] = $businessProfile->business_name;
        $data = json_decode($businessProfile->companyOverview->data);
        if(!empty($data)){
            foreach($data as $info) {
                if($info->name == "annual_revenue") {
                    $dataArr['annual_revenue'] = $info->value;
                }
                if($info->name == "number_of_worker") {
                    $dataArr['number_of_worker'] = $info->value;
                }
                if($info->name == "trade_license_number") {
                    $dataArr['trade_license_number'] = $info->value;
                }
                if($info->name == "main_product") {
                    $dataArr['main_product'] = $info->value;
                }

            }
        }
        array_push($exportData, $dataArr);
    }

    //echo "<pre>"; print_r($exportData); echo "</pre>";
    //die();
/*
$fp = fopen(url('').'/servicesnew/business_profile.csv', 'w');
foreach ($exportData as $fields) {
    fputcsv($fp, $fields);
}
fclose($fp);
*/

    //return Excel::download($exportData, 'business_profile.xlsx');

    return response()->json($exportData);
});

Route::get('jsonDataForBusinessProfilesComapnyOverview', function(){

    $exportData = array();
    $businessProfiles = BusinessProfile::with('companyOverview')->get();
    foreach($businessProfiles as $k => $businessProfile)
    {
        $dataArr = array();
        $dataArr['profile_name'] = $businessProfile->business_name;
        $data = json_decode($businessProfile->companyOverview->data);
        if(!empty($data)){
            foreach($data as $info) {
                if($info->name == "main_products") {
                    $dataArr['main_products'] = $info->value;
                }
            }
        }
        array_push($exportData, $dataArr);
    }

    //echo "<pre>"; print_r($exportData); echo "</pre>";
    //die();

    return response()->json($exportData);
});

Route::get('jsonDataForBusinessProfilesFactoryType', function(){

    $exportData = array();
    $businessProfiles = BusinessProfile::get();

    foreach($businessProfiles as $k => $businessProfile)
    {
        $dataArr = array();
        $dataArr['id'] = $businessProfile->id;
        $dataArr['profile_name'] = $businessProfile->business_name;
        $dataArr['factory_type'] = $businessProfile->factory_type;
        array_push($exportData, $dataArr);
    }

    // echo "<pre>"; print_r($exportData); echo "</pre>";
    // die();

    return response()->json($exportData);
});

//test
Route::get('generate-alias', [ImportController::class, 'generateAlias'])->name('generate.alias');
Route::get('blog-meta', [ImportController::class, 'blogMetaInfoUpdate'])->name('blog.meta');
//excel,csv user import
Route::get('import',[ImportController::class, 'importView'])->name('import.view');
Route::post('import',[ImportController::class, 'import'])->name('import');
Route::get('import-mainproducts',[ImportController::class, 'importMainproductsView'])->name('import.main.products.view');
Route::post('import-mainproducts',[ImportController::class, 'importMainproducts'])->name('import.main.products');
Route::fallback(function () {
    return view('404');
});
//product tag set product
Route::get('product-tag-set-into-product-table',[ImportController::class, 'productTagSet']);
Route::get('product-tag-mapping',[ImportController::class, 'productTagMappingWithBusinessMappingTree']);
// Frontend API's endpoint start
Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [HomeController::class, 'productList'])->name('products');
Route::get('/ready-stock', [HomeController::class, 'readyStockProducts'])->name('readystockproducts');
Route::get('/buy-designs', [HomeController::class, 'buyDesignsProducts'])->name('buydesignsproducts');
Route::get('/customizable', [HomeController::class, 'customizable'])->name('customizable');
Route::get('/low-moq-data', [HomeController::class, 'lowMoqData'])->name('low.moq.data');
Route::get('/low-moq', [HomeController::class, 'lowMoq'])->name('low.moq');
Route::get('/shortest-lead-time', [HomeController::class, 'shortestLeadTime'])->name('shortest.lead.time');
Route::get('/3d-studio', [HomeController::class, 'studio3dPage'])->name('front.3d-studio');
Route::get('/tools', [HomeController::class, 'toolsLandingPage'])->name('front.tools');
Route::get('/policy', [HomeController::class, 'policyLandingPage'])->name('front.policy');
Route::get('/aboutus', [HomeController::class, 'aboutusLandingPage'])->name('front.aboutus');
Route::get('/how-we-work', [HomeController::class, 'howweworkLandingPage'])->name('front.howwework');
Route::get('/contactus', [HomeController::class, 'contactusLandingPage'])->name('front.contactus');
Route::get('/welcomepage', [HomeController::class, 'rfqPostSuccessfulByAnonymous'])->name('front.rfqpostsuccessfulbyanonymous');
Route::get('/faqs', [HomeController::class, 'faqLandingPage'])->name('front.faq');


Route::get('/suppliers', [HomeController::class, 'suppliers'])->name('suppliers');
Route::get('/supplier/location/data',[HomeController::class,'getSupplierLocationData'])->name('get.supplier.location.data');

Route::get('/designers', [DesignersController::class, 'designers'])->name('designers');
Route::get('/designer/{id}', [DesignersController::class, 'singleDesignerDetails'])->name('single.designer.details');
Route::post('/designer/infoupdate', [DesignersController::class, 'singleDesignerDetailsUpdate'])->name('single.designer.details.update');

// Route::get('/suppliers', [HomeController::class, 'vendorList'])->name('vendors');
Route::get('product/{value}/details',[HomeController::class, 'productDetails'])->name('productdetails');

//low moq details
Route::get('product/details/{flag}/{id}',[HomeController::class, 'mixProductDetails'])->name('mix.product.details');

Route::get('/products/{slug}', [HomeController::class, 'productsByCategory'])->name('categories.product');
Route::get('/products/{category}/{subcategory}', [HomeController::class, 'productsBySubCategory'])->name('subcategories.product');
Route::get('/products/{category}/{subcategory}/{subsubcategory}', [HomeController::class, 'productsBySubSubCategory'])->name('sub.subcategories.product');

Route::get('/ready-stock/products/{slug}', [HomeController::class, 'readyStockProductsByCategory'])->name('readystock.categories.product');
Route::get('/ready-stock/products/{category}/{subcategory}', [HomeController::class, 'readyStockProductsBySubcategory'])->name('readystock.subcategories.product');
Route::get('/ready-stock/products/{category}/{subcategory}/{subsubcategory}', [HomeController::class, 'readyStockProductsBySubSubcategory'])->name('readystock.sub.subcategories.product');

Route::get('/buy-designs/products/{slug}', [HomeController::class, 'buyDesignProductsByCategory'])->name('buydesign.categories.product');
Route::get('/buy-designs/products/{category}/{subcategory}', [HomeController::class, 'buyDesignProductsBySubcategory'])->name('buydesign.subcategories.product');
Route::get('/buy-designs/products/{category}/{subcategory}/{subsubcategory}', [HomeController::class, 'buyDesignProductsBySubSubcategory'])->name('buydesign.sub.subcategories.product');

Route::get('/sorting/{value}/{slug?}/{cat_id?}', [HomeController::class, 'sorting'])->name('sorting');
Route::get('/vendor/sorting/{value}', [HomeController::class, 'sortingVendor'])->name('sorting.vendor');
Route::get('/filter/search', [HomeController::class, 'filterSearch'])->name('filter.search');
Route::post('/subscribe-for-newsletter', [SubscribedUserEmailController::class, 'subscribeForNewsletter'])->name('newsletter.subscribe');

Route::post('/products/{sku}/review',[ProductReviewController::class,'storeProductReview'])->name('product.review.store');
Route::get('/store-review',[VendorReviewController::class,'index'])->name('vendor.review.index');
Route::get('/store-review/order/{orderNumber}/store/{vendorUid}',[VendorReviewController::class,'showReviewForm'])->name('vendor.review_form');
Route::Post('/store-review/order/{orderNumber}/store/{vendorUid}',[VendorReviewController::class,'createVendorReview'])->name('vendor.review.create');
Route::get('/liveSearch',[HomeController::class,'liveSearchByProductOrVendor'])->name("live.search");
Route::get('/search',[HomeController::class,'searchByProductOrVendor'])->name("onsubmit.search");


Route::get('/industry-blogs',[HomeController::class,'blogs'])->name('industry.blogs');
Route::get('/press-room/details/{slug}',[HomeController::class,'blogDetails'])->name('blogs.details');
Route::get('/selected-buyer-info-for-rfq',[HomeController::class,'selectedBuyerDetails'])->name('rfqbuyer.details');

//user API's endpoint start
Route::get('/add-to-cart',[ProductCartController::class,'addToCart'])->name('add.cart');
Route::get('/wishlist',[ProductWishlistController::class,'index'])->name('wishlist.index')->middleware('auth','sso.verified');
Route::get('/delete-wishlist-item',[ProductWishlistController::class,'wishListItemDelete'])->name('wishlist.item.delete')->middleware('auth','sso.verified');
Route::get('/add-to-wishlist',[ProductWishlistController::class,'addToWishlist'])->name('add.wishlist');
Route::get('/copyright-price',[ProductCartController::class,'copyRightPrice'])->name('copyright.price');
Route::get('user/profile/vendor/{vendor}/order/{order}/notification/{notification}',[OrderController::class, 'showVendorOrderNotifactionFromFrontEnd'])->name('user.order.notification.show');

Route::get('rfq',[RfqController::class, 'index'])->name('rfq.index');
Route::get('rfq-by-page-no',[RfqController::class, 'rfqByPageNumber'])->name('rfq.frontend.pagination');

Route::get('rfq-info',[HomeController::class, 'rfqInfoDetails'])->name('new_rfq.index');

Route::group(['middleware'=>['sso.verified','auth']],function (){
    Route::get('/cart',[ProductCartController::class,'index'])->name('cart.index');
    Route::get('/cart-item-delete/{rowId}',[ProductCartController::class,'cartItemDelete'])->name('cart.delete');
    Route::post('/cart-item-update',[ProductCartController::class,'cartItemUpdate'])->name('cart.update');
    Route::get('/cart-item-update/modal/{cart_id}',[ProductCartController::class,'cartItemUpdateModal'])->name('cart.update.modal');
    Route::get('/cart-all-item-delete',[ProductCartController::class,'cartAllItemDelete'])->name('cart.destroy');
    Route::get('/checkout',[ProductCartController::class,'checkout'])->name('cart.checkout');
    Route::post('/order/paynow',[ProductCartController::class,'order'])->name('cart.order');
    Route::get('/order-success',[ProductCartController::class,'orderSuccess'])->name('cart.order.success');

    Route::get('/notification-mark-as-read',[UserController::class,'notificationMarkAsRead'])->name('notification-mark-as-read');
    Route::get('/order-notification-mark-as-read',[MyOrderController::class,'orderNotificationMarkAsRead'])->name('order-notification-mark-as-read');
    //store
    Route::get('store/{vendorId}', [UserController::class, 'myShop'])->name('users.myshop');
    Route::get('store/{vendorUid}/productgrouplist/{slug}', [UserController::class, 'myShopProductsByCategory'])->name('users.categories_products');
    Route::get('store/{vendorUid}/productgrouplist/{category}/{subcategory}', [UserController::class, 'myShopProductsBySubCategory'])->name('users.subcategories_products');
    Route::get('store/{vendorUid}/productgrouplist/{category}/{subcategory}/{subsubcategory}', [UserController::class, 'myShopProductsBySubSubCategory'])->name('users.sub.subcategories_products');
    Route::get('store/{vendorId}/profile', [UserController::class, 'myShopProfile'])->name('users.myShopProfile');
    Route::get('store/{vendorId}/contact', [UserController::class, 'myShopContact'])->name('users.myShopContact');
    Route::get('store/{vendorId}/reviews', [UserController::class, 'myShopReviews'])->name('users.myShopReviews');
    //endstore
    //seller product
    Route::get('/delete-single-image', [SellerProductController::class,'deleteSingleImage']);
    Route::post('/upload', [SellerProductController::class,'uploadSubmit']);
    Route::put('/upload-edit', [SellerProductController::class,'uploadSubmit']);
    Route::post('seller-store-update',[SellerProductController::class,'storeUpdate'])->name('seller.store.update');
    Route::post('update-profile-image', [UserController::class,'updateImage' ])->name('image.update');
    Route::post('update-banner-image', [UserController::class,'updateBanner' ])->name('banner.update');
    Route::get('seller-product/publish-unpublish/{sku}',[SellerProductController::class, 'publishUnpublish'])->name('seller.product.publish.unpublish');
    Route::resource('seller-product', SellerProductController::class);
    //end seller product
    //order query
    Route::get('order/queries/',[UserQueryController::class, 'index'])->name('user.order.query.index');
    Route::get('order/queries/show/{ord_mod_id}',[UserQueryController::class, 'show'])->name('user.order.query.show');
    Route::post('order/queries/store',[UserQueryController::class, 'store'])->name('user.order.query.store');
    Route::get('order/queries/message/show/{order_query_request_id}',[UserQueryController::class, 'showMessage'])->name('user.order.query.show.message');
    Route::post('order/queries/message/store',[UserQueryController::class, 'storeMessage'])->name('user.order.query.message.store');
    //end order query
    //order
    Route::get('order',[UserOrderController::class, 'index'])->name('order.index')->middleware(['auth','sso.verified']);
    Route::get('order-delivered/{orderNumber}',[UserOrderController::class, 'orderDelivered'])->middleware(['auth','sso.verified']);
    Route::get('order-type-filter', [UserOrderController::class, 'orderTypeFilter'])->name('order.type.filter');
    //end order
    //business profile
    Route::get('/business/profile', [BusinessProfileController::class, 'index'])->name('business.profile');
    Route::get('/business/profile/create', [BusinessProfileController::class, 'create'])->name('business.profile.create');
    Route::post('/business/profile/store', [BusinessProfileController::class, 'store'])->name('business.profile.store');
    Route::get('/manufacturer/profile/{alias}', [BusinessProfileController::class, 'show'])->name('manufacturer.profile.show');
    Route::post('/company/overview/update/{id}', [BusinessProfileController::class, 'companyOverviewUpdate'])->name('company.overview.update');
    Route::get('/business/mapping/child/{parent_id}', [BusinessProfileController::class, 'getBusinessMappingChild'])->name('business.mapping.child');

    //Route::post('/capacity-and-machineries-create-or-update', [BusinessProfileController::class, 'capacityAndMachineriesCreateOrUpdate'])->name('capacity-and-machineries.create-or-update');
    Route::post('/categories-produced-create-or-update', [BusinessProfileController::class, 'categoriesProducedCreateOrUpdate'])->name('categories.produced.create-or-update');
    Route::post('/machinery-details-create-or-update', [BusinessProfileController::class, 'machineryDetailsCreateOrUpdate'])->name('machinery.details.create-or-update');

    Route::post('/production-flow-and-manpower-create-or-update', [ProductionFlowAndManpowerController::class, 'productionFlowAndManpowerCreateOrUpdate'])->name('production-flow-and-manpower.create-or-update');

    Route::post('/business-term-create-or-update', [BusinessTermController::class, 'businessTermsCreateOrUpdate'])->name('business-terms.create-or-update');
    Route::post('/sampling-create-or-update', [SamplingController::class, 'samplingCreateOrUpdate'])->name('sampling.create-or-update');
    Route::post('/special-customization-create-or-update', [SpecialCustomizationController::class, 'specialCustomizationCreateOrUpdate'])->name('specialcustomizations.create-or-update');
    Route::post('/sustainability-commitment-create-or-update', [SustainabilityCommitmentController::class, 'sustainabilityCommitmentCreateOrUpdate'])->name('sustainabilitycommitments.create-or-update');
    Route::post('/worker-walfare-form-create-or-update', [WalfareController::class, 'walfareCreateOrUpdate'])->name('walfare.create-or-update');
    Route::post('/securtiy-create-or-update', [SecurityController::class, 'securityCreateOrUpdate'])->name('security.create-or-update');

    Route::post('/certification-details-upload', [CertificationController::class, 'certificationDetailsUpload'])->name('certification.upload');
    Route::get('/certification-details-delete', [CertificationController::class, 'deleteCertificate'])->name('certification.delete');

    Route::post('/factory-details-upload', [CertificationController::class, 'factoryDetailsUpload'])->name('factoryinfo.upload');
    Route::get('/factory-details-delete', [CertificationController::class, 'factoryDetailsDelete'])->name('factoryinfo.delete');

    Route::post('/main-buyers-details-upload', [MainBuyerController::class, 'mainBuyerDetailsUpload'])->name('mainbuyers.upload');
    Route::get('/main-buyers-details-delete', [MainBuyerController::class, 'deleteMainBuyer'])->name('mainbuyers.delete');

    Route::post('/export-destination-details-upload', [ExportDestinationController::class, 'exportDestinationDetailsUpload'])->name('exportdestinations.upload');
    Route::get('/export-destination-details-delete', [ExportDestinationController::class, 'deleteExportDestination'])->name('exportdestinations.delete');


    Route::post('/association-membership-details-upload', [AssociationMembershipController::class, 'associationMembershipDetailsUpload'])->name('associationmemberships.upload');
    Route::get('/association-membership-details-delete', [AssociationMembershipController::class, 'deleteAssociationMembership'])->name('associationmemberships.delete');

    Route::post('/press-highlight-details-upload', [PressHighlightController::class, 'pressHighLightDetailsUpload'])->name('presshighlights.upload');
    Route::get('/press-highlight-details-delete', [PressHighlightController::class, 'deletePressHighlight'])->name('presshighlights.delete');

    Route::post('/factory-tour',[CompanyFactoryTourController::class,'createFactoryTour'])->name('factory-tour.upload');
    Route::post('/factory-tour-edit',[CompanyFactoryTourController::class,'updateFactoryTour'])->name('factory-tour.edit');

    Route::get('/factory-tour-image-delete',[CompanyFactoryTourController::class,'factoryTourImageDelete'])->name('factory-image.delete');
    Route::get('/factory-tour-large-image-delete',[CompanyFactoryTourController::class,'factoryTourLargeImageDelete'])->name('factory-large-image.delete');
    Route::post('/terms-of-service-create-or-update',[BusinessProfileController::class,'termsOfServiceCreateOrUpdate'])->name('terms_of_service.create_or_update');

    //wholesaler  profile
    Route::group(['prefix'=>'/wholesaler'],function (){
        //product
        Route::get('/profile/{alias}', [ProfileInfoController::class, 'show'])->name('wholesaler.profile.show');
        Route::get('/profile/{alias}/products', [WholesalerProductController::class, 'index'])->name('wholesaler.product.index');
        Route::post('/product/store', [WholesalerProductController::class, 'store'])->name('wholesaler.product.store');
        Route::get('/product/edit/{sku}', [WholesalerProductController::class, 'edit'])->name('wholesaler.product.edit');
        Route::put('/product/update/{sku}', [WholesalerProductController::class, 'update'])->name('wholesaler.product.update');
        Route::get('/product/publish-unpublish/{sku}',[WholesalerProductController::class, 'publishUnpublish'])->name('wholesaler.product.publish.unpublish');
        //order
        Route::get('profile/{alias}/received-orders',[WholesalerOrderController::class, 'index'])->name('wholesaler.order.index');
        Route::get('order-delivered/{orderNumber}',[WholesalerOrderController::class, 'orderDelivered']);
        Route::get('order-type-filter', [WholesalerOrderController::class, 'orderTypeFilter'])->name('wholesaler.order.type.filter');
        //profile info
        Route::get('profile/{alias}/info',[ProfileInfoController::class,'index'])->name('wholesaler.profile.info');
        //remove overlay image
        Route::get('remove/overlay/image/{id}',[WholesalerProductController::class,'removeOverlayImage'])->name('remove.wholesaler.overlay.image');
        Route::get('remove/featured/video/{id}',[WholesalerProductController::class,'removeFeaturedVideo'])->name('remove.wholesaler.featured.video');
    });
    //business profile logo banner
    Route::post('businessprofile/logo-banner/create-or-update', [BusinessProfileController::class,'businessProfileLogoBannerCreateUpdate' ])->name('business.profile.logo.banner.create.update');
    //tinymc
    Route::post('tiny-mc-file-uplaod', [TinyMcController::class, 'tinyMcFileUpload'])->name('tinymc.file.upload');
    Route::get('tinymc-untracked-file-delete/{business_profile_id}',[TinyMcController::class, 'tinyMcUntrackedFileDelete'])->name('tinymc.untracked.file.delete');
    //endtinymc

    //my order
    Route::get('my-order',[MyOrderController::class, 'index'])->name('myorder');
    //rfq

    Route::get('my-rfq-by-page-no',[RfqController::class, 'myRfqByPageNumber'])->name('my.rfq.frontend.pagination');
    Route::post('rfq/store',[RfqController::class, 'store'])->name('rfq.store');
    Route::delete('rfq/delete/{rfq_id}',[RfqController::class, 'delete'])->name('rfq.delete');
    Route::get('rfq/active/{rfq_id}',[RfqController::class, 'active'])->name('rfq.active');
    Route::get('rfq/edit/{rfq_id}',[RfqController::class, 'edit'])->name('rfq.edit');
    Route::post('rfq/update/{rfq_id}',[RfqController::class, 'update'])->name('rfq.update');
    Route::get('rfq/single/image/delete/{rfq_image_id}',[RfqController::class, 'singleImageDelete'])->name('rfq.single.image.delete');
    Route::get('my-rfq',[RfqController::class, 'myRfq'])->name('rfq.my');
    Route::get('rfq/share/{rfq_id}',[RfqController::class, 'share'])->name('rfq.share');


    Route::post('rfq/store/from/product/details',[RfqController::class, 'storeFromProductDetails'])->name('rfq.store.from.product.details');

    //message center

    Route::get('/message-center',[MessageController::class,'message_center'])->name('message.center');
    Route::get('/message-center?uid={id}',[MessageController::class,'message_center_selected_supplier'])->name('sentBidReply');
    Route::post('/message-center/getchatdata',[MessageController::class,'getchatdata'])->name('message.center.getchatdata');
    Route::post('/message-center/updateuserlastactivity',[MessageController::class,'updateuserlastactivity'])->name('message.center.update.user.last.activity');
    Route::post('/message-center/notificationforuser',[MessageController::class,'notificationforuser'])->name('message.center.notification.user');
    Route::get('/merchant-message',[MessageController::class,'merchant_message']);
    Route::get('rfq-merchant-message',[MessageController::class,'rfq_merchant_message']);
    Route::get('/supplier-message',[MessageController::class,'supplier_message']);
    Route::get('/message-center/getUsers',[MessageController::class,'getUsers']);
    Route::get('/message-center/getMerchants',[MessageController::class,'getMerchants']);
    Route::get('/message-center/getSuppliers',[MessageController::class,'getSupplier']);
    Route::post('/message-center/getMessages',[MessageController::class,'getMessages']);
    Route::post('/message-center/send-message',[MessageController::class,'sendMessage']);
    Route::post('/message-center/contactwithsupplierfromprofile',[MessageController::class,'contactWithSupplierFromProfile']);
    Route::post('/message-center/contactsupplierfromproduct',[MessageController::class,'contactSupplierFromProduct'])->name('message.center.contact.supplier.from.product');
    Route::get('/message-center/get-rfq-merchants',[MessageController::class,'getRFQMerchants']);
    //bid rfq
    Route::get('rfq/bid/create/{rfq_id}',[RfqBidController::class, 'create'])->name('rfq.bid.create');
    Route::post('rfq/bid/store',[RfqBidController::class, 'store'])->name('rfq.bid.store');
    Route::get('/rfq-bid-notification-mark-as-read',[RfqBidController::class,'notificationMarkAsRead'])->name('bid-notification-mark-as-read');

    Route::post('query/bid/store',[QuerybidController::class, 'store'])->name('query.bid.store');

    //poforma
    Route::get('/po/add/toid={id}', [PoController::class, 'add'])->name('po.add');
    Route::get('/po/edit', [PoController::class, 'edit'])->name('po.edit');
    Route::post('/po/store', [PoController::class,'store'])->name('po.store');
    Route::get('/po',[PoController::class,'index'])->name('po.index');
    Route::get('/my-orders',[PoController::class,'myOrders'])->name('po.myorders');
    Route::get('/product-list-by-business-profile-id', [PoController::class, 'getProductListByBuisnessProfileId'])->name('product_list.by_profile_id');
    Route::get('/getsupplierbycat/{id}', [PoController::class, 'getsupplierbycat'])->name('getsupplierbycat');
    Route::get('/open-proforma-single-html/{id}', [PoController::class, 'openProformaSingleHtml'])->name('open.proforma.single.html');
    Route::post('/pro-forma-invoice-accept', [PoController::class, 'acceptProformaInvoice'])->name('accept.proforma.invoice');
    Route::post('/pro-forma-invoice-reject',[PoController::class, 'rejectProformaInvoice'])->name('reject.proforma.invoice');
    Route::get('/pro-forma-invoices',[PoController::class, 'proformaInvoices'])->name('proforma.invoice');
    Route::get('/open-proforma-single/{id}',[PoController::class, 'openProformaSingle'])->name('open.proforma.single');

    //active inactive business profile by user
    Route::get('businessprofile/delete/{businessprofileid}', [UsersManageBusinessProfileController::class, 'delete'])->name('business.profile.delete');
    Route::get('businessprofile/restore/{businessprofileid}', [UsersManageBusinessProfileController::class, 'restore'])->name('business.profile.restore');
   //alias
    Route::get('alias-existing-check',[BusinessProfileController::class, 'aliasExistingCheck'])->name('alias.existing.check');
    Route::post('alias-update',[BusinessProfileController::class, 'updateAlias'])->name('update.alias');

    Route::post('/send-request-for-profile-verification', [BusinessProfileBusinessProfileController::class, 'businessProfileVerificationRequest'])->name('business.profile.verification.request');

    //new business profile template routes
    Route::post('mail-send-to-auth-user', [RfqController::class, 'rfqMailTriggerForAuthUser'])->name('rfq.mailTriggerForAuthUser');
    Route::get('profile/{alias}/general-info', [BusinessProfileBusinessProfileController::class, 'index'])->name('new.profile.index');
    Route::get('profile/{alias}/rfqs', [RfqController::class, 'index'])->name('new.profile.rfqs');
    Route::get('profile/{alias}/my-rfqs', [RfqController::class, 'myRfqList'])->name('new.profile.my_rfqs');
    Route::get('profile/{alias}/search-my-rfqs', [RfqController::class, 'searchMyRfqList'])->name('new.profile.search_my_rfqs');
    Route::get('profile/{alias}/my-queries', [RfqController::class, 'myQueries'])->name('new.profile.my_queries');
    Route::get('profile/{alias}/search-my-queries', [RfqController::class, 'searchMyQueries'])->name('new.profile.search_my_queries');
    Route::get('profile/{alias}/all-queries', [RfqController::class, 'allQueries'])->name('new.profile.all_queries');
    Route::get('profile/{alias}/search-rfq', [RfqController::class, 'searchRfq'])->name('new.profile.search_rfqs'); // for explore
    Route::get('profile/{alias}/proforma-pending-orders', [ProformaOrderController::class, 'profomaPendingOrders'])->name('new.profile.profoma_orders.pending');
    Route::get('profile/{alias}/proforma-ongoing-orders', [ProformaOrderController::class, 'profomaOngoingOrders'])->name('new.profile.profoma_orders.ongoing');
    Route::get('profile/{alias}/proforma-shipped-orders', [ProformaOrderController::class, 'profomaShippedOrders'])->name('new.profile.profoma_orders.shipped');
    Route::get('profile/{alias}/proforma-search',[ProformaOrderController::class,'proformaSearchByTitle'])->name("new.profile.profoma_orders.search");
    Route::get('profile/{alias}/accept-proforma-orders/{proformaId}', [ProformaOrderController::class, 'acceptProformaOrder'])->name('new.profile.profoma_orders.accept');
    Route::post('profile/{alias}/reject-proforma-orders/{proformaId}', [ProformaOrderController::class, 'rejectProformaOrder'])->name('new.profile.profoma_orders.reject');

    Route::get('profile/{alias}/development-center', [BusinessProfileBusinessProfileController::class, 'developmentCenter'])->name('new.profile.development_center');
    Route::get('profile/{alias}/order-management', [BusinessProfileBusinessProfileController::class, 'orderManagement'])->name('new.profile.order_management');
    Route::get('profile/{alias}/products', [BusinessProfileBusinessProfileController::class, 'products'])->name('new.profile.products');

    Route::get('profile/{alias}/insights', [UserProfileController::class, 'profileInsights'])->name('new.profile.insights');
    Route::get('profile/{alias}/home', [UserProfileController::class, 'profileHome'])->name('new.profile.home');
    Route::get('profile/{alias}/profile-edit', [UserProfileController::class, 'profileEdit'])->name('new.profile.edit');
    //new message center template routes
    Route::get('rfq/quotations', [RfqController::class, 'authUserQuotationsByRFQId'])->name('auth_user_quotations.by_rfq_id');
    Route::get('rfq/my-quotations', [RfqController::class, 'myQuotationsByRFQId'])->name('my_quotation.by_rfq_id');
    Route::get('rfq/conversations', [RfqController::class, 'authUserConversationsByRFQId'])->name('auth_user_conversations.by_rfq_id');

});
Route::post('rfq/store/with/login',[RfqController::class, 'storeWithLogin'])->name('rfq.store.with.login');
Route::get('rfq/create/{flag?}/{productid?}',[RfqController::class, 'create'])->name('rfq.create');
//rfq show with shareable link
Route::get('rfq/{link}',[RfqController::class, 'showRfqUsingLink'])->name('show.rfq.using.link');
Route::get('sitemap',[HomeController::class, 'showSiteMap'])->name('show.site.map');

//user API's endpoint start
Route::group(['prefix'=>'/user'],function (){
    Route::get('/register/{type}', [UserController::class, 'showRegistrationForm'])->name('user.register');
    Route::post('/register', [UserController::class, 'create'])->name('users.create');
    Route::post('/login', [UserController::class, 'login'])->name('users.login');
    Route::get('/login', [UserController::class, 'showLoginForm'])->name('users.showLoginForm');
    Route::get('/login-from-sso', [UserController::class, 'loginFromSso'])->name('user.login.from.sso');
    Route::get('/verify/{token}', [UserController::class, 'verifyAccount'])->name('user.verify');
    Route::get('/unverified', [UserController::class, 'unverifiedAccount'])->name('user.unverify');
    Route::get('/profile', [UserController::class, 'profile'])->name('users.profile')->middleware(['auth', 'is_verify_email','sso.verified']);
    Route::get('/unverified', [UserController::class, 'unverifiedAccount'])->name('user.unverify');
    Route::post('/resend-verification-email', [UserController::class, 'resendVerificationEmail'])->name('resend.verification_email');
    Route::post('/logout', [UserController::class, 'logout'])->name('users.logout');
    Route::get('/related/products/{business_profile_id}', [UserController::class, 'relatedProducts'])->name('users.related.products');

    Route::get('/account-verification/{token}/{encryptedAuthInfo}', [UserController::class, 'anonymousUserAccountVerification'])->name('anonymous.user.account.verification');
    Route::post('/anonymous/password/reset', [UserController::class, 'anonymousPasswordUpdate'])->name('anonymous.password.update');
    Route::get('/account-verification-successful', [UserController::class, 'anonymousAccountVerificationSuccessful'])->name('anonymous.account.verification.successful');

});
Route::post('login-rfq-share-link',[RfqController::class, 'loginFromRfqShareLink'])->name('login.from.rfq.share.link');
//fresh order calcualte
Route::post('/fresh-order/calculate',[SellerProductController::class, 'freshOrderCalculate'])->name('fresh.order.calculate');
//product modification request
Route::get('order/modification/',[OrderModificationRequestController::class, 'index'])->name('ord.mod.req.index');
Route::get('order/modification/req/show/proposal/{id}',[OrderModificationRequestController::class, 'orderProposalShow'])->name('prod.mod.req.proposal.show');
Route::get('order/modification/req/comment/create/show/{id}',[OrderModificationRequestController::class, 'commentCreateShow'])->name('prod.mod.req.comment.create.show');
Route::post('order/modification/req',[OrderModificationRequestController::class, 'store'])->name('prod.mod.req.store');
Route::post('order/modification/replay/{id}',[OrderModificationRequestController::class, 'replay'])->name('order.mod.req.comment.replay');
Route::post('order/modification/create',[OrderModificationRequestController::class, 'createOrder'])->name('ord.mod.create.order');
Route::get('order/modification/create/{ord_mod_req_id}',[OrderModificationRequestController::class, 'ordModProposalCreateForm'])->name('order.mod.proposal.create.form');


// SSLCOMMERZ Start
Route::get('/payment/{order_no}', [SslCommerzPaymentController::class, 'exampleEasyCheckout'])->name('payment.page')->middleware('auth','sso.verified');
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);

// sso
Route::post('login-from-merchantbay',[UserController::class, 'loginFromMerchantbay']);
// end sso

//manufacture
Route::group(['prefix'=>'/manufacture'],function (){
    //product
    Route::post('product/store',[ManufactureProductController::class, 'store'])->name('manufacture.product.store');
    Route::get('product/edit/{product_id}',[ManufactureProductController::class, 'edit'])->name('manufacture.product.edit');
    Route::post('product/update/{product_id}',[ManufactureProductController::class, 'update'])->name('manufacture.product.update');
    Route::get('product/delete/{product_id}/{business_profile_id}',[ManufactureProductController::class, 'delete'])->name('manufacture.product.delete');
    Route::get('/product/publish-unpublish/{pid}/{bid}',[ManufactureProductController::class, 'publishUnpublish'])->name('manufacture.product.publish.unpublish');
    Route::get('remove/overlay/image/{id}',[ManufactureProductController::class,'removeOverlayImage'])->name('remove.manufacture.overlay.image');
    Route::get('remove/featured/video/{id}',[ManufactureProductController::class,'manufactureFeaturedVideo'])->name('remove.manufacture.featured.video');
    Route::get('remove/single/image/{id}',[ManufactureProductController::class,'removeSingleImage'])->name('remove.manufacture.single.image');


});




//SSLCOMMERZ END
// Frontend API's endpoint end
Route::group(['prefix'=>'/admin'],function (){
    // Admin API's endpoint start
    Route::get('/subscribed-user-list', [AdminController::class, 'subscribeUserListForNewsletter'])->name('newsletter.subscribed.user.list');
    Route::get('/config', [ConfigController::class,'configDashboard'])->name('admin.configdashboard');
    Route::post('/config', [ConfigController::class,'storeConfigurationInformation'])->name('store.configuration');
    Route::get('/config/{configId}', [ConfigController::class,'editConfigurationInformation'])->name('edit.configuration');
    Route::patch('/config/{configId}', [ConfigController::class,'updateConfigurationInformation'])->name('update.configuration');
    Route::get('/', [AdminController::class,'showLoginForm'])->name('admin.showLoginForm');
    Route::post('/login', [AdminController::class,'login'])->name('admin.login');
    Route::post('/logout', [AdminController::class,'logout'])->name('admin.logout');
    Route::get('/dashboard', [AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::get('/monthly-registered-users', [AdminController::class,'monthlyRegisteredUsers'])->name('monthly.registered.users');
    Route::get('/get-users',[AdminController::class, 'getUsersBasedOnSelectedParams'])->name('get.userslist.basedonselectedparams');
    Route::get('/last-active-users', [AdminController::class,'lastTwoWeeksActivedUsers'])->name('get.last.twoweeks.active.users');
    Route::get('/get-activeusers',[AdminController::class, 'getUsersBasedOnActivityParams'])->name('get.userslist.basedonactivityparams');
    //vendors API's endpoint start
    Route::group(['middleware'=> 'is.admin'],function () {
        Route::get('/vendors', [VendorController::class,'index'])->name('vendor.index');
        Route::get('/vendor/{vendor}', [VendorController::class,'show'])->name('vendor.show');
        Route::delete('/vendor/{vendor}', [VendorController::class,'destroy'])->name('vendor.destroy');
        Route::get('/vendors/inactive', [VendorController::class,'inactive'])->name('vendor.inactive.index');
        Route::get('/vendors/restore/{vendor}', [VendorController::class,'restore'])->name('vendor.restore');
        //prduct category resource API start
        Route::resource('product-categories',  ProductCategoryController::class);
        Route::get('findProductCategoryDropdownList',  [ProductCategoryController::class, 'productCategoryDropdownList']);
        //prduct API start
        Route::post('/upload', [ProductController::class,'uploadSubmit']);
        Route::get('/delete-single-image', [ProductController::class,'deleteSingleImage']);
        Route::get('/businessProfile/{businessProfileId}/products', [ProductController::class,'index'])->name('product.index');
        Route::get('/businessProfile/{businessProfileId}/product/create', [ProductController::class,'create'])->name('product.create');
        Route::post('/businessProfile/{businessProfileId}/product', [ProductController::class,'store'])->name('product.store');
        Route::get('/businessProfile/{businessProfileId}/product/{product}/edit', [ProductController::class,'edit'])->name('product.edit');
        Route::post('/businessProfile/{businessProfileId}/product/{product}', [ProductController::class,'update'])->name('product.update');
        Route::delete('/businessProfile/{businessProfileId}/product/{product}', [ProductController::class,'destroy'])->name('product.destroy');
        Route::get('/related/products', [ProductController::class, 'relatedProducts'])->name('admin.users.related.products');
        //vendor order
        Route::get('orders',[OrderController::class, 'orderList'])->name('admin.orders.index');
        Route::get('/businessProfile/{businessProfileId}/orders',[OrderController::class, 'index'])->name('vendor.order.index');
        // Route::get('/vendor/{vendor}/order/create',[OrderController::class, 'create'])->name('vendor.order.create');
        // Route::post('/vendor/{vendor}/order',[OrderController::class, 'store'])->name('vendor.order.store');
        // Route::get('/vendor/{vendor}/order/{order}',[OrderController::class, 'show'])->name('vendor.order.show');
        // Route::get('/vendor/{vendor}/order/{order}/notification/{notification}',[OrderController::class, 'showFromNotifaction'])->name('vendor.order.show.notification');
        // Route::get('/vendor/{vendor}/order/{order}/edit',[OrderController::class, 'edit'])->name('vendor.order.edit');
        // Route::post('/vendor/{vendor}/order/{order}', [OrderController::class,'update'])->name('vendor.order.update');
        // Route::delete('/vendor/{vendor}/order/{order}', [OrderController::class,'destroy'])->name('vendor.order.destroy');
        // Route::get('/order/update/{id}', [OrderController::class, 'OrderUpdateByAdmin'])->name('order.updateby.admin');
        // Route::get('/order/update/status/delivered/{id}', [OrderController::class, 'statusToDelivered'])->name('order.status.change.delivered');
        // Route::get('/order/ask/payment/{order_no}', [OrderController::class, 'OrderAskPayment'])->name('order.ask.payment');
        //order queries
        Route::get('query/request/{type}',[QueryController::class, 'index'])->name('query.request.index');
       // Route::get('query/request/edit/{type}',[QueryController::class, 'edit'])->name('query.request.edit');
        Route::post('query/request/store',[QueryController::class, 'store'])->name('query.request.store');
        Route::post('query/request/comment',[QueryController::class, 'comment'])->name('query.request.comment');
        Route::get('query/modification/request/edit/{type}',[QueryController::class, 'editModificationRequest'])->name('query.modification.request.edit');

        Route::get('query/edit/{id}',[QueryController::class, 'edit'])->name('query.edit');
        Route::get('query/show/{id}',[QueryController::class, 'show'])->name('query.show');
        // uom, shipping-method, shipment-type, shipping-charge controller
        Route::resource('uom', UomContorller::class);
        Route::resource('payment-term', PaymentTermController::class);
        Route::resource('shipping-method', ShippingMethodController::class);
        Route::resource('shipment-type', ShipmentTypeController::class);
        Route::resource('shipment-term', ShipmentTermController::class);
        Route::get('shipping-charge/change/status/{order_id}', [ShippingChargeController::class, 'changeStatus'])->name('shipping.charge.change.status');
        Route::resource('shipping-charge', ShippingChargeController::class);
        Route::resource('merchant-assistances', MerchantAssistanceController::class);

        // Blogs api start
        Route::resource('blogs', BlogController::class);
        Route::resource('newsletter', NewsletterController::class);
        Route::get('newsletter/show/{id}', [NewsletterController::class, 'show'])->name('admin.newsletter.show');

        //profroma terms and conditions
        Route::resource('proforma-terms-and-conditions', ProFormaTermAndConditionController::class);

        // Route::get('/proforma-invoices',[AdminProFormaInvoiceController::class,'index'])->name('proforma_invoices.index');
        // Route::get('/proforma-invoices/{proformaInvoice}',[AdminProFormaInvoiceController::class,'show'])->name('proforma_invoices.show');
        Route::get('/proforma-invoices',[AdminPoController::class,'index'])->name('proforma_invoices.index');
        Route::get('/proforma-invoices/{proformaInvoice}',[AdminPoController::class,'show'])->name('proforma_invoices.show');
        Route::get('/proforma-invoice/create/buyer/{buyerId}/rfq/{rfqId}',[AdminPoController::class,'create'])->name('proforma_invoices.create');
        Route::get('/proforma-invoice/create/buyer/{buyerId}/rfq/{rfqId}/proforma-id/{proformaId}/edit',[AdminPoController::class,'edit'])->name('proforma_invoices.edit');
        Route::post('/proforma-invoice/store',[AdminPoController::class,'store'])->name('proforma_invoices.store');
        Route::post('/proforma-invoice/update-buyer-info',[AdminPoController::class,'updateBuyerInfo'])->name('proforma_invoices.update.buyer.info');
        //users
        Route::get('users',[AdminUserController::class, 'index'])->name('users.index');
        Route::get('user/{id}',[AdminUserController::class, 'show'])->name('user.show');
        Route::get('user/business/profile/details/{profile_id}',[AdminUserController::class, 'businessProfileDetails'])->name('business.profile.details');
        Route::post('user/company/overview/varifie/{company_overview_id}',[AdminBusinessProfileController::class, 'companyOverviewVarifie'])->name('company.overview.varifie');
        Route::get('users/verification/list',[AdminUserController::class, 'verifiedUserRequestList'])->name('verified.user.request.list');
        Route::get('update/user/verification/request',[AdminUserController::class, 'updateUserVerificationRequest'])->name('update.user.verification.request');
        Route::get('export/subscrbed/users/email',[AdminUserController::class, 'exportSubscribedUsersEmail'])->name('export.subscribed.users.email');
        // Route::post('user/business/profile/capacity-machineries/verify',[AdminBusinessProfileController::class, 'capacityAndMachineriesInformationVerify'])->name('capacity.machineries.verify');

        Route::post('user/business/profile/ctegories-produced/verify',[AdminBusinessProfileController::class, 'ctegoriesProducedInformationVerify'])->name('ctegories.produced.verify');
        Route::post('user/business/profile/machinaries-details/verify',[AdminBusinessProfileController::class, 'machinariesDetailsInformationVerify'])->name('machinaries.details.verify');

        Route::post('user/business/profile/capacity-terms/verify',[AdminBusinessProfileController::class, 'businessTermsInformationVerify'])->name('business.terms.verify');
        Route::post('user/business/profile/samplings/verify',[AdminBusinessProfileController::class, 'samplingsInformationVerify'])->name('samplings.verify');
        Route::post('user/business/profile/special-customization/verify',[AdminBusinessProfileController::class, 'specialCustomizationInformationVerify'])->name('special.customizations.verify');
        Route::post('user/business/profile/sustainability-commitments/verify',[AdminBusinessProfileController::class, 'sustainabilityCommitmentsInformationVerify'])->name('sustainability.commitments.verify');
        Route::post('user/business/profile/productionflow-manpower/verify',[AdminBusinessProfileController::class, 'productionflowAndManpowerInformationVerify'])->name('productionflow.manpower.verify');
        Route::post('user/business/profile/walfare/verify',[AdminBusinessProfileController::class, 'walfareInformationVerify'])->name('worker.walfare.verify');
        Route::post('user/business/profile/security/verify',[AdminBusinessProfileController::class, 'securityInformationVerify'])->name('worker.security.verify');
        Route::get('/user/business/profile/verify',[AdminBusinessProfileController::class, 'verifyBusinessProfile'])->name('business.profile.verify');
        Route::get('/user/business/profile/spotlight',[AdminBusinessProfileController::class, 'spotlightBusinessProfile'])->name('business.profile.spotlight');
        //order through business profile
        Route::get('business-profile/{business_profile_id}/orders',[OrderController::class, 'index'])->name('business.profile.orders.index');
        // Route::get('/vendor/{vendor}/order/create',[OrderController::class, 'create'])->name('vendor.order.create');
        // Route::post('/vendor/{vendor}/order',[OrderController::class, 'store'])->name('vendor.order.store');
        Route::get('business-profile/{business_profile_id}/order/{order_id}',[OrderController::class, 'show'])->name('business.profile.order.show');
        Route::get('business-profile/{businessProfile}/order/{order}/notification/{notification}',[OrderController::class, 'showFromNotifaction'])->name('vendor.order.show.notification');
        // Route::get('/vendor/{vendor}/order/{order}/edit',[OrderController::class, 'edit'])->name('vendor.order.edit');
        // Route::post('/vendor/{vendor}/order/{order}', [OrderController::class,'update'])->name('vendor.order.update');
        // Route::delete('/vendor/{vendor}/order/{order}', [OrderController::class,'destroy'])->name('vendor.order.destroy');
        Route::get('/order/update/{id}', [OrderController::class, 'OrderUpdateByAdmin'])->name('order.updateby.admin');
        Route::get('/order/update/status/delivered/{id}', [OrderController::class, 'statusToDelivered'])->name('order.status.change.delivered');
        Route::get('/order/ask/payment/{order_no}', [OrderController::class, 'OrderAskPayment'])->name('order.ask.payment');
        // Certification
        Route::resource('certification',AdminCertificationController::class, [
            'as' => 'admin'
        ]);
        //active inactive business profile
        Route::get('admin/businessprofile/delete/{businessprofileid}', [ManageBusinessProfileController::class, 'delete'])->name('admin.business.profile.delete');
        Route::get('admin/businessprofile/restore/{businessprofileid}', [ManageBusinessProfileController::class, 'restore'])->name('admin.business.profile.restore');
        Route::get('business-profile-verification-list',[AdminBusinessProfileController::class, 'showBusinessProfileVerificationRequest'])->name('verification.request.index');
        //rfq
        Route::put('rfq/status/{id}',[AdminRfqController::class, 'status'])->name('admin.rfq.status');
        Route::get('rfq/profile/shortlist',[AdminRfqController::class, 'profileShortList'])->name('admin.rfq.profile.shortlist');
        Route::get('rfq/show/{id}/{link?}/{type?}', [AdminRfqController::class, 'show'])->name('admin.rfq.show');
        Route::resource('rfq',AdminRfqController::class, ['as' => 'admin'])->except([
            'show'
        ]);
        Route::get('rfq-chat-data-by-supplier-id',[AdminRfqController::class, 'getChatDataBySupplierId'])->name('getchatdata.by.supplierid');

        Route::get('admin/rfq/pagination',[AdminRfqController::class, 'fetchRFQsByQueryStringOrPagination'])->name('rfq.pagination');
        Route::get('admin/rfq/send-push-notification-for-new-message-to-admin',[AdminRfqController::class, 'sendFireBasePushNotificationToAdminForNewMessage'])->name('send_firebase_push_notification_to_admin_for_rfq_message');
        Route::get('admin/rfq/send-push-notification-for-new-message-to-all-admin',[AdminRfqController::class, 'sendFireBasePushNotificationToAllAdminForNewMessage'])->name('send_firebase_push_notification_to_all_admin_for_rfq_message');
        Route::get('admin/rfq/business-profile-with-unseen-message',[AdminRfqController::class, 'businessProfilesWithUnseenMessageCount'])->name('admin_rfq_business_profiles_with_unseen_message');


        //Route::get('rfqs',[BackendRfqController::class, 'index'])->name('admin.rfq.index');
        Route::get('business-profile-filter-by-category-or-rating',[AdminRfqController::class, 'businessProfileFilter'])->name('admin.rfq.business.profiles.filter');
        Route::get('business-profile-filter-by-title',[AdminRfqController::class, 'businessProfileFilterByTitle'])->name('admin.rfq.business.profiles.filter.by.title');
        Route::get('supplier-quotation-to-buyer',[AdminRfqController::class, 'supplierQuotationToBuyer'])->name('admin.rfq.supplier.quotation.to.buyer');
        Route::get('message-center/getchatdata',[AdminMessageController::class,'getchatdata'])->name('admin.message.center.getchatdata');
        Route::get('/message-center/getsupplierchatdata',[AdminMessageController::class,'getSupplierChatData'])->name('admin.message.center.getsupplierchatdata');
        //new users requests
        Route::get('new/user/request/{type}', [NewUserRequestController::class, 'index'])->name('new.user.request');
        Route::get('new/user/request/edit/{id}', [NewUserRequestController::class, 'edit'])->name('new.user.request.edit');
        Route::put('new/user/request/update/{id}', [NewUserRequestController::class, 'update'])->name('new.user.request.update');
        //business profile
        Route::get('business-profile/{type}',[AdminBusinessProfileController::class, 'index'])->name('admin.business.profile.list.type');
        Route::get('business-profile/details/{business_profile_id}',[AdminBusinessProfileController::class, 'businessProfileDetails'])->name('admin.business.profile.details');
        //products
        Route::get('products',[ProductController::class, 'index'])->name('admin.products.index');
        Route::get('product/show/{flag}/{id}',[ProductController::class, 'show'])->name('admin.products.show');
        Route::get('product/change/priority-level/{flag}/{id}',[ProductController::class, 'changePriorityLevel'])->name('admin.product.change.priority.level');
        //product type mapping
        Route::resource('product-type-mapping',ProductTypeMappingController::class,['as' => 'admin'])->except('show');
        //business mapping tree
        Route::resource('business-mapping-tree',BusinessMappingTreeController::class,['as' => 'admin'])->except('show');
        Route::resource('product-tag',ProductTagController::class,['as' => 'admin'])->except('show');

    });

});
Route::get('/{alias}',[HomeController::class, 'supplierProfile'])->name('supplier.profile')->middleware('auth');
// product type mapping
Route::get('/{product_type_mapping}/{child}',[HomeController::class, 'productTypeMapping'])->name('product.type.mapping');
Route::post('/get-request-from-user-for-verification',[HomeController::class, 'getRequestFromUserForVerification'])->name('get.request.from.user.for.verification');





