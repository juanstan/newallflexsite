<?php namespace Vet;

use Entities\Animal;
use Entities\User;
use Entities\Vet;
use Entities\SensorReading;
use Entities\SensorReadingSymptom;
use Entities\Symptom;
use Repositories\AnimalRepositoryInterface;
use Repositories\AnimalReadingRepositoryInterface;
use Repositories\AnimalReadingSymptomRepositoryInterface;
use Repositories\VetRepositoryInterface;
use League\Csv\Reader;

class AuthController extends \BaseController {

	protected $vetRepository;
    protected $animalRepository;
    protected $animalReadingRepository;
    protected $animalReadingSymptomRepository;

	public function __construct(VetRepositoryInterface $vetRepository, AnimalRepositoryInterface $animalRepository, AnimalReadingRepositoryInterface $animalReadingRepository, AnimalReadingSymptomRepositoryInterface $animalReadingSymptomRepository)
	{
        $this->authVet = \Auth::vet()->get();
		$this->vetRepository = $vetRepository;
        $this->animalReadingRepository = $animalReadingRepository;
        $this->animalRepository = $animalRepository;
        $this->animalReadingSymptomRepository = $animalReadingSymptomRepository;
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('vetAuth', array('only'=>array('getLogout')));
       
	}
    
    public function getIndex() {
        if (\Auth::vet()->check())
        {
            return \Redirect::route('vet.dashboard');
        }
            return \View::make('vet.welcome');
    }
    
    public function getRegister() {
        return \View::make('vet.register');
    }
    
    public function postCreate() {

        $confirmation_code = str_random(30);
        \Input::merge(array('confirmation_code' => $confirmation_code, 'units' => 'F'));
        $input = \Input::all();

        $validator = $this->vetRepository->getCreateValidator($input);

        if($validator->fails())
        {
            
            return \Redirect::route('vet.register')
                ->withErrors($validator)
                ->withInput(\Input::except('password'));
            
        }

        \Mail::send('emails.vet-verify', array('confirmation_code' => $confirmation_code), function($message) {
            $message->to(\Input::get('email_address'), 'New user')
                ->subject('Verify your email address');
        });

        $vet = $this->vetRepository->create($input);

        if($vet == null)
        {
            \App::abort(500);
        }
        
        \Auth::vet()->login($vet);
        
        return \Redirect::route('vet.register.about');
         
    }

    public function getResendConfirmation() {
        $this->animalRepository->setUser($this->authVet);
        \Mail::send('emails.vet-verify', array('confirmation_code' => $this->authVet->confirmation_code), function($message) {
            $message->to($this->authVet->email_address, 'New vetRepository')
                ->subject('Verify your email address');
        });
        \Session::flash('message', 'Verification email sent');
        return \Redirect::route('vet.dashboard');
    }

    public function getVerify($confirmation_code) {

        if(!$confirmation_code)
        {
            \Session::flash('warning', 'Confirmation not provided');
            return \Redirect::route('vet');
        }

        $vet = Vet::where('confirmation_code', '=', $confirmation_code)->first();

        if(!$vet)
        {
            \Session::flash('warning', 'Confirmation code invalid');
            return \Redirect::route('vet');
        }

        $vet->confirmed = 1;
        $vet->confirmation_code = null;
        $vet->save();

        \Session::flash('success', 'You have successfully verified your account.');
        if (\Auth::vet()->check())
        {
            return \Redirect::route('vet.dashboard');
        }
        return \Redirect::route('vet');
    }

	public function postLogin()
	{
		$input = \Input::all();
		$validator = $this->vetRepository->getLoginValidator($input);
		if($validator->fails())
		{
			return \Redirect::route('vet')
                ->withErrors($validator)
                ->withInput(\Input::except('password'));
		}else {

            $vetData = array(
                'email_address' => \Input::get('email_address'),
                'password' => \Input::get('password')
            );

            if (\Auth::vet()->attempt($vetData)) {
  
                return \Redirect::route('vet.dashboard')
                    ->with('success', 'You have logged in successfully');

            }
            else
            {
                return \Redirect::route('user')
                    ->with('error', 'The password used is incorrect.')
                    ->withInput(\Input::except('password'));
            }

        }
	}

    public function getDelete() {
        $id =  $this->authVet->id;
        \DB::table('animal_requests')->where('vet_id', '=', $id)->delete();
        \DB::table('vet_readings')->where('vet_id', '=', $id)->delete();
        $this->authVet->delete();
        return \Redirect::route('vet')->with('success', 'Your account was successfully deleted');
    }

    public function getLogout() {
        \Auth::vet()->logout();
        return \Redirect::route('vet')->with('success', 'Your are now logged out!');
    }
    
}
