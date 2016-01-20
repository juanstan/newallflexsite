<?php

Route::controller('register/reading', 'PetReadingRegisterController',
    array(
        'getIndex'=>'vet.register.reading',
        'getInstructions'=>'vet.register.reading.instructions'
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
        'postAssign' => 'vet.dashboard.assign',
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