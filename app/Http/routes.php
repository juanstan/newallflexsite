<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//Route::get('/', function () {
//    $coded_string = "f58e29a43c67";
//    // Convert to binary
//    $bin = base_convert($coded_string, 16, 2);
//    // Split to 10/38 bits
//    $manufacturer = substr($bin, 0, 10);
//    $device_id = substr($bin, 10, 38);
//    // Convert to decimal
//    $manufacturer = bindec($manufacturer);
//    $device_id = bindec($device_id);
//    // Put pieces back
//    return $manufacturer . '.' . $device_id;
//});

Route::group(['prefix' => 'aws'], function()
{
    Route::get('elb-test', function()
    {
        return 'OK';
    });
});

Route::get('/', function () {
    return Redirect::route('user');
});

Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {

    include 'user_routes.php';

});

Route::group(['prefix' => 'vet', 'namespace' => 'Vet'], function () {

    include 'vet_routes.php';

});


Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {

    include 'api_routes.php';

});
