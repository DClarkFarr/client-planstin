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

use Illuminate\Http\Request;

Route::get('portal/oath_callback', function (Request $request) {
    $format = <<<EOHTML
<h1 style="text-align:center; width: 30%%; margin: auto;"> OAuth Authorization Code </h1>
<div style="text-align:center; width: 30%%; margin: auto;"> 
    <p><strong>Code: </strong> %s </p>    
    <p><strong>State: </strong> %s </p>    
</div>
EOHTML;


    echo sprintf(
        $format,
        $request->get('code'),
        $request->get('state')
    );
});

Route::view('/', "links");

Route::prefix('login')->group(function(){

    Route::prefix('client')->group(function(){
        Route::get('/', 'Client\LoginController@login')->name('client.login');
        Route::get('/forgot-password', 'Client\LoginController@forgotPassword')->name('client.login.forgot');
        Route::get('/reset-password', 'Client\LoginController@resetPassword')->name('client.login.reset');
        Route::get('/recovery-code', 'Client\LoginController@recoveryCode')->name('client.login.recovery'); 
    });

    Route::prefix('member')->group(function(){
        Route::get('/', 'Member\LoginController@login')->name('member.login');
        Route::get('/forgot-password', 'Member\LoginController@forgotPassword')->name('member.login.forgot');
        Route::get('/reset-password', 'Member\LoginController@resetPassword')->name('member.login.reset');
        Route::get('/recovery-code', 'Member\LoginController@recoveryCode')->name('member.login.recovery'); 
    });

});



Route::prefix('register')->group(function()
{
    /*  /register/client/...  */
    Route::prefix('client')->group(function()
    {
        //Todo: Create middleware to make sure the user is on the correct step
        Route::any('signup', 'Client\RegisterController@createUser')->name('client_register_signup');
        Route::any('profile', 'Client\RegisterController@profile')->name('client_register_profile');
        Route::any('services', 'Client\RegisterController@services')->name('client_register_services');
        Route::any('agreement', 'Client\RegisterController@agreement')->name('client_register_agreements');
        Route::any('employees', 'Client\RegisterController@employees')->name('client_register_employees');
    });

    /*  /register/member/...  */
    Route::prefix('member')->group(function()
    {
        Route::any('signup', 'Member\RegisterController@create')->name('member.signup');
        Route::any('enrollment', 'Member\RegisterController@enrollment')->name('member.enrollment');
        Route::any('agreement', 'Member\RegisterController@agreement')->name('member.agreement');
    });
});


Route::prefix('portal')->group(function() {
    Route::prefix('company')->group(function(){
        Route::get('dashboard', 'Company\DashboardController@index');
    });
});


// Route::prefix('employer')->group(function(){
//     Route::get('{controller?}/{method?}/{segments?}', 'MvcController@receive')->where([
//         'segments' => '.*',
//     ]);
// });
// Route::prefix('employee')->group(function(){
//     Route::get('{controller?}/{method?}/{segments?}', 'MvcController@receive')->where([
//         'segments' => '.*',
//     ]);
// });
// Route::get('{controller?}/{method?}/{segments?}', 'MvcController@receive')->where([
//     'segments' => '.*',
// ]);






