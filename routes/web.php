<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\RegController;
use App\Http\Controllers\UpdController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AjaxEntityController;

use App\Http\Controllers\CashierController;
use App\Http\Controllers\VtaController;



/*
|--------------------------------------------------------------------------
| Web Routes/
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard',['navcontent'=>'ventasindex']);
})->middleware(['auth', 'verified','sessionChecker'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware('auth')->group(function () {
    
});


Route::middleware(['auth', 'sessionChecker'])->group(function () {
    Route::get('/alta_paciente', [RegController::class, 'regpatient'])->name('regpatient');
    Route::get('/alta_empleado', [RegController::class, 'regemployee'])->name('regemployee');
    Route::get('/alta_producto', [ProductController::class, 'regproduct'])->name('regproduct');


    Route::get('/alta_producto/existencias', [ProductController::class, 'regexs'])->name('updproduct');
    
});


Route::middleware(['auth', 'sessionChecker'])->group(function () {
    Route::get('/actualizar_paciente', [UpdController::class, 'updpatient'])->name('updpatient');
    Route::get('/actualizar_empleado', [UpdController::class, 'updemployee'])->name('updemployee');
    Route::get('/actualizar_producto',  [ProductController::class, 'updproduct'])->name('updproduct');
    //Route::get('/actualizar_producto',  [ProductController::class, 'updproduct'])->name('updproduct');
});


Route::middleware(['auth', 'sessionChecker'])->group(function () {
    Route::get('/ajaxpacget', [AjaxEntityController::class, 'getpatitent']);
    Route::get('/ajaxempget', [AjaxEntityController::class, 'getemployee']);
    Route::get('/ajaxprodget', [AjaxEntityController::class, 'getproduct']);
    Route::get('/ajaxactivepacget', [AjaxEntityController::class, 'getactivepatients']);
    Route::get('/ajaxactiveempget', [AjaxEntityController::class, 'getactiveemployees']);
    Route::get('/cajero/credito', [AjaxEntityController::class, 'getbalance']);
    Route::post('/ajaxupdatefingerdata', [AjaxEntityController::class, 'updatefingerdata']);
    
    
});


Route::middleware(['auth','sessionChecker'])->group(function () {
    Route::get('/cajero', [CashierController::class, 'index'])->name('cashier');
    Route::get('/ajaxbarcode', [CashierController::class, 'GetProductFromCode']);
    Route::get('/ajaxsetsalestatus', [CashierController::class, 'SetSaleStatus']);
    Route::get('/ajaxgetblob', [CashierController::class, 'getblob']);

    Route::get('/ajaxsetAccountType', [CashierController::class, 'setaccounttype']);
    
    Route::post('/ajaxsale', [CashierController::class, 'registersale'])->name('ajaxsale');
    Route::get('/recibo', [CashierController::class, 'getPrintReceipt']);
});


Route::middleware(['auth', 'sessionChecker'])->group(function () {
    Route::get('/dashboard', [VtaController::class, 'index'])->name('dashboard');
    Route::get('/ajaxpatientchart', [VtaController::class, 'ajaxpatientchart']);

    Route::get('/ajaxvtadiaria', [VtaController::class, 'getdaily']);
    Route::get('/ajaxvtasemanal', [VtaController::class, 'getweekly']);
    Route::get('/ajaxvtamensual', [VtaController::class, 'getmonthly']);
    Route::get('/ajaxvtaporcta', [VtaController::class, 'getvtaporcta']);
    Route::get('/ajaxprodporvta', [VtaController::class, 'getsaleprods']);

    Route::get('/ajaxchartweeklysales', [VtaController::class, 'getweeklysalesperuser']);
    
});

Route::middleware(['auth', 'sessionChecker'])->group(function () {
    
    Route::get('/corte_de_caja', [VtaController::class, 'restore']);
});


require __DIR__.'/auth.php';
