<?php

Route::post('auth/{provider}/login', ['as' => 'api.auth.external.login', 'uses' => 'ExternalController@postLogin']);
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
    Route::resource('pet', 'PetController'); // Done
    Route::resource('device', 'DeviceController'); // Done
    Route::resource('photo', 'PhotoController'); // Done
    Route::resource('request', 'PetRequestController');
    Route::post('user/photo', ['as' => 'api.user.photo', 'uses' => 'UserController@postPhoto']); // Done
    Route::resource('pet/{pet_id}/condition', 'PetConditionController');  // Done
    Route::resource('pet/{pet_id}/reading', 'PetReadingController'); //  Done
    Route::post('pet/{pet_id}/photo', ['as' => 'api.pet.{pet_id}.photo', 'uses' => 'PetController@postPhoto']); // Done
    Route::post('pet/{pet_id}/reading/assign', ['as' => 'api.pet.{pet_id}.reading.assign', 'uses' => 'PetReadingController@postAssign']); // Done
    Route::resource('pet/{pet_id}/reading/{reading_id}/symptom', 'PetReadingSymptomController'); // Done
});

Route::group(['middleware' => 'auth.apiVet'], function () {
    Route::post('vet/logout', ['as' => 'api.vet.logout', 'uses' => 'VetAuthController@postLogout']); //
    Route::resource('vet/pet', 'PetController', ['only' => ['show', 'index']]); // View all vet pets
    Route::resource('vet/pet/reading', 'PetReadingController', ['only' => ['show', 'update', 'index']]);
    Route::resource('vet/pet/reading/symptom', 'PetReadingSymptomController'); //  done
    Route::resource('vet', 'VetController', ['only' => ['update', 'destroy']]); //
});

Route::any('{url?}', function () {
    throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
})
    ->where('url', '.*');