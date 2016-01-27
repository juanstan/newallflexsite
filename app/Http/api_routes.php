<?php

//Route::post('auth/{provider}/login', ['as' => 'api.auth.external.login', 'uses' => 'ExternalController@postLogin']);

Route::post('user/login', ['as' => 'api.user.login', 'uses' => 'AuthController@postLogin']); // Done
Route::resource('user', 'UserController', ['only' => ['store']]); // Done
Route::post('vet/login', ['as' => 'api.vet.login', 'uses' => 'VetAuthController@postLogin']); // Done
Route::resource('vet', 'VetController', ['only' => ['store', 'index']]); // Done
Route::get('vet/{vet}', ['as' => 'api.vet.show', 'uses' => 'VetController@show'])->where('vet', '[0-9]+'); // Done
Route::post('password/reset', ['as' => 'api.password.reset', 'uses' => 'PasswordController@postRequest']); // Done
Route::resource('password', 'PasswordController', ['only' => ['store', 'index', 'show']]); // Done
Route::resource('symptoms', 'SymptomController', ['only' => ['index', 'show']]); // Done
Route::resource('breeds', 'BreedController', ['only' => ['index', 'show']]); // Done
Route::resource('conditions', 'ConditionController', ['only' => ['index', 'show']]); // Done

Route::controller('vet/search', 'VetSearchController', array(
    'getAll'=>'api.vet.search.all',
    'postLocation'=>'api.vet.search.location',
    'getLocation'=>'api.vet.search.location',
    'postName'=>'api.vet.search.name',
));

Route::group(['middleware' => 'auth.apiUser'], function () {
    Route::post('user/logout', ['as' => 'api.user.logout', 'uses' => 'AuthController@postLogout']);

    Route::resource('user', 'UserController', ['only' => ['show', 'update', 'destroy']]);
    Route::resource('pet', 'PetController', ['only' => ['show', 'update', 'destroy', 'index', 'store']]);
    Route::resource('device', 'DeviceController', ['only' => ['show', 'update', 'destroy', 'index', 'store']]);
    Route::resource('photo', 'PhotoController', ['only' => ['show', 'update', 'destroy', 'index', 'store']]);

    Route::resource('pet/{pet_id}/vet', 'PetRequestController', ['only' => ['index', 'store', 'show', 'destroy']]);
    Route::resource('pet/{pet_id}/reading', 'PetReadingController', ['only' => ['index', 'store', 'show', 'destroy']]);
    Route::resource('pet/{pet_id}/condition', 'PetConditionController', ['only' => ['index', 'store', 'show', 'destroy']]);
    Route::resource('pet/{pet_id}/reading/{reading_id}/symptom', 'PetReadingSymptomController', ['only' => ['index', 'store', 'show', 'destroy']]);

    //Route::post('pet/{pet_id}/reading/assign', ['as' => 'api.pet.{pet_id}.reading.assign', 'uses' => 'PetReadingController@postAssign']); //???We really need it
    Route::post('pet/{pet_id}/photo', ['as' => 'api.pet.{pet_id}.photo', 'uses' => 'PetController@postPhoto']);
    Route::post('user/photo', ['as' => 'api.user.photo', 'uses' => 'UserController@postPhoto']);

});

/*Route::group(['middleware' => 'auth.apiVet'], function () {
    Route::post('vet/logout', ['as' => 'api.vet.logout', 'uses' => 'VetAuthController@postLogout']); //
    Route::resource('vet/pet', 'PetController', ['only' => ['show', 'index']]); // View all vet pets
    Route::resource('vet/pet/{pet}/reading', 'PetReadingController', ['only' => ['show', 'update', 'index', 'destroy']]);
    Route::resource('vet', 'VetController', ['only' => ['update', 'destroy']]); //
    Route::resource('vet/pet/{pet}/reading/{reading}/symptom', 'PetReadingSymptomController'); //  done
});*/

Route::any('{url?}', function () {
    throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
})
    ->where('url', '.*');