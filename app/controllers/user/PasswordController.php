<?php namespace User;

class PasswordController extends \BaseController {

    public function getIndex()
    {
        return \View::make('user.remind');
    }

    public function postIndex()
    {
        \Password::user()->remind(\Input::only('email'), function($message) {
            $message->subject('Password reminder');
        });
        return \Redirect::route('user')->with('success', \Lang::get('general.Your request to reset your password has been accepted, we have sent further details to your email address'));
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