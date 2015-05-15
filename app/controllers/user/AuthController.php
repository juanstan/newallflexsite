<?php namespace User;

use Entities\Animal;
use Entities\User;
use Entities\SensorReading;
use Entities\SensorReadingSymptom;
use Entities\Symptom;
use Repositories\AnimalRepositoryInterface;
use Repositories\AnimalReadingRepositoryInterface;
use Repositories\AnimalReadingSymptomRepositoryInterface;
use Repositories\UserRepositoryInterface;
use League\Csv\Reader;

class AuthController extends \BaseController
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
        $this->beforeFilter('csrf',
            array(
                'on' => 'post'
            )
        );
        $this->beforeFilter('auth',
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
        \Input::merge(array('confirmation_code' => $confirmation_code, 'units' => 'F', 'weight_units' => 'KG'));
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
        \Mail::send('emails.user-verify', array('confirmation_code' => \Auth::user()->get()->confirmation_code), function ($message) {
            $message->to(\Auth::user()->get()->email_address, 'New user')
                ->subject('Verify your email address');
        });
        \Session::flash('message', 'Verification email sent');
        return \Redirect::route('user.dashboard');
    }

    public function getVerify($confirmation_code)
    {
        if (!$confirmation_code) {
            \Session::flash('warning', 'Confirmation not provided');
            return \Redirect::route('user');
        }
        $user = User::where('confirmation_code', '=', $confirmation_code)->first();
        if (!$user) {
            \Session::flash('warning', 'Confirmation code invalid');
            return \Redirect::route('user');
        }
        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();
        \Session::flash('success', 'You have successfully verified your account.');
        if (\Auth::user()->check()) {
            return \Redirect::route('user.dashboard');
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
                'email_address' => \Input::get('email_address'),
                'password' => \Input::get('password'),
            );
            if (\Auth::user()->attempt($userData)) {
                return \Redirect::route('user.dashboard');
            }
        }
    }

    public function getDelete()
    {
        $id = \Auth::user()->get()->id;
        \DB::table('animal_requests')->where('user_id', '=', $id)->delete();
        \DB::table('profiles')->where('user_id', '=', $id)->delete();
        $animals = \DB::table('animals')->where('user_id', '=', $id)->get();
        foreach ($animals as $animal) {
            $animal_id = $animal->id;
            $sensor_readings = \DB::table('sensor_readings')->where('animal_id', '=', $animal_id)->get();
            foreach ($sensor_readings as $sensor_reading) {
                $sensor_reading_id = $sensor_reading->id;
                \DB::table('sensor_reading_symptoms')->where('reading_id', '=', $sensor_reading_id)->delete();
            }
            \DB::table('sensor_readings')->where('animal_id', '=', $animal_id)->delete();
        }
        \DB::table('animals')->where('user_id', '=', $id)->delete();
        \Auth::user()->get()->delete();
        return \Redirect::route('user')->with('success', 'Your account was successfully deleted');
    }

    public function getLogout()
    {
        \Auth::user()->logout();
        return \Redirect::route('user')->with('success', 'Your are now logged out!');
    }

}
