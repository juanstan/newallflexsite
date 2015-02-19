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

Route::get('/', function()
{
	return View::make('hello');
});

Route::group(['prefix' => 'api', 'before' => 'api.before', 'namespace' => 'Api'], function()
{
    Route::post('user/login', ['as' => 'api.user.login','uses' => 'AuthController@postLogin']); // Done
    Route::resource('user', 'UserController', ['only' => ['store']]); // Done
    
    Route::post('vet/login', ['as' => 'api.vet.login','uses' => 'VetAuthController@postLogin']); // Done
    Route::resource('vet', 'VetController', ['only' => ['store']]); // Done

    Route::group(['before' => 'auth.api'], function()
    {
        
        Route::post('user/logout', ['as' => 'api.user.logout','uses' => 'AuthController@postLogout']); // Done
        Route::resource('user', 'UserController', ['only' => ['show', 'update', 'destroy']]); // Done
        Route::resource('animal', 'AnimalController'); // Done
        Route::resource('animal/{animal_id}/condition', 'AnimalConditionController');  // Done
        Route::resource('animal/{animal_id}/reading', 'AnimalReadingController'); //  Done
        Route::resource('animal/{animal_id}/reading/{reading_id}/symptom', 'AnimalReadingSymptomController'); // Done
        Route::resource('user/request', 'VetRequestController'); // Needs not allow muliple requests for same animal  

    });
    
    
    Route::group(['prefix' => 'vet'], function()
    {
        Route::group(['before' => 'vet.auth.api'], function()
        {    
            
            Route::post('logout', ['as' => 'api.vet.logout','uses' => 'VetAuthController@postLogout']); // 
            Route::resource('/', 'VetController', ['only' => ['show', 'update', 'destroy']]); // 
            Route::resource('request/{id}/approve', 'AnimalRequestController@approveRequest'); // Only show if in date. On approval start the count down for expiry
            Route::resource('request', 'AnimalRequestController'); // veiw all requests
            Route::resource('animal', 'AnimalController', ['only' => ['show', 'index']]);  
            Route::resource('animal/{animal_id}/reading', 'AnimalReadingController', ['only' => ['show', 'update', 'index']]);  
            Route::resource('animal/{animal_id}/reading/{reading_id}/symptom', 'AnimalReadingSymptomController'); //  done
            
        });
        
    });
    
    Route::any('{url?}', function()
        {                                                                     
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
        })
        ->where('url', '.*');
});
