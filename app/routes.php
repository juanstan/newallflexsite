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
    return Redirect::to('pet');
});
                                                                
Route::group(['prefix' => 'pet', 'namespace' => 'pet'], function()
{
    Route::get('login/fb', 'FacebookController@index');
    Route::get('login/fb/callback', 'FacebookController@callback');
    Route::get('login/twitter', 'TwitterController@index');
    Route::controller('register/pet', 'PetRegisterController');
    Route::controller('register/vet', 'VetRegisterController');
    Route::controller('register/reading', 'AnimalReadingRegisterController');
    Route::controller('register', 'RegisterController');
    Route::controller('dashboard', 'DashboardController');
    Route::controller('/', 'AuthController');
});

Route::group(['prefix' => 'vet', 'namespace' => 'vet'], function()
{
    Route::controller('register/reading', 'AnimalReadingRegisterController');
    Route::controller('register', 'RegisterController');
    Route::controller('dashboard', 'DashboardController');
    Route::controller('/', 'AuthController');
});

//Route::group(['prefix' => 'pet'], function()
//{
//    Route::get('/dashboard', function()
//    {
//            return View::make('pet.dashboard');
//    });
//
//    Route::get('/help', function()
//    {
//            return View::make('pet.help');
//    });
//
//    Route::get('help/result', function()
//    {
//            return View::make('pet.result');
//    });
//
//    Route::get('/settings', function()
//    {
//            return View::make('pet.settings');
//    });
//
//    Route::get('/vet', function()
//    {
//            return View::make('pet.vet');
//    });
//
//    Route::group(['prefix' => 'signup'], function()
//    {
//
//        Route::get('/1', function()
//        {
//            return View::make('petsignup.stage1');
//        });
//        Route::get('/2', function()
//        {
//            return View::make('petsignup.stage2');
//        });
//        Route::get('/3', function()
//        {
//            return View::make('petsignup.stage3');
//        });
//        Route::get('/4', function()
//        {
//            return View::make('petsignup.stage4');
//        });
//        Route::get('/5', function()
//        {
//            return View::make('petsignup.stage5');
//        });
//        Route::get('/6', function()
//        {
//            return View::make('petsignup.stage6');
//        });
//        Route::get('/7', function()
//        {
//            return View::make('petsignup.stage7');
//        });
//
//    });
//});
//
//Route::group(['prefix' => 'vet'], function()
//{
//    Route::get('/dashboard', function()
//    {
//            return View::make('vet.dashboard');
//    });
//
//    Route::get('/information', function()
//    {
//            return View::make('vet.information');
//    });
//
//    Route::get('/help', function()
//    {
//            return View::make('vet.help');
//    });
//
//    Route::get('help/result', function()
//    {
//            return View::make('vet.result');
//    });
//
//    Route::get('/settings', function()
//    {
//            return View::make('vet.settings');
//    });
//
//    Route::group(['prefix' => 'signup'], function()
//    {
//
//        Route::get('/1', function()
//        {
//            return View::make('vetsignup.stage1');
//        });
//        Route::get('/2', function()
//        {
//            return View::make('vetsignup.stage2');
//        });
//        Route::get('/3', function()
//        {
//            return View::make('vetsignup.stage3');
//        });
//       
//    });
//});

Route::group(['prefix' => 'api', 'before' => 'api.before', 'namespace' => 'api'], function()
{
    Route::post('user/login', ['as' => 'api.user.login','uses' => 'AuthController@postLogin']); // Done
    Route::resource('user', 'UserController', ['only' => ['store']]); // Done
    
    Route::post('vet/login', ['as' => 'api.vet.login','uses' => 'VetAuthController@postLogin']); // Done
    Route::resource('vet', 'VetController', ['only' => ['store', 'index', 'show']]); // Done

    Route::group(['before' => 'auth.api'], function()
    {
        
        Route::post('user/logout', ['as' => 'api.user.logout','uses' => 'AuthController@postLogout']); // Done
        Route::resource('user', 'UserController', ['only' => ['show', 'update', 'destroy']]); // Done
        Route::resource('user', 'UserController', ['only' => ['show', 'update', 'destroy']]); // to do
        Route::resource('animal', 'AnimalController'); // Done
        Route::resource('device', 'DeviceController'); // Done
        Route::resource('breeds', 'BreedController'); // Done
        Route::resource('symptoms', 'SymptomController'); // Done
        Route::resource('animal/{animal_id}/condition', 'AnimalConditionController');  // Done
        Route::resource('animal/{animal_id}/reading', 'AnimalReadingController'); //  Done
        Route::resource('animal/{animal_id}/reading/{reading_id}/symptom', 'AnimalReadingSymptomController'); // Done
        Route::resource('user/request', 'VetRequestController'); // Needs not allow muliple requests for same animal  

    });
    
    
    
    Route::group(['before' => 'vet.auth.api'], function()
    {    
        
        Route::post('vet/logout', ['as' => 'api.vet.logout','uses' => 'VetAuthController@postLogout']); // 
        // Route::resource('request/{id}/approve', 'AnimalRequestController@approveRequest'); // Only show if in date. On approval start the count down for expiry
        Route::resource('vet/request', 'AnimalRequestController'); // veiw all requests and singular requests
        Route::resource('vet/animal', 'AnimalController', ['only' => ['show', 'index']]); // View all vet animals
        Route::resource('vet/animal.reading', 'AnimalReadingController', ['only' => ['show', 'update', 'index']]);  
        Route::resource('vet/animal.reading.symptom', 'AnimalReadingSymptomController'); //  done
        Route::resource('vet', 'VetController', ['only' => ['update', 'destroy']]); // 
        
    });
        
    
    
    
    Route::any('{url?}', function()
        {                                                                     
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
        })
        ->where('url', '.*');
});
