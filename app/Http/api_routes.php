<?php

Route::post('auth/{provider}/login', ['as' => 'api.auth.external.login', 'uses' => 'ExternalController@postLogin']);
Route::get('auth/{provider}/redirect', ['as' => 'api.auth.external.redirect', 'uses' => 'ExternalController@getRedirect']);
Route::get('auth/{provider}/callback', ['as' => 'api.auth.external.callback', 'uses' => 'ExternalController@getCallback']);

Route::post('user/login', ['as' => 'api.user.login', 'uses' => 'AuthController@postLogin']); // Done

Route::resource('user', 'UserController', ['only' => ['store']]); // Done
Route::post('vet/login', ['as' => 'api.vet.login', 'uses' => 'VetAuthController@postLogin']); // Done
Route::resource('vet', 'VetController', ['only' => ['store', 'index', 'show']]); // Done
Route::post('password/reset', ['as' => 'api.password.reset', 'uses' => 'PasswordController@postRequest']); // Done
Route::resource('password', 'PasswordController', ['only' => ['store', 'index', 'show']]); // Done
Route::resource('symptoms', 'SymptomController'); // Done
Route::resource('breeds', 'BreedController'); // Done
Route::resource('conditions', 'ConditionController'); // Done
Route::controller('vet/search', 'VetSearchController', array(
    'getAll'=>'api.vet.search.all',
    'postLocation'=>'api.vet.search.location',
    'getLocation'=>'api.vet.search.location',
    'postName'=>'api.vet.search.name',
));
Route::group(['middleware' => 'auth.apiUser'], function () {
    Route::post('user/logout', ['as' => 'api.user.logout', 'uses' => 'AuthController@postLogout']); // Done
    Route::resource('user', 'UserController', ['only' => ['show', 'update', 'destroy']]); // Done
    Route::resource('animal', 'AnimalController'); // Done
    Route::resource('device', 'DeviceController'); // Done
    Route::resource('photo', 'PhotoController'); // Done
    Route::resource('request', 'AnimalRequestController');
    Route::post('user/photo', ['as' => 'api.user.photo', 'uses' => 'UserController@postPhoto']); // Done
    Route::resource('animal/{animal_id}/condition', 'AnimalConditionController');  // Done
    Route::resource('animal/{animal_id}/reading', 'AnimalReadingController'); //  Done
    Route::post('animal/{animal_id}/photo', ['as' => 'api.animal.{animal_id}.photo', 'uses' => 'AnimalController@postPhoto']); // Done
    Route::post('animal/{animal_id}/reading/assign', ['as' => 'api.animal.{animal_id}.reading.assign', 'uses' => 'AnimalReadingController@postAssign']); // Done
    Route::resource('animal/{animal_id}/reading/{reading_id}/symptom', 'AnimalReadingSymptomController'); // Done

});

Route::group(['middleware' => 'auth.apiVet'], function () {
    Route::post('vet/logout', ['as' => 'api.vet.logout', 'uses' => 'VetAuthController@postLogout']); //
    Route::resource('vet/animal', 'AnimalController', ['only' => ['show', 'index']]); // View all vet animals
    Route::resource('vet/animal.reading', 'AnimalReadingController', ['only' => ['show', 'update', 'index']]);
    Route::resource('vet/animal.reading.symptom', 'AnimalReadingSymptomController'); //  done
    Route::resource('vet', 'VetController', ['only' => ['update', 'destroy']]); //
});

Route::any('{url?}', function () {
    throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
})
    ->where('url', '.*');