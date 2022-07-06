<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\ExpenseController;
use App\Http\Controllers\API\TravelExpenseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//login api
Route::Post('/login', [AuthController::class, 'login']);


Route::post(
    '/forgot-password', [TravelExpenseController::class, 'forgotPassword']
);
Route::post(
    '/verify/pin', [TravelExpenseController::class, 'verifyPin']
);
Route::post(
    '/reset-password', [TravelExpenseController::class, 'resetPassword']
);

Route::group(['middleware' => ['auth:sanctum']], function () {

    //user api
    Route::get('/user-profile/{id}', [UserController::class, 'userProfile']);
    Route::post('/change-password', [UserController::class, 'changePassword']);
    Route::post('/update-profile', [UserController::class, 'updateProfile']);

    //logout
    Route::post('/logout', [AuthController::class, 'logout']);

    # Expense H.Q and Travling
    Route::post('/dashboard/hq', [DashboardController::class, 'expenseHQ']);
    Route::post('/dashboard/tr', [DashboardController::class, 'expenseTR']);
    Route::get('/dashboard/expense', [DashboardController::class, 'expense']);

    #all expenses
    Route::get('/all-expenses', [ExpenseController::class, 'allExpense']);
    Route::post('/add-expense/headquater', [ExpenseController::class, 'expenseStoreHeadquater']);
    Route::get('/expenses/accepted', [ExpenseController::class, 'expenseAccespted']);
    Route::post('/expenses/accepted/date', [ExpenseController::class, 'expenseAccesptedDate']);
    Route::get('/expenses/rejected', [ExpenseController::class, 'expenseRejected']);
    Route::post('/expenses/rejected/date', [ExpenseController::class, 'expenseRejectedDate']);

    Route::get('/expenses/by-user-id', [ExpenseController::class, 'expenseByUserID']);
    Route::get('/autofill-headquater-expense', [ExpenseController::class, 'autoFillHeadquaterExpense']);
    Route::post('/autofill-headquater-expense/store', [ExpenseController::class, 'autoFillHeadquaterExpenseStore']);
    Route::post('/single-expense-by-id', [ExpenseController::class, 'singleExpense']);
    Route::post('/update-headquater-expenses', [ExpenseController::class, 'updateHeadQuaterExpenseByUserIDAndDate']);

    #travel Expense api
    Route::post('/submit-travel-expense', [TravelExpenseController::class, 'submitTravelExpense']);
    Route::get('/get-travel-expense', [TravelExpenseController::class, 'getTravelExpense']);
    Route::get('/get-travel-expense-by-id', [TravelExpenseController::class, 'getTravelExpenseById']);
    Route::post('/update-travel-expense-by-id', [TravelExpenseController::class, 'updateTravelExpenseById']);
    Route::get('/travel-expense-data', [TravelExpenseController::class, 'allDistance']);
    Route::get('/all-notification', [TravelExpenseController::class, 'allNotification']);
    Route::get('/get-travel-expense-by-id', [TravelExpenseController::class, 'getTravelExpenseById']);
    Route::get('/all-notification', [TravelExpenseController::class, 'allNotification']);

    //fcm token for notification
    Route::post('update-fcm-token',[UserController::class, 'updateFCMToken']);
});


