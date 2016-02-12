<?php namespace App\Http\Controllers\User;

use Validator;
use Password;
use Lang;
use Input;
/*use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
*/
class PasswordController extends \App\Http\Controllers\Controller {

    public function getRequest()
    {
        return \View::make('user.request');
    }

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

            return \Redirect::route('user')
                ->with('success', \Lang::get('general.Your request to reset your password has been accepted, we have sent further details to your email address'));
        }
        else{
            return \Redirect::route('user.password.request')
                ->with('error', \Lang::get('general.This email does not exist'));
        }


    }

    public function getReset($token = null)
    {
        if (is_null($token)) App::abort(404);

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


        $response = \Password::user()->reset($credentials, function ($user, $password) {

            $user->password = $password;
            $user->save();

        });

        switch ($response)
        {
            case \Password::INVALID_PASSWORD:
            case \Password::INVALID_TOKEN:
            case \Password::INVALID_USER:
                return \Redirect::back()->with('error', \Lang::get($response));

            case \Password::PASSWORD_RESET:
                return \Redirect::route('user')->with('success', \Lang::get('general.Your password has been reset successfully'));
        }

    }
}
