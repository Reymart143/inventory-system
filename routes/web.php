<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\CustomerOrdersController;
use App\Http\Controllers\OutOfStockController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\CriticalProductsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\DailyUsageController;

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
// redirect / link
    Route::get('/login', function () {
        if (Auth::check()) {
            return redirect()->intended(route('dashboard'));
        }
        return view('auth.login');
    })->name('login');
    // redirect login link
    Route::get('/', function () {
    if (Auth::check()) {
            return redirect()->intended(route('dashboard'));
        }
        return view('auth.login');
    });

    Route::get('/register', [RegisterController::class, 'index']);
    Route::post('register', [RegisterController::class, 'register'])->name('auth.register');

// ----------------------For all role routes -------------------------//
    Route::post('/Credlogin', [LoginController::class, 'login'])->name('Credlogin');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/account/update', [ProfileController::class, 'updateAccount'])->name('account.update');
    Route::put('/emergency-contact', [ProfileController::class, 'updateEmergencyContact'])->name('emergency.contact.update');

// -------------------------- admin side Only ----------------------------------- //
Route::middleware('admin')->group(function(){
    // My products
    Route::get('products/index',[ProductController::class,'index'])->name('products.index');
    Route::post('/create-product',[ProductController::class,'add_product']);
    Route::get('/product/edit/{id}/',[ProductController::class, 'edit_product']);
    Route::post('/product/update/',[ProductController::class, 'update_product'])->name('product.update');
    Route::delete('delete/{id}',[ProductController::class,'delete_product']);

    Route::post('/product.excel',[ProductController::class,'import'])->name('product.excel');
    Route::post('/customerorder.excel',[CustomerOrdersController::class,'CustomerOrderImport'])->name('customerorder.excel');
    // Manage Users
    Route::resource('users', UserController::class);
    Route::patch('/users/{id}/status', [UserController::class, 'updateStatus'])->name('users.updateStatus');
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/out-of-stocks', [OutOfStockController::class, 'index'])->name('out-of-stocks');
    Route::get('/critical-products', [CriticalProductsController::class, 'index']);
    /////////
    Route::resource('items', ItemController::class);
    //daily usage
    Route::get('dailyusage/index',[DailyUsageController::class,'index'])->name('dailyusage.index');
    Route::get('/dailyusage/create',[DailyUsageController::class,'create'])->name('dailyusage.create');
    Route::get('/product/info/{id}', [DailyUsageController::class, 'getProductInfo']);
    Route::post('/dailyusage.store',[DailyUsageController::class,'store'])->name('dailyusage.store');
    Route::get('/dailyusage.edit/{id}/',[DailyUsageController::class, 'edit'])->name('dailyusage.edit');
    Route::put('/dailyusage/update/',[DailyUsageController::class, 'update'])->name('dailyusage.update');
    Route::delete('dailyusage.destroy/{id}',[DailyUsageController::class,'destroy'])->name('dailyusage.destroy');
});
// -------------------------- for both staff and seller -------------------//
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('/stock-in-products', [StockInController::class, 'index'])->name('stock-in-products');
    Route::get('/customer-orders', [CustomerOrdersController::class, 'index'])->name('customer-orders');
// -------------------------- for both staff and admin -------------------//
    Route::get('/get-product-details/{id}', [StockInController::class, 'getProductDetails']);
    Route::post('/stockin-product',[StockInController::class,'stockin_product']);
    Route::get('/abc.index', [ReportsController::class, 'indexABC'])->name('abc.index');
    Route::get('/forecasting.index', [ReportsController::class, 'indexForecasting'])->name('forecasting.index');
    Route::get('/eoq.index', [ReportsController::class, 'indexEOQ'])->name('eoq.index');
    Route::get('/rop.index', [ReportsController::class, 'indexROP'])->name('rop.index');
// -------------------------- for both seller,customer and admin -------------------//
    Route::post('/stockout-product',[CustomerOrdersController::class,'stockout_product']);
 
    Route::get('/customer-transactions', [CustomerController::class, 'transactionIndex'])->name('customer-transactions');
    Route::get('/customer.list_customer', [CustomerController::class, 'listcustomerOrdered'])->name('customer.list_customer');

    Route::post('/customer-order/approve/{id}', [CustomerController::class, 'approveCustomerOrder'])->name('customerOrder.approve');
    Route::post('/customer-order/reject/{id}', [CustomerController::class, 'rejectCustomerOrder'])->name('customerOrder.reject');

