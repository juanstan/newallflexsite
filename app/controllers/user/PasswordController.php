<?php namespace User;

class PasswordController extends \BaseController {

    public function getRequest()
    {
        return \View::make('user.request');
    }

    public function postRequest()
    {
        \Password::user()->remind(\Input::only('email'), function($message) {
            $message->subject('Password reminder');
        });
        return \Redirect::route('user')
            ->with('success', \Lang::get('general.Your request to reset your password has been accepted, we have sent further details to your email address'));
    }

    public function getReset($token)
    {
        return \View::make('user.reset')
            ->with('token', $token);
    }

    public function postReset()
    {
        $credentials = array(
            'email' => \Input::get('email'),
            'password' => \Input::get('password'),
            'password_confirmation' => \Input::get('password_confirmation'),
            'token' => \Input::get('token')
        );
        \Password::user()->reset($credentials, function($user, $password) {
            $user->password = \Hash::make($password);
            $user->save();
            return Redirect::route('user')
                ->with('success', 'Your password has been reset');
        });
    }
}

//Password::account()->remind(Input::only('email'), function($message) {
//$message->subject('Password reminder');
//});
//
//
//
//Password::account()->reset($credentials, function($user, $password) {
//$user->password = Hash::make($password);
//$user->save();
//});