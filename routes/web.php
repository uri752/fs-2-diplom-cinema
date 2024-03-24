<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SeanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
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

Route::prefix('admin')->group(function () {
    Route::get('login', [LoginController::class, 'form'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate']);
    
    Route::get('register', [RegisterController::class, 'adminRegister'])->name('admin_register'); 
    Route::get('/auth/app_register', [RegisterController::class, 'registerGet'])->name('register');

    Route::group(['middleware'=>'auth'], function() {
        Route::get('index', [AdminController::class, 'index'])->name('index');
        Route::post('add_hall', [HallController::class, 'create'])->name('addHall');
        
        Route::post('add_movie', [AdminController::class, 'createMovie'])->name('addMovie');        
       
        Route::post('delete_hall/{id}', [HallController::class, 'delete']);
        Route::post('delete_movie/{id}', [AdminController::class, 'deleteMovie']);        

        Route::post('seances', [SeanceController::class, 'update'])->name('seance_update');        
        Route::post('add_seance/{id}', [SeanceController::class, 'update'])->name('add_seance');                

        Route::post('halls/{id}', [HallController::class, 'update'])->name('halls_update');                
        Route::post('seats/{id}', [HallController::class, 'updateSeats'])->name('seats_update');        
        //Route::post('seance', function () {return view('welcome');});        
        
    });
});

Route::prefix('client')->group(function () {
    Route::get('index', [ClientController::class, 'index']);
    Route::get('hall/{id}', [ClientController::class, 'hall'])->name('client_hall');
    Route::get('payment/{id}', [ClientController::class, 'payment']);
    Route::get('ticket/{id}', [ClientController::class, 'ticket']);
});

Route::name('user.')->group(function () {
    
    //Route::get('/admin_main', [TodoController::class, 'showAdminMain'])->middleware('auth')->name('private');

    Route::get('/auth/app_login', [LoginController::class, 'loginGet'])->name('login');
    Route::post('/auth/app_login', [LoginController::class, 'login']);  
    Route::post('/auth/register/changePass/{email}', [RegisterController::class, 'updatePassword'])->name('updatePassword');
    Route::get('/auth/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/auth/app_register', [RegisterController::class, 'registerGet'])->name('register');
    Route::post('/auth/app_register', [RegisterController::class, 'register']); 
});

Route::get('/login', [LoginController::class, 'admin_login'])->name('admin_login'); 