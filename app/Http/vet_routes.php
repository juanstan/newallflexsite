<?php

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