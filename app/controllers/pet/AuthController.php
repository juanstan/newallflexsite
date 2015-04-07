<?php namespace Pet;

use Entities\Animal;
use Entities\User;
use Entities\Reading;
use Entities\Symptom;
use Entities\SymptomNames;
use Repositories\AnimalRepositoryInterface;
use Repositories\AnimalReadingRepositoryInterface;
use Repositories\AnimalReadingSymptomRepositoryInterface;
use Repositories\UserRepositoryInterface;
use League\Csv\Reader;

class AuthController extends \BaseController {

	protected $user;
    protected $repository;
    protected $rrepository;
    protected $srepository;
    
	public function __construct(UserRepositoryInterface $user, AnimalRepositoryInterface $repository, AnimalReadingRepositoryInterface $rrepository, AnimalReadingSymptomRepositoryInterface $srepository)
	{
        $this->authUser = \Auth::user()->get();
		$this->user = $user;
        $this->rrepository = $rrepository;
        $this->repository = $repository;
        $this->srepository = $srepository;
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('auth', array('only'=>array('getLogout')));
       
	}
    
    public function getIndex() {
        if (\Auth::user()->check())
        {
            return \Redirect::to('pet/dashboard');
        }
            return \View::make('pet.welcome');
    }
    
    public function getRegister() {
        return \View::make('pet.register');
    }
    
    public function postCreate() {

        $confirmation_code = str_random(30);
        \Input::merge(array('confirmation_code' => $confirmation_code, 'units' => 'F'));
        $input = \Input::all();

        $validator = $this->user->getCreateValidator($input);

        if($validator->fails())
        {
            
            return \Redirect::to('pet/register')
                ->withErrors($validator)
                ->withInput(\Input::except('password'));
            
        }

        \Mail::send('emails.pet-verify', array('confirmation_code' => $confirmation_code), function($message) {
            $message->to(\Input::get('email_address'), 'New user')
                ->subject('Verify your email address');
        });

        $user = $this->user->create($input);

        if($user == null)
        {
            \App::abort(500);
        }
        
        \Auth::user()->login($user);
        
        return \Redirect::to('pet/register/about');
         
    }

    public function getResendConfirmation() {
        $this->repository->setUser($this->authUser);
        \Mail::send('emails.pet-verify', array('confirmation_code' => \Auth::user()->get()->confirmation_code), function($message) {
            $message->to(\Auth::user()->get()->email_address, 'New user')
                ->subject('Verify your email address');
        });
        \Session::flash('message', 'Verification email sent');
        return \Redirect::to('/pet/dashboard');
    }

    public function getVerify($confirmation_code) {

        if(!$confirmation_code)
        {
            \Session::flash('warning', 'Confirmation not provided');
            return \Redirect::to('pet');
        }

        $user = User::where('confirmation_code', '=', $confirmation_code)->first();

        if(!$user)
        {
            \Session::flash('warning', 'Confirmation code invalid');
            return \Redirect::to('pet');
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        \Session::flash('success', 'You have successfully verified your account.');
        if (\Auth::user()->check())
        {
            return \Redirect::to('pet/dashboard');
        }
        return \Redirect::to('pet');
    }

	public function postLogin()
	{
		$input = \Input::all();
        
		$validator = $this->user->getLoginValidator($input);

		if($validator->fails())
		{
			return \Redirect::to('/pet')
                ->withErrors($validator)
                ->withInput(\Input::except('password'));
		}else {

            $userdata = array(
                'email_address' => \Input::get('email_address'),
                'password' => \Input::get('password')
            );

            if (\Auth::user()->attempt($userdata)) {
                
                $first_name = \Auth::user()->get()->first_name;
                $last_name = \Auth::user()->get()->last_name;
  
                return \Redirect::to('pet/dashboard');

            }

        }
	}

    public function getDelete() {
        $id =  \Auth::user()->get()->id;
        \DB::table('animal_requests')->where('user_id', '=', $id)->delete();
        \DB::table('profiles')->where('user_id', '=', $id)->delete();
        $animals = \DB::table('animals')->where('user_id', '=', $id)->get();
        foreach ($animals as $animal)
        {
            $animal_id = $animal->id;
            $sensor_readings = \DB::table('sensor_readings')->where('animal_id', '=', $animal_id)->get();
            foreach ($sensor_readings as $sensor_reading)
            {
                $sensor_reading_id = $sensor_reading->id;
                \DB::table('sensor_reading_symptoms')->where('reading_id', '=', $sensor_reading_id)->delete();
            }
            \DB::table('sensor_readings')->where('animal_id', '=', $animal_id)->delete();
        }
        \DB::table('animals')->where('user_id', '=', $id)->delete();
        \Auth::user()->get()->delete();
        return \Redirect::to('/pet')->with('success', 'Your account was successfully deleted');
    }

    public function getLogout() {
        \Auth::user()->logout();
        return \Redirect::to('/pet')->with('success', 'Your are now logged out!');
    }
    
}
