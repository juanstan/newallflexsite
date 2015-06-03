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

Route::group(['prefix' => 'user', 'namespace' => 'user'], function () {
    Route::controller('facebook', 'FacebookController',
        array(
            'getCreate'=>'user.facebook.create',
            'getLogin'=>'user.facebook.login',
        ));
    Route::controller('twitter', 'TwitterController',
        array(
            'getCreate'=>'user.twitter.create',
            'getLogin'=>'user.twitter.login',
        ));
    Route::controller('register/pet', 'PetRegisterController',
        array(
            'getIndex'=>'user.register.pet',
            'getCreate'=>'user.register.pet.create',
            'postCreate'=>'user.register.pet.create',
        ));
    Route::controller('register/vet', 'VetRegisterController',
        array(
            'getIndex'=>'user.register.vet',
            'getAdd'=>'user.register.vet.add',
            'getAddVet'=>'user.register.vet.addVet',
        ));
    Route::controller('register/reading', 'AnimalReadingRegisterController',
        array(
            'getIndex'=>'user.register.reading',
            'postReadingUpload'=>'user.register.reading.readingUpload',
            'getAssign'=>'user.register.reading.assign',
            'postAssign'=>'user.register.reading.assign',
            'getFinish'=>'user.register.reading.finish',
        ));
    Route::controller('register', 'RegisterController',
        array(
            'getAbout'=>'user.register.about',
            'postAbout'=>'user.register.about',
        ));
    Route::controller('dashboard', 'DashboardController',
        array(
            'getIndex' => 'user.dashboard',
            'getHelp' => 'user.dashboard.help',
            'getResult' => 'user.dashboard.result',
            'postInvite' => 'user.dashboard.invite',
            'postResetAverageTemperature' => 'user.dashboard.resetAverageTemperature',
            'getSettings' => 'user.dashboard.settings',
            'postSettings' => 'user.dashboard.settings',
            'postUpdatePet' => 'user.dashboard.updatePet',
            'postAddConditions' => 'user.dashboard.addConditions',
            'postAddSymptoms' => 'user.dashboard.addSymptoms',
            'getSymptomRemove' => 'user.dashboard.symptomRemove',
            'postUpdatePetPhoto' => 'user.dashboard.updatePetPhoto',
            'postCreatePet' => 'user.dashboard.createPet',
            'getRemovePet' => 'user.dashboard.removePet',
            'postReadingUpload' => 'user.dashboard.readingUpload',
            'getVet' => 'user.dashboard.vet',
            'getVetSearch' => 'user.dashboard.vetSearch',
            'getVetSearchLocation' => 'user.dashboard.vetSearchLocation',
            'getAddVet' => 'user.dashboard.addVet',
            'getRemoveVet' => 'user.dashboard.removeVet',
            'getActivatepet' => 'user.dashboard.activatePet',
            'getDeactivatepet' => 'user.dashboard.deactivatePet',
            'postAssign' => 'user.dashboard.assign',
        ));
    Route::controller('password', 'PasswordController',
        array(
            'getRequest' => 'user.password.request',
            'postRequest' => 'user.password.request',
            'getReset' => 'user.password.reset',
            'postReset' => 'user.password.reset'
        ));
    Route::controller('/', 'AuthController',
        array(
            'getIndex' => 'user',
            'getRegister' => 'user.register',
            'postCreate' => 'user.create',
            'getResendConfirmation' => 'user.resendConfirmation',
            'getVerify' => 'user.verify',
            'postLogin' => 'user.login',
            'getDelete' => 'user.delete',
            'getLogout' => 'user.logout',
        ));

});

Route::group(['prefix' => 'vet', 'namespace' => 'vet'], function () {
    Route::controller('register/reading', 'AnimalReadingRegisterController',
        array(
            'getIndex'=>'vet.register.reading'
        ));
    Route::controller('register', 'RegisterController',
        array(
            'getAbout'=>'vet.register.about',
            'postAbout'=>'vet.register.about',
            'getAddress'=>'vet.register.address',
            'postAddress'=>'vet.register.address',
        ));
    Route::controller('dashboard', 'DashboardController',
        array(
            'getIndex'=>'vet.dashboard',
            'getHelp'=>'vet.dashboard.help',
            'getResult'=>'vet.dashboard.result',
            'postInvite'=>'vet.dashboard.invite',
            'getPet'=>'vet.dashboard.pet',
            'postResetAverageTemperature'=>'vet.dashboard.resetAverageTemperature',
            'getSettings'=>'vet.dashboard.settings',
            'postSettings'=>'vet.dashboard.settings',
            'postReadingUpload'=>'vet.dashboard.readingUpload',
        ));
    Route::controller('/', 'AuthController',
        array(
            'getIndex'=>'vet',
            'getRegister'=>'vet.register',
            'postCreate'=>'vet.create',
            'getResendConfirmation'=>'vet.resendConfirmation',
            'getVerify'=>'vet.verify',
            'postLogin'=>'vet.login',
            'getDelete'=>'vet.delete',
            'getLogout'=>'vet.logout',
        ));
});


Route::group(['prefix' => 'api', 'before' => 'api.before', 'namespace' => 'api'], function () {
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
    Route::group(['before' => 'auth.api'], function () {
        Route::post('user/logout', ['as' => 'api.user.logout', 'uses' => 'AuthController@postLogout']); // Done
        Route::resource('user', 'UserController', ['only' => ['show', 'update', 'destroy']]); // Done
        Route::resource('animal', 'AnimalController'); // Done
        Route::resource('device', 'DeviceController'); // Done
        Route::resource('request', 'AnimalRequestController');
        Route::resource('animal/{animal_id}/condition', 'AnimalConditionController');  // Done
        Route::resource('animal/{animal_id}/reading', 'AnimalReadingController'); //  Done
        Route::resource('animal/{animal_id}/reading/{reading_id}/symptom', 'AnimalReadingSymptomController'); // Done

    });

    Route::group(['before' => 'vet.auth.api'], function () {
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
});
