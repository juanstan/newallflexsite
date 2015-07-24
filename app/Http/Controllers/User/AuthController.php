<?php namespace App\Http\Controllers\User;

use App\Models\Entities\Animal;
use App\Models\Entities\SensorReading;
use App\Models\Entities\SensorReadingSymptom;
use App\Models\Entities\User;
use App\Models\Entities\Animal\Request;
use App\Models\Entities\Profile;
use App\Models\Repositories\AnimalRepositoryInterface;
use App\Models\Repositories\AnimalReadingRepositoryInterface;
use App\Models\Repositories\AnimalReadingSymptomRepositoryInterface;
use App\Models\Repositories\UserRepositoryInterface;

class AuthController extends \App\Http\Controllers\Controller
{

    protected $userRepository;
    protected $animalRepository;
    protected $animalReadingRepository;
    protected $animalReadingSymptomRepository;

    public function __construct(UserRepositoryInterface $userRepository, AnimalRepositoryInterface $animalRepository, AnimalReadingRepositoryInterface $animalReadingRepository, AnimalReadingSymptomRepositoryInterface $animalReadingSymptomRepository)
    {
        $this->authUser = \Auth::user()->get();
        $this->userRepository = $userRepository;
        $this->animalReadingRepository = $animalReadingRepository;
        $this->animalRepository = $animalRepository;
        $this->animalReadingSymptomRepository = $animalReadingSymptomRepository;
        $this->middleware('auth.user',
            array('only' =>
                array(
                    'getLogout'
                )
            )
        );
    }

    public function getIndex()
    {
        if (\Auth::user()->check()) {
            return \Redirect::route('user.dashboard');
        }
        return \View::make('user.welcome');
    }

    public function getRegister()
    {
        return \View::make('user.register');
    }

    public function postCreate()
    {
        $confirmation_code = str_random(30);
        \Input::merge(array('confirmation_code' => $confirmation_code, 'units' => 'F', 'weight_units' => 'kg'));
        $input = \Input::all();
        $validator = $this->userRepository->getCreateValidator($input);
        if ($validator->fails()) {
            return \Redirect::route('user.register')
                ->withErrors($validator)
                ->withInput(\Input::except('password'));
        }

        $user = $this->userRepository->create($input);
        if ($user == null) {
            \App::abort(500);
        }
        \Auth::user()->login($user);
        return \Redirect::route('user.register.about');
    }

    public function getResendConfirmation()
    {
        $this->animalRepository->setUser($this->authUser);
        \Mail::send('emails.user-verify', array('confirmation_code' => $this->authUser->confirmation_code), function ($message) {
            $message->to($this->authUser->email, 'New user')
                ->subject('Verify your email address');
        });
        \Session::flash('message', 'Verification email sent');
        return \Redirect::route('user.dashboard');
    }

    public function getVerify($confirmation_code)
    {
        if (!$confirmation_code) {
            return \Redirect::route('user')
                ->with('error', \Lang::get('general.Confirmation not provided'));
        }
        $user = User::where('confirmation_code', '=', $confirmation_code)->first();
        if (!$user) {
            return \Redirect::route('user')
                ->with('error', \Lang::get('general.Confirmation code is invalid'));
        }
        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();
        if (\Auth::user()->check()) {
            return \Redirect::route('user.dashboard')
                ->with('success', \Lang::get('general.You have successfully verified your account.'));
        }
        return \Redirect::route('user');
    }

    public function postLogin()
    {

        $input = \Input::all();
        $validator = $this->userRepository->getLoginValidator($input);
        if ($validator->fails()) {
            return \Redirect::route('user')
                ->withErrors($validator)
                ->withInput(\Input::except('password'));
        } else {

            $userData = array(
                'email' => \Input::get('email'),
                'password' => \Input::get('password')
            );

            if (\Auth::user()->attempt($userData)) {

                return \Redirect::route('user.dashboard')
                    ->with('success', \Lang::get('general.You have logged in successfully'));
            }
            else
            {
                return \Redirect::route('user')
                    ->with('error', \Lang::get('general.The password used is incorrect.'))
                    ->withInput(\Input::except('password'));
            }
        }
    }

    public function getDelete()
    {
        $id = $this->authUser->id;
        Request::where('user_id', '=', $id)->delete();
        Profile::where('user_id', '=', $id)->delete();
        $animals = Animal::where('user_id', '=', $id)->get();
        foreach ($animals as $animal) {
            $animal_id = $animal->id;
            $sensor_readings = SensorReading::where('animal_id', '=', $animal_id)->get();
            foreach ($sensor_readings as $sensor_reading) {
                $sensor_reading_id = $sensor_reading->id;
                SensorReadingSymptom::where('reading_id', '=', $sensor_reading_id)->delete();
            }
            SensorReading::where('animal_id', '=', $animal_id)->delete();
        }
        Animal::where('user_id', '=', $id)->delete();
        $this->authUser->delete();
        return \Redirect::route('user')->with('success', \Lang::get('general.Your account was successfully deleted'));
    }

    public function getLogout()
    {
        \Auth::user()->logout();
        return \Redirect::route('user')->with('success', \Lang::get('general.You are now logged out!'));
    }

}
