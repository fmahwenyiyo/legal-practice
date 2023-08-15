<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdvocateController;
use App\Http\Controllers\BenchController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\CauseController;
use App\Http\Controllers\CountryStateCityController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\HighCourtController;
use App\Http\Controllers\ToDoController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\TimeSheetController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DoctypeController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\PaystackPaymentController;
use App\Http\Controllers\FlutterwavePaymentController;
use App\Http\Controllers\RazorpayPaymentController;
use App\Http\Controllers\MercadoPaymentController;
use App\Http\Controllers\PaytmPaymentController;
use App\Http\Controllers\MolliePaymentController;
use App\Http\Controllers\SkrillPaymentController;
use App\Http\Controllers\CoingatePaymentController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PlanRequestController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BankTransferController;
use App\Http\Controllers\PayfastController;
use App\Http\Controllers\PaymentWallController;
use App\Http\Controllers\ToyyibpayController;
use App\Models\User;


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


// Route::get('/dashboard', function () {
//     // $companyRole = Role::find(4);
//     // $company = User::find(1);

//     // $company->assignRole($companyRole);

//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('optimize:clear');

    return redirect()->back()->with('success', __('Clear Cache successfully.'));
});

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


Route::group(['middleware'=>['auth','XSS','verified']], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);

    Route::resource('users', UserController::class);
    Route::get('users-list', [UserController::class, 'userList'])->name('users.list');
    Route::post('users/{id}/change-password',[UserController::class,'changeMemberPassword'])->name('member.change.password');
    Route::get('user/{id}/plan', [UserController::class, 'upgradePlan'])->name('plan.upgrade')->middleware(['auth', 'XSS']);
    Route::get('user/{id}/plan/{pid}', [UserController::class, 'activePlan'])->name('plan.active')->middleware(['auth', 'XSS']);
    Route::any('company-reset-password/{id}', [UserController::class, 'companyPassword'])->name('company.reset');


    Route::resource('teams', TeamController::class);

    Route::resource('groups', GroupController::class);

    Route::resource('advocate', AdvocateController::class);
    Route::get('/advocate/contacts/{id}', [AdvocateController::class, 'contacts'])->name('advocate.contacts');
    Route::get('/advocate/bills/{id}', [AdvocateController::class, 'bills'])->name('advocate.bill');
    Route::get('/get-country', [CountryStateCityController::class, 'getCountry'])->name('get.country');
    Route::post('/get-state', [CountryStateCityController::class, 'getState'])->name('get.state');
    Route::post('/get-city', [CountryStateCityController::class, 'getCity'])->name('get.city');

    Route::resource('courts', CourtController::class);

    Route::resource('highcourts', HighCourtController::class);

    Route::resource('bench', BenchController::class);

    Route::resource('cause', CauseController::class);
    Route::post('/cause/get-highcourts', [CauseController::class, 'getHighCourt'])->name('get.highcourt');
    Route::post('/cause/get-bench', [CauseController::class, 'getBench'])->name('get.bench');

    Route::resource('cases', CaseController::class);

    Route::resource('to-do', ToDoController::class);
    Route::get('to-do/status/{id}', [ToDoController::class, 'status'])->name('to-do.status');
    Route::PUT('to-do/status-update/{id}', [ToDoController::class, 'statusUpdate'])->name('to-do.status.update');

    Route::resource('bills', BillController::class);
    Route::get('bills/addpayment/{bill_id}', [BillController::class,'paymentcreate'])->name('create.payment');
    Route::POST('bills/storepayment/{bill_id}', [BillController::class,'paymentstore'])->name('payment.store');


    Route::resource('taxs', TaxController::class);
    Route::post('taxs/get-tax/', [TaxController::class, 'getTax'])->name('get.tax');

    Route::resource('casediary', DiaryController::class);

    Route::resource('timesheet', TimeSheetController::class);

    Route::resource('expenses', ExpenseController::class);

    Route::resource('fee-receive', FeeController::class);

    Route::resource('calendar', CalendarController::class);

    Route::resource('documents', DocumentController::class);

    Route::resource('doctype', DoctypeController::class);

    Route::resource('settings', SettingController::class);
    Route::post('storage-settings',[SettingController::class,'storageSettingStore'])->name('storage.setting.store');


    Route::get('change-language/{lang}', [LanguageController::class, 'changeLanquage'])->name('change.language');
    Route::get('manage-language/{lang}', [LanguageController::class, 'manageLanguage'])->name('manage.language');
    Route::post('store-language-data/{lang}', [LanguageController::class, 'storeLanguageData'])->name('store.language.data');
    Route::get('create-language', [LanguageController::class, 'createLanguage'])->name('create.language');
    Route::post('store-language', [LanguageController::class, 'storeLanguage'])->name('store.language');
    Route::delete('destroy-language/{lang}', [LanguageController::class, 'destroyLang'])->name('destroy.language');

    Route::post('cookie-setting', [SettingController::class, 'saveCookieSettings'])->name('cookie.setting');
    Route::post('email-settings', [SettingController::class,'saveEmailSettings'])->name('email.settings');
    Route::get('test', [SettingController::class,'testMail'])->name('test.mail');
    Route::post('test-mail', [SettingController::class,'testSendMail'])->name('test.send.mail');
    Route::post('setting/seo', [SettingController::class, 'SeoSettings'])->name('seo.settings');




    Route::post('recaptcha-settings', [SettingController::class, 'recaptchaSettingStore'])->name('recaptcha.settings.store');

    Route::resource('plans', PlanController::class);

    Route::get('system-settings', [SettingController::class, 'adminSettings'])->name('admin.settings');
    Route::post('business-setting', [SettingController::class,'saveBusinessSettings'])->name('business.setting');

    Route::get('plan_request',[PlanRequestController::class,'index'])->name('plan_request.index');
    Route::get('/payment/{code}', [PlanController::class, 'payment'])->name('payment');
    Route::get('request_send/{id}', [PlanRequestController::class,'userRequest'])->name('send.request');
    Route::get('request_cancel/{id}', [PlanRequestController::class,'cancelRequest'])->name('request.cancel');
    Route::get('request_response/{id}/{response}', [PlanRequestController::class,'acceptRequest'])->name('response.request');

    Route::resource('coupons', CouponController::class);

    Route::get('/orders', [StripePaymentController::class, 'index'])->name('order.index');
    Route::get('/apply-coupon', [CouponController::class,'applyCoupon'])->name('apply.coupon');

    Route::post('/stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');

    Route::post('plan-pay-with-paypal', [PaypalController::class, 'planPayWithPaypal'])->name('plan.pay.with.paypal');
    Route::get('{id}/{amount}/plan-get-payment-status', [PaypalController::class, 'planGetPaymentStatus'])->name('plan.get.payment.status');

    Route::post('/plan-pay-with-paystack', [PaystackPaymentController::class, 'planPayWithPaystack'])->name('plan.pay.with.paystack');
    Route::get('/plan/paystack/{pay_id}/{plan_id}/', [PaystackPaymentController::class, 'getPaymentStatus'])->name('plan.paystack');

    Route::post('/plan-pay-with-flaterwave', [FlutterwavePaymentController::class, 'planPayWithFlutterwave'])->name('plan.pay.with.flaterwave');
    Route::get('/plan/flaterwave/{txref}/{plan_id}', [FlutterwavePaymentController::class, 'getPaymentStatus'])->name('plan.flaterwave');

    Route::post('/plan-pay-with-razorpay', [RazorpayPaymentController::class, 'planPayWithRazorpay'])->name('plan.pay.with.razorpay');
    Route::get('/plan/razorpay/{txref}/{plan_id}', [RazorpayPaymentController::class, 'getPaymentStatus'])->name('plan.razorpay');

    Route::post('/plan-pay-with-paytm', 'App\Http\Controllers\PaytmPaymentController@planPayWithPaytm')->name('plan.pay.with.paytm');
    Route::post('/plan/paytm/{plan_id}', [PaytmPaymentController::class, 'getPaymentStatus'])->name('plan.paytm');

    Route::post('/plan-pay-with-mercado', [MercadoPaymentController::class, 'planPayWithMercado'])->name('plan.pay.with.mercado');
    Route::get('/plan/mercado/{plan}/{amount}', [MercadoPaymentController::class, 'getPaymentStatus'])->name('plan.mercado');

    Route::post('/plan-pay-with-mollie', [MolliePaymentController::class, 'planPayWithMollie'])->name('plan.pay.with.mollie');
    Route::get('/plan/mollie/{plan}', [MolliePaymentController::class, 'getPaymentStatus'])->name('plan.mollie');

    Route::post('/plan-pay-with-skrill', [SkrillPaymentController::class, 'planPayWithSkrill'])->name('plan.pay.with.skrill');
    Route::get('/plan/skrill/{plan_id}', [SkrillPaymentController::class, 'getPaymentStatus'])->name('plan.skrill');

    Route::post('/plan-pay-with-coingate', [CoingatePaymentController::class, 'planPayWithCoingate'])->name('plan.pay.with.coingate');
    Route::get('/plan/coingate/{plan}', [CoingatePaymentController::class, 'getPaymentStatus'])->name('plan.coingate');

    Route::post('/planpayment', [PaymentWallController::class, 'planpay'])->name('paymentwall');
    Route::post('/paymentwall-payment/{plan}', [PaymentWallController::class, 'planPayWithPaymentWall'])->name('paymentwall.payment');
    Route::get('/plan/error/{flag}', [PaymentWallController::class, 'planerror'])->name('error.plan.show');

    Route::post('/plan-pay-with-toyyibpay', [ToyyibpayController::class, 'planPayWithToyyibpay'])->name('plan.pay.with.toyyibpay');
    Route::get('/plan-pay-with-toyyibpay/{id}/{amount}/{couponCode?}', [ToyyibpayController::class, 'planGetPaymentStatus'])->name('plan.toyyibpay');

    Route::post('payfast-plan', [PayfastController::class, 'index'])->name('payfast.payment')->middleware(['auth']);
    Route::get('payfast-plan/{success}', [PayfastController::class, 'success'])->name('payfast.payment.success')->middleware(['auth']);

    Route::post('plan-pay-with-bank', [BankTransferController::class, 'planPayWithbank'])->name('plan.pay.with.bank');
    Route::get('orders/show/{id}', [BankTransferController::class, 'show'])->name('order.show');
    Route::delete('/bank_transfer/{order}/', [BankTransferController::class, 'destroy'])->name('bank_transfer.destroy');
    Route::any('order_approve/{id}', [BankTransferController::class, 'orderapprove'])->name('order.approve');
    Route::any('order_reject/{id}', [BankTransferController::class, 'orderreject'])->name('order.reject');

    Route::post('pusher-setting', [SettingController::class, 'savePusherSettings'])->name('pusher.setting');
    Route::get('/advocate/view/{id}', [AdvocateController::class, 'view'])->name('advocate.view');

    Route::post('setting/google-calender', [SettingController::class, 'saveGoogleCalenderSettings'])->name('google.calender.settings');
    Route::post('data/get_all_data', [CalendarController::class, 'get_call_data'])->name('call.get_call_data');

});
Route::any('/cookie-consent', [SettingController::class, 'CookieConsent'])->name('cookie-consent');

Route::post('payment-setting', [SettingController::class, 'savePaymentSettings'])->name('payment.settings')->middleware(['auth','verified']);
Route::post('admin-payment-setting', [SettingController::class, 'saveAdminPaymentSettings'])->name('admin.payment.settings')->middleware(['auth','verified']);


Route::get('/bills/pay/{bill_id}', [BillController::class, 'payinvoice'])->name('pay.invoice')->middleware(['XSS']);

Route::post('bills/{id}/payment', [StripePaymentController::class, 'addpayment'])->name('invoice.payment')->middleware(['XSS']);

Route::post('bills/{id}/bill-with-paypal', [PaypalController::class,'PayWithPaypal'])->name('bill.with.paypal')->middleware(['XSS']);
Route::get('{id}/get-payment-status/{amount}', [PaypalController::class,'GetPaymentStatus'])->name('get.payment.status')->middleware(['XSS']);

Route::post('/invoice-pay-with-paystack', [PaystackPaymentController::class, 'invoicePayWithPaystack'])->name('invoice.pay.with.paystack')->middleware(['XSS']);
Route::get('/invoice/paystack/{invoice_id}/{amount}/{pay_id}', [PaystackPaymentController::class, 'getInvoicePaymentStatus'])->name('invoice.paystack')->middleware(['XSS']);

Route::post('/invoice-pay-with-flaterwave', [FlutterwavePaymentController::class, 'invoicePayWithFlutterwave'])->name('invoice.pay.with.flaterwave')->middleware(['XSS']);
Route::get('/invoice/flaterwave/{txref}/{invoice_id}', [FlutterwavePaymentController::class, 'getInvoicePaymentStatus'])->name('invoice.flaterwave')->middleware(['XSS']);

Route::post('/invoice-pay-with-razorpay', [RazorpayPaymentController::class, 'invoicePayWithRazorpay'])->name('invoice.pay.with.razorpay')->middleware(['XSS']);
Route::get('/invoice/razorpay/{txref}/{invoice_id}', [RazorpayPaymentController::class, 'getInvoicePaymentStatus'])->name('invoice.razorpay');

Route::post('/invoice-pay-with-mercado', [MercadoPaymentController::class, 'invoicePayWithMercado'])->middleware(['XSS'])->name('invoice.pay.with.mercado');
Route::any('/invoice/mercado/{invoice}', [MercadoPaymentController::class, 'getInvoicePaymentStatus'])->name('invoice.mercado')->middleware(['XSS']);

Route::post('/invoice-pay-with-paytm', [PaytmPaymentController::class, 'invoicePayWithPaytm'])->middleware(['XSS'])->name('invoice.pay.with.paytm');
Route::post('/invoice/paytm/{invoice}', [PaytmPaymentController::class, 'getInvoicePaymentStatus'])->name('invoice.paytm')->middleware(['XSS']);

Route::post('/invoice-pay-with-mollie', [MolliePaymentController::class, 'invoicePayWithMollie'])->middleware(['XSS'])->name('invoice.pay.with.mollie');
Route::get('/invoice/mollie/{invoice}', [MolliePaymentController::class, 'getInvoicePaymentStatus'])->name('invoice.mollie')->middleware(['XSS']);

Route::post('/invoice-pay-with-skrill', [SkrillPaymentController::class, 'invoicePayWithSkrill'])->middleware(['XSS'])->name('invoice.pay.with.skrill');
Route::get('/invoice/skrill/{invoice}', [SkrillPaymentController::class, 'getInvoicePaymentStatus'])->name('invoice.skrill')->middleware(['XSS']);

Route::post('/invoice-pay-with-coingate', [CoingatePaymentController::class, 'invoicePayWithCoingate'])->middleware(['XSS'])->name('invoice.pay.with.coingate');
Route::get('/invoice/coingate/{invoice}', [CoingatePaymentController::class, 'getInvoicePaymentStatus'])->name('invoice.coingate')->middleware(['XSS']);

Route::post('/invoicepayment', [PaymentWallController::class, 'invoicePayWithPaymentwall'])->name('paymentwall.invoice');
Route::post('/invoice-pay-with-paymentwall/{invoice}', [PaymentWallController::class, 'getInvoicePaymentStatus'])->name('invoice-pay-with-paymentwall');
Route::any('/invoice/error/{flag}/{invoice_id}', [PaymentWallController::class, 'invoiceerror'])->name('error.invoice.show');

Route::post('/invoice-with-toyyibpay', [ToyyibpayController::class, 'invoicepaywithtoyyibpay'])->name('invoice.with.toyyibpay');
Route::get('/invoice-toyyibpay-status/{amount}/{invoice_id}', [ToyyibpayController::class, 'invoicetoyyibpaystatus'])->name('invoice.toyyibpay.status');

Route::post('/invoice-with-payfast', [PayfastController::class, 'invoicepaywithpayfast'])->name('invoice.with.payfast');
Route::get('/invoice-payfast-status/{invoice_id}', [PayfastController::class, 'invoicepayfaststatus'])->name('invoice.payfast.status');

Route::any('/pay-with-bank', [BankTransferController::class, 'invoicePayWithbank'])->name('invoice.pay.with.bank');
Route::get('bankpayment/show/{id}', [BankTransferController::class, 'bankpaymentshow'])->name('bankpayment.show');
Route::delete('invoice/bankpayment/{id}/delete', [BankTransferController::class, 'invoicebankPaymentDestroy'])->name('invoice.bankpayment.delete');
Route::post('/invoice/status/{id}', [BankTransferController::class, 'invoicebankstatus'])->name('invoice.status');
