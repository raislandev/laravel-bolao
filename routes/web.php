<?php

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

Route::get('lang', function () {
    $lang = session('lang', 'pt-br');
    if($lang == 'pt-br'){
      $lang = "en";

    }else{
      $lang = "pt-br";
    }
    session(['lang' => $lang]);
    return redirect()->back();

})->name('lang');




Route::get('/modelo', function () {

    return view('welcome');
});

Auth::routes();

Route::namespace('Site')->group(function () {
    Route::get('/', 'PrincipalController@index')->name('principal');
});

Route::middleware('auth')->namespace('Site')->group(function () {
    Route::post('/sign/{id}', 'PrincipalController@sign')->name('sign');
    Route::get('/sign/{id}', 'PrincipalController@signNoLogin')->name('sign');
    Route::get('/rounds/{betting_id}', 'PrincipalController@rounds')->name('rounds');
    Route::get('/rounds/matches/{round_id}', 'PrincipalController@matches')->name('rounds.matches');
    Route::get('/rounds/matches/result/{match_id}', 'PrincipalController@result')->name('match.result');
    Route::put('/rounds/matches/result/{match_id}', 'PrincipalController@update')->name('match.result.update');
    Route::get('/classification/{betting_id}', 'PrincipalController@classification')->name('classification');

});

Route::middleware('auth')->namespace('Admin')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
});


Route::prefix('admin')->middleware('auth')->namespace('Admin')->group(function () {
    Route::resource('/users', 'UserController');
    Route::resource('/bettings', 'BettingController');
    Route::resource('/rounds', 'RoundController');
    Route::resource('/matches', 'MatchController');

});

Route::prefix('admin')->middleware(['auth','can:acl'])->namespace('Admin')->group(function () {
    Route::resource('/permissions', 'PermissionController');
    Route::resource('/roles', 'RoleController');
});
