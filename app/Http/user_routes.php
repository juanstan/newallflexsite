<?php

Route::get('auth/{provider}/redirect', ['as' => 'user.auth.external.redirect', 'uses' => 'ExternalController@getRedirect']);
Route::get('auth/{provider}/callback', ['as' => 'user.auth.external.callback', 'uses' => 'ExternalController@getCallback']);

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
Route::controller('register/reading', 'PetReadingRegisterController',
    array(
        'getIndex'=>'user.register.reading',
        'postReadingUpload'=>'user.register.reading.readingUpload',
        'getAssign'=>'user.register.reading.assign',
        'postAssign'=>'user.register.reading.assign',
        'getFinish'=>'user.register.reading.finish',
        'getInstructions'=>'user.register.reading.instructions'
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