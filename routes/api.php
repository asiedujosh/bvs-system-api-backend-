<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IndividualController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\AccessControlController;
use App\Http\Controllers\smsController;
use App\Enums\TokenAbility;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register',[UserController::class, 'store']);
Route::post('/login',[UserController::class, 'login']);
Route::get('/staffProfile/{id}',[UserController::class, 'staffProfile']);
Route::put('/staffUpdate/{id}',[UserController::class, 'staffUpdate']);
Route::delete('/staffDelete/{id}',[UserController::class, 'staffDelete']);
Route::post('/changePassword', [UserController::class, 'changePassword']);


Route::post('/clientAdd',[IndividualController::class, 'store']);
Route::post('/serviceAdd',[IndividualController::class, 'serviceStore']);
Route::post('/addProducts',[IndividualController::class, 'productStore']);
Route::post('/addRole', [AccessControlController::class, 'roleStore']);
Route::put('/clientUpdate/{id}',[IndividualController::class, 'updateClient']);
Route::put('/updateProduct/{id}',[IndividualController::class, 'updateProduct']);
Route::put('/deactivateProduct/{id}',[IndividualController::class, 'deactivateProduct']);
Route::put('/reactivateProduct/{id}',[IndividualController::class, 'reactivateProduct']);


Route::get('/staffGetAll',[UserController::class, 'index']);
Route::get('/records',[IndividualController::class,'showRecordingTable']);
Route::get('/remindAllRecord',[IndividualController::class,'remindAllRecordTable']);
Route::get('/remindDueRecord',[IndividualController::class,'remindDueRecordTable']);
Route::get('/dueRecords',[IndividualController::class,'dueRecordingTable']);
Route::get('/allServices',[IndividualController::class,'allServices']);
Route::get('/getClient/{id}',[IndividualController::class,'showClientProfile']);
Route::get('/getProducts/{id}',[IndividualController::class,'showProductsOfClient']);
Route::get('/search', [IndividualController::class,'search']);

//Company in others
Route::post('/companyAdd',[CompanyController::class, 'companyStore']);
Route::get('/getRecordsWithCompany', [CompanyController::class, 'companyRecordTable']);
Route::get('/companySearch', [CompanyController::class, 'companySearch']);
Route::get('/companyGetAll',[CompanyController::class, 'companyAll']);
Route::get('/companyProfile/{id}',[CompanyController::class, 'companyProfile']);
Route::put('/companyUpdate/{id}',[CompanyController::class, 'companyUpdate']);
Route::delete('/companyDelete/{id}',[CompanyController::class, 'companyDelete']);

//Package in others
Route::post('/packageAdd',[PackageController::class, 'packageStore']);
Route::get('/packageSearch', [PackageController::class, 'packageSearch']);
Route::get('/packageGetAll',[PackageController::class, 'packageAll']);
Route::get('/packageProfile/{id}',[PackageController::class, 'packageProfile']);
Route::put('/packageUpdate/{id}',[PackageController::class, 'packageUpdate']);
Route::delete('/packageDelete/{id}',[PackageController::class, 'packageDelete']);

//Get Role
Route::get('/getAllRole',[AccessControlController::class, 'getAllRole']);

//Get Permissions
Route::get('/getAllClientPermission',[AccessControlController::class, 'getAllClientPermission']);
Route::get('/getSingleClientPermission/{id}',[AccessControlController::class, 'getSingleClientPermission']);
Route::get('/getAllCompanyPermission',[AccessControlController::class, 'getAllCompanyPermission']);
Route::get('/getSingleCompanyPermission/{id}',[AccessControlController::class, 'getSingleCompanyPermission']);
Route::get('/getAllPackagePermission',[AccessControlController::class, 'getAllPackagePermission']);
Route::get('/getSinglePackagePermission/{id}',[AccessControlController::class, 'getSinglePackagePermission']);
Route::get('/getAllUserPermission',[AccessControlController::class, 'getAllUserPermission']);
Route::get('/getSingleUserPermission/{id}',[AccessControlController::class, 'getSingleUserPermission']);
Route::put('/updatePermission',[AccessControlController::class, 'updatePermission']);
Route::delete('/deleteRole/{id}',[AccessControlController::class, 'deleteRole']);


//Get Sms Information
Route::post('/sendSmsToClient',[smsController::class, 'sendSms']);


Route::middleware(['auth:sanctum'])->get('/retrieve', [UserController::class, 'getUserDetails']);
//Route::middleware(['auth:sanctum'])->post('/add_individual_client',[IndividualController::class, 'store']);

Route::post('/refreshToken',[UserController::class, 'refreshToken'])->middleware([
    'auth:sanctum',
    'ability:'.TokenAbility::ISSUE_ACCESS_TOKEN->value,
]);
