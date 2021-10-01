<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\BalanceSheetController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CurrencyExchangeController;
use App\Http\Controllers\CurrencyRateController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeBonusController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeePaymentsController;
use App\Http\Controllers\EmployeeVacationController;
use App\Http\Controllers\ExpenseRecieptController;
use App\Http\Controllers\FixedAssetController;
use App\Http\Controllers\GeneralLedgerController;
use App\Http\Controllers\InvertoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LogBookController;
use App\Http\Controllers\MonthlyReportController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfitLossController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StupidFormController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TrialBalanceController;
use App\Http\Controllers\VendorController;
use App\Models\FixedAsset;
use App\Models\HR\Employee;
use App\Models\HR\EmployeePayments;
use App\Models\Invertory;
use App\Models\Receipt;
use App\Models\Vendor;
use Illuminate\Support\Facades\Route;

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

//Route::middleware(['auth:sanctum', 'verified'])->group(function () {
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/accounts-chart', [AccountTypeController::class, 'index'])->name('accounts-chart');
Route::get('archives', [ArchiveController::class, 'index'])->name('archives');
// الحسابات وانواعها
Route::resource('types', AccountTypeController::class);
Route::resource('accounts', AccountController::class);
Route::get('/accounts/{account}/ledger', [AccountController::class, 'ledger'])->name('accountledger');
Route::get('/migrate', function () {
    \Artisan::call('migrate:fresh --seed');
    dd('تم التصفير');
})->name('reset');
// اليومية والقيود
Route::resource('journals', TransactionController::class);
// التقارير
Route::resource('reports', ReportController::class);
Route::resource('monthly-report', MonthlyReportController::class);
// المشتريات
Route::resource('purchases', PurchaseController::class);
// المصاريف
Route::resource('expenses', ExpenseRecieptController::class);
Route::get('/reciept/{reciept}/pay', [ExpenseRecieptController::class, 'addExpensePage'])->name('addExpense');
Route::post('/reciept/{reciept}/pay', [ExpenseRecieptController::class, 'addExpense'])->name('addExpensePOST');
Route::get('/reciept/{reciept}/refund', [ExpenseRecieptController::class, 'refund'])->name('refundReciept');
// الموردين
Route::resource('vendors', VendorController::class);
// الفواتير والمبيعات
Route::resource('invoices', InvoiceController::class);
Route::post('/invoice/{invoice}/sent', [InvoiceController::class, 'sent'])->name('markInvoiceSent');
Route::get('/invoice/{invoice}/pay', [InvoiceController::class, 'addPaymentPage'])->name('addPayment');
Route::post('/invoice/{invoice}/pay', [InvoiceController::class, 'addPayment'])->name('addPayment');
Route::get('invoice/{invoice}/pdf', [InvoiceController::class, 'generatePDF'])->name('generatePDF');
Route::get('retains', [InvoiceController::class, 'claimRetains'])->name('claimRetains');
Route::post('claimretains', [InvoiceController::class, 'claimRetainsStore'])->name('claimRetainsStore');
// الزبائن
Route::resource('customers', CustomerController::class);
Route::get('currency/set/{currency}', [CurrencyController::class, 'setCurrency'])->name('setCurrency');

// الضرائبb
Route::resource('taxes', TaxController::class);

// المستودعات
Route::resource('invertories', InvertoryController::class);

// الاصول الثابتة
Route::resource('fixedAssets', FixedAssetController::class);
Route::get('invertory/{invertory}/createAsset/', [FixedAssetController::class, 'createFromInvertory'])->name('createFromInvertory');
Route::get('invertory/{invertory}/purchaseAsset/', [FixedAssetController::class, 'purchaseFromInvertory'])->name('purchaseFromInvertory');

Route::resource('form', StupidFormController::class);

//تحويل عملة
Route::resource('exchange', CurrencyExchangeController::class);
Route::resource('currency_rates', CurrencyRateController::class);
// الموارد البشرية
Route::resource('employees', EmployeeController::class);
Route::resource('salary', EmployeePaymentsController::class);
Route::resource('bonus', EmployeeBonusController::class);
Route::resource('vacations', EmployeeVacationController::class);
Route::get('paySalary/{employee}', [EmployeePaymentsController::class, 'showpayment'])->name('paySalary');
// المناصب
Route::resource('positions', PositionController::class);

// التقارير
Route::prefix('report')->group(function () {
    Route::resource('generalledger', GeneralLedgerController::class);
    Route::resource('profitloss', ProfitLossController::class);
    Route::resource('trialbalance', TrialBalanceController::class);
    Route::resource('balancesheet', BalanceSheetController::class);
    Route::resource('logbook', LogBookController::class);
});
//});


Route::post('/modal-add-vendors', function (Request $request) {
    Vendor::create($request->all());
    return response()->json(['vendors' => Vendor::all()]);
})->name('addVendorModal');
Route::post('/modal-add-invertories', function (Request $request) {
    $invertoryX = Invertory::create($request->all());
    $invertories = Invertory::all();
    $htmlString = "";
    foreach ($invertories as $invertory) {
        $selected = $invertory->name_and_path() == $invertoryX->name_and_path() ? 'selected' : '';
        $htmlString .= "<option value=\"" . $invertory->id . "\" $selected>" . $invertory->name_and_path() . "</option>";
    }
    return response()->json(['htmlString' => $htmlString]);
})->name('addInvertoryModal');
Route::get('/allInvertories', function () {
    $invertories = Invertory::all();
    $htmlString = "";
    foreach ($invertories as $invertory) {
        $htmlString .= "<option value=\"" . $invertory->id . "\">" . $invertory->name_and_path() . "</option>";
    }
    return response()->json(['htmlString' => $htmlString]);
})->name('getInvertories');
