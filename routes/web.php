<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;

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
Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/dashboard', function(){
//     return view('dashboard');
// });

Route::group(['prefix' => 'admin','middleware' => ['auth']], function() {
Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
Route::post('date/filter/graph', [AdminController::class, 'dateFilterGraph'])->name('dateFilterGraph');

/**** Expense Part *****/
Route::get('/expense', [ExpenseController::class, 'index'])->name('expense');
Route::post('/expense/store', [ExpenseController::class, 'expenseStore'])->name('expenseStore');
Route::get('/expense/edit/{id}', [ExpenseController::class, 'expenseEdit'])->name('expenseEdit');
Route::post('/expense/update/{id}', [ExpenseController::class, 'expenseUpdate'])->name('expenseUpdate');
Route::get('/expense/delete/{id}', [ExpenseController::class, 'expenseDelete'])->name('expenseDelete');

#Expence type part
Route::get('/expense-type', [ExpenseController::class, 'expenseType'])->name('expenseType');
Route::post('/expense-type/store', [ExpenseController::class, 'expenseTypeStore'])->name('expenseTypeStore');
Route::get('/expense-type/edit/{id}', [ExpenseController::class, 'expenseTypeEdit'])->name('expenseTypeEdit');
Route::post('/expense-type/update/{id}', [ExpenseController::class, 'expenseTypeUpdate'])->name('expenseTypeUpdate');
Route::get('/expense-type/delete/{id}', [ExpenseController::class, 'expenseTypeDelete'])->name('expenseTypeDelete');

Route::get('/expense-category', [ExpenseController::class, 'expenseCategory'])->name('expense.category');
Route::post('/expense-category/store', [ExpenseController::class, 'expenseCategoryStore'])->name('expense.category.store');
Route::get('/expense-category-edit/{id}', [ExpenseController::class, 'expenseCategoryEdit'])->name('expense.category.edit');
Route::post('/expense-category-update/{id}', [ExpenseController::class, 'expenseCategoryUpdate'])->name('expense.category.update');
Route::get('/expense-category/delete/{id}', [ExpenseController::class, 'expenseCategoryDelete'])->name('expense.category.delete');


# Reconcilation Report
Route::get('reconcilation-report', [ExpenseController::class, 'reconciliation'])->name('reconciliation');

#Sale Staff Expense Part
Route::get('/sale-staf-expense', [ExpenseController::class, 'saleStafExpense'])->name('expense.staff');
Route::post('/sale-staf-expense-filter', [ExpenseController::class, 'dateFilterSaleStaffExpense'])->name('dateFilterSaleStaffExpense');

/**** User Managment Part *****/
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/users-add', [UserController::class, 'addUser'])->name('add.user');
Route::post('/users-store', [UserController::class, 'storeUser'])->name('store.user');
Route::get('/users-edit/{id}', [UserController::class, 'editUser'])->name('edit.user');
Route::post('/users-update/{id}', [UserController::class, 'updateUser'])->name('update.user');
Route::get('/users-delete/{id}', [UserController::class, 'storeDelete'])->name('delete.user');
Route::resource('/roles', RoleController::class);
Route::resource('/role-permission', PermissionController::class);

/**** manager Managment Part *****/
Route::get('/manager', [ManagerController::class, 'index'])->name('manager');
Route::post('/manager/store', [ManagerController::class, 'managerStore'])->name('managerStore');
Route::get('/manager/delete/{id}', [ManagerController::class, 'managerDelete'])->name('managerDelete');
Route::get('/expense-requestes', [ManagerController::class, 'expenseRequest'])->name('expenseRequest');
Route::post('/expense-change-status/{id}', [ManagerController::class, 'changeExpenseStatus'])->name('changeExpenseStatus');
Route::get('/manager/staff/members', [ManagerController::class, 'managerStaff'])->name('managerStaff');
Route::get('/manager/staff/members/expense-in-graph/{id}', [ManagerController::class, 'managerStaffExpenseInGraph'])->name('managerStaffExpenseInGraph');


/**** Staff Managment Part *****/
Route::get('/staff', [StaffController::class, 'index'])->name('staff');
Route::post('/staff/store', [StaffController::class, 'staffStore'])->name('staffStore');
Route::get('/staff/edit/{id}', [StaffController::class, 'staffEdit'])->name('staffEdit');
Route::post('/staff/update/{id}', [StaffController::class, 'staffUpdate'])->name('staffUpdate');
Route::get('/staff/delete/{id}', [StaffController::class, 'staffDelete'])->name('staffDelete');
Route::get('/staff-upload', [StaffController::class, 'importStaff'])->name('import.staff');
Route::post('/staff-upload-save', [StaffController::class, 'importStaffSave'])->name('import.staff_save');
Route::post('date/filter/sale/staff', [StaffController::class, 'dateFilterSaleStaff'])->name('dateFilterSaleStaff');

#Role Part
Route::get('/role', [StaffController::class, 'role'])->name('role');
Route::post('/role/store', [StaffController::class, 'roleStore'])->name('roleStore');
Route::get('/role/edit/{id}', [StaffController::class, 'roleEdit'])->name('roleEdit');
Route::post('/role/update/{id}', [StaffController::class, 'roleUpdate'])->name('roleUpdate');
Route::get('/role/delete/{id}', [StaffController::class, 'roleDelete'])->name('roleDelete');

#Location for sale expense part
Route::get('/allocations-for-sale-expense', [StaffController::class, 'allocationExpense'])->name('allocationExpense');
Route::post('/allocations/store', [StaffController::class, 'allocationStore'])->name('allocationStore');

/**** Location Managment Part *****/
Route::get('/city', [LocationController::class, 'city'])->name('city');
Route::post('/city/store', [LocationController::class, 'cityStore'])->name('cityStore');
Route::post('/city/update/{id}', [LocationController::class, 'cityUpdate'])->name('cityUpdate');
Route::get('/city/edit/{id}', [LocationController::class, 'cityEdit'])->name('cityEdit');
Route::get('/city/delete/{id}', [LocationController::class, 'cityDelete'])->name('cityDelete');
Route::get('/city-upload', [LocationController::class, 'importCity'])->name('import.city');
Route::post('/city-upload-save', [LocationController::class, 'importCitySave'])->name('import.city_save');

// zone
Route::get('/zone', [LocationController::class, 'zone'])->name('zone');
Route::post('/zone/store', [LocationController::class, 'zoneStore'])->name('zoneStore');
Route::post('/zone/update/{id}', [LocationController::class, 'zoneUpdate'])->name('zoneUpdate');
Route::get('/zone/edit/{id}', [LocationController::class, 'zoneEdit'])->name('zoneEdit');
Route::get('/zone/delete/{id}', [LocationController::class, 'zoneDelete'])->name('zoneDelete');
Route::get('/zone-upload', [LocationController::class, 'importZone'])->name('import.zone');
Route::post('/zone-upload-save', [LocationController::class, 'importZoneSave'])->name('import.zone_save');

#Distance Managment
Route::get('/distance', [LocationController::class, 'distance'])->name('distance');
Route::post('/distance/store', [LocationController::class, 'distanceStore'])->name('distanceStore');
Route::get('/distance/edit/{id}', [LocationController::class, 'distanceEdit'])->name('distanceEdit');
Route::get('/distance/update/{id}', [LocationController::class, 'distanceUpdate'])->name('distanceUpdate');
Route::get('/distance/delete/{id}', [LocationController::class, 'distanceDelete'])->name('distanceDelete');

#Fuel Rates
Route::get('/fuel-rate', [LocationController::class, 'fuelRates'])->name('fuelRates');
Route::post('/fuel-rate/store', [LocationController::class, 'fuelRateStore'])->name('fuelRateStore');
Route::get('/fuel-rate/edit/{id}', [LocationController::class, 'fuelRateEdit'])->name('fuelRateEdit');
Route::post('/fuel-rate/update/{id}', [LocationController::class, 'fuelRateUpdate'])->name('fuelRateUpdate');
Route::get('/fuel-rate/delete/{id}', [LocationController::class, 'fuelRateDelete'])->name('fuelRateDelete');

#Stations Managment
Route::get('/station', [LocationController::class, 'station'])->name('station');
Route::post('/station/store', [LocationController::class, 'stationStore'])->name('stationStore');
Route::get('/station/edit/{id}', [LocationController::class, 'stationEdit'])->name('stationEdit');
Route::post('/station/update/{id}', [LocationController::class, 'stationUpdate'])->name('stationUpdate');
Route::get('/station/delete/{id}', [LocationController::class, 'stationDelete'])->name('stationDelete');

#Calander Managment
Route::get('/calander', [LocationController::class, 'calander'])->name('calander');
Route::post('/calander/store', [LocationController::class, 'calanderStore'])->name('calanderStore');
Route::get('/calander/edit/{id}', [LocationController::class, 'calanderEdit'])->name('calanderEdit');
Route::post('/calander/update/{id}', [LocationController::class, 'calanderUpdate'])->name('calanderUpdate');
Route::get('/calander/delete/{id}', [LocationController::class, 'calanderDelete'])->name('calanderDelete');

#Calander Managment
Route::get('/designation', [LocationController::class, 'designation'])->name('designation');
Route::post('/designation/store', [LocationController::class, 'designationStore'])->name('designationStore');
Route::get('/designation/edit/{id}', [LocationController::class, 'designationEdit'])->name('designationEdit');
Route::post('/designation/update/{id}', [LocationController::class, 'designationUpdate'])->name('designationUpdate');
Route::get('/designation/delete/{id}', [LocationController::class, 'designationDelete'])->name('designationDelete');

});



Route::get('export', [LocationController::class, 'export'])->name('export');
Route::post('import', [LocationController::class, 'import'])->name('import');
