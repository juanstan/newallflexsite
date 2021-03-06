<?php namespace App\Http\Controllers\Api;

use Validator;
use Password;
use Lang;
use Input;

use App\Http\Controllers\Controller;

class PasswordController extends Controller {

    public function postRequest()
    {

        $rules = array (
            'email' => 'required|email|exists:users',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator -> passes()){
            Password::user()->sendResetLink(Input::only('email'), function ($message) {
                $message->subject('Password reminder');
            });

            return response()->json(array(
                'error' => false,
                'result' => Lang::get('general.Your request to reset your password has been accepted, we have sent further details to your email address')),
                200
            );
        }
        else{
            return response()->json(array(
                'error' => true,
                'result' => Lang::get('general.This email does not exist')),
                200
            );
        }

    }
}
