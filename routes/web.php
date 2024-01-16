<?php

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\DatabaseController;

use App\Http\Controllers\QuizController;

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {return view('welcome');})->name('welcome');



Route::get('/sqli_home_out', function () {return view('logout.sqli_home');})->name('sqli_home_out');

Route::get('/sqli_in_band_out', function () {return view('logout.sqli_in_band');})->name('sqli_in_band_out');

Route::get('/sqli_blind_out', function () {return view('logout.sqli_blind');})->name('sqli_blind_out');

Route::get('/sqli_oob_out', function () {return view('logout.sqli_oob');})->name('sqli_oob_out');

Route::get('/sqli_prevention_out', function () {return view('logout.sqli_prevention');})->name('sqli_prevention_out');

Route::get('/sqli_quiz_out', function () {return view('logout.sql_quiz');})->name('sqli_quiz_out');

Route::get('/xss_home_out', function () {return view('logout.xss_home');})->name('xss_home_out');

Route::get('/xss_stored_out', function () {return view('logout.xss_stored');})->name('xss_stored_out');

Route::get('/xss_reflect_out', function () {return view('logout.xss_reflect');})->name('xss_reflect_out');

Route::get('/xss_dom_out', function () {return view('logout.xss_dom');})->name('xss_dom_out');

Route::get('/xss_prevention_out', function () {return view('logout.xss_prevention');})->name('xss_prevention_out');

Route::get('/xss_quiz_out', function () {return view('logout.xss_quiz');})->name('xss_quiz_out');

Route::post('/sql_quiz_out_checker', [QuizController::class, 'sql_quiz_out_checker'])->name('sql_quiz_out_checker');

Route::post('/xss_quiz_out_checker', [QuizController::class, 'xss_quiz_out_checker'])->name('xss_quiz_out_checker');


Route::middleware('auth')->group(function () {

    Route::get('/db_session_creation', [DatabaseController::class, 'setSessionAndRedirect'])->name('db_session_creation');

    Route::get('/db_reset', function () {return view('db_reset');})->name('db_reset');

    Route::get('/index', function () {return view('index');})->name('index');

    /** SQL Information */
    
    Route::get('/sqli_home', function () {return view('sqli_home');})->name('sqli_home');

    Route::get('/sqli_in_band', function () {return view('sqli_in_band');})->name('in_band');

    Route::get('/sqli_blind', function () {return view('sqli_blind');})->name('blind');

    Route::get('/sqli_oob', function () {return view('sqli_oob');})->name('oob');

    Route::get('/sqli_prevention', function () {return view('sqli_prevention');})->name('sqli_prevention');

    /** End of SQL Information */

    /** SQL Sandbox */
    
    Route::any('/sqli_in_band_front_end', function () {return view('sqli_in_band_front_end');})->name('in_band_front_end');

    Route::any('/sqli_in_band_back_end', function () {return view('sqli_in_band_back_end');})->name('in_band_back_end');

    Route::any('/sqli_in_band_union_front_end', function () {return view('sqli_in_band_union_front_end');})->name('in_band_front_union_end');

    Route::any('/sqli_in_band_union_back_end', function () {return view('sqli_in_band_union_back_end');})->name('in_band_back_union_end');


    Route::any('/sqli_blind_front_end', function () {return view('sqli_blind_front_end');})->name('blind_front_end');

    Route::any('/sqli_blind_back_end', function () {return view('sqli_blind_back_end');})->name('blind_back_end');

    Route::any('/sqli_blind_time_front_end', function () {return view('sqli_blind_time_front_end');})->name('blind_time_front_end');

    Route::any('/sqli_blind_time_back_end', function () {return view('sqli_blind_time_back_end');})->name('blind_time_back_end');

    Route::any('/validate_sqli', function () {return view('validate_sqli');})->name('validate_sqli');

    Route::any('/prepared', function () {return view('prepared');})->name('prepared');

    Route::any('/sql_secure_front_end', function () {return view('sql_secure_front_end');})->name('sql_secure_front_end');

    Route::any('/sql_secure_back_end', function () {return view('sql_secure_back_end');})->name('sql_secure_back_end');

    /** End of SQL Sandbox */

    /** XSS Information */

    Route::get('/xss_home', function () {return view('xss_home');})->name('xss_home');

    Route::get('/xss_stored', function () {return view('xss_stored');})->name('xss_stored');

    Route::get('/xss_reflect', function () {return view('xss_reflect');})->name('xss_reflect');

    Route::get('/xss_dom', function () {return view('xss_dom');})->name('xss_dom');

    Route::any('/validate_xss', function () {return view('validate_xss');})->name('validate_xss');

    /** End of XSS Information */

    /** XSS Sandbox */

    Route::any('/xss_dom_front_end', function () {return view('xss_dom_front_end');})->name('dom_front_end');

    Route::any('/xss_dom_back_end', function () {return view('xss_dom_back_end');})->name('dom_back_end');
    
    Route::any('/stored_xss_front_end', function () {return view('stored_xss_front_end');})->name('stored_front_end');

    Route::any('/stored_xss_submit_back_end', function () {return view('stored_xss_submit_back_end');})->name('submit_back_end');

    Route::any('/stored_xss_view_back_end', function () {return view('stored_xss_view_back_end');})->name('view_back_end');

    Route::any('/reflected_xss_front_end', function () {return view('reflected_xss_front_end');})->name('reflect_front_end');

    Route::any('/reflected_xss_back_end', function () {return view('reflected_xss_back_end');})->name('reflect_back_end');

    Route::get('/xss_quiz', function () {return view('xss_quiz');})->name('xss_quiz');

    Route::post('/xss_quiz_checker', [QuizController::class, 'xss_quiz_checker'])->name('xss_quiz_checker');

    Route::get('/sql_quiz', function () {return view('sql_quiz');})->name('sql_quiz');

    Route::post('/sql_quiz_checker', [QuizController::class, 'sql_quiz_checker'])->name('sql_quiz_checker');

    Route::get('/xss_prevention', function () {return view('xss_prevention');})->name('xss_prevention');

    Route::any('/encoding', function () {return view('encoding');})->name('encoding');

    Route::any('/xss_secure_front_end', function () {return view('xss_secure_front_end');})->name('xss_secure_front_end');

    Route::any('/xss_secure_view_back_end', function () {return view('xss_secure_view_back_end');})->name('xss_secure_view_back_end');

    Route::any('/xss_secure_submit_back_end', function () {return view('xss_secure_submit_back_end');})->name('xss_secure_submit_back_end');


    /** End of XSS Sandbox */

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::get('/profile_db_reset', [DatabaseController::class, 'resetDBToEdit'])->name('profile_db_reset');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');




});

require __DIR__.'/auth.php';
