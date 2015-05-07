<?php namespace Vet;

use Entities\Animal;
use Entities\User;
use Entities\Vet;
use Entities\Reading;
use Entities\Symptom;
use Entities\SymptomNames;
use Repositories\AnimalRepositoryInterface;
use Repositories\AnimalReadingRepositoryInterface;
use Repositories\AnimalReadingSymptomRepositoryInterface;
use Repositories\VetRepositoryInterface;
use League\Csv\Reader;

class AuthController extends \BaseController {

	protected $user;
    protected $repository;
    protected $rrepository;
    protected $srepository;

	public function __construct(VetRepositoryInterface $user, AnimalRepositoryInterface $repository, AnimalReadingRepositoryInterface $rrepository, AnimalReadingSymptomRepositoryInterface $srepository)
	{
        $this->authUser = \Auth::vet()->get();
		$this->user = $user;
        $this->rrepository = $rrepository;
        $this->repository = $repository;
        $this->srepository = $srepository;
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

        $validator = $this->user->getCreateValidator($input);

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

        $user = $this->user->create($input);

        if($user == null)
        {
            \App::abort(500);
        }
        
        \Auth::vet()->login($user);
        
        return \Redirect::route('vet.register.about');
         
    }

    public function getResendConfirmation() {
        $this->repository->setUser($this->authUser);
        \Mail::send('emails.vet-verify', array('confirmation_code' => \Auth::vet()->get()->confirmation_code), function($message) {
            $message->to(\Auth::vet()->get()->email_address, 'New user')
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

        $user = Vet::where('confirmation_code', '=', $confirmation_code)->first();

        if(!$user)
        {
            \Session::flash('warning', 'Confirmation code invalid');
            return \Redirect::route('vet');
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

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
        
		$validator = $this->user->getLoginValidator($input);

		if($validator->fails())
		{
			return \Redirect::route('vet')
                ->withErrors($validator)
                ->withInput(\Input::except('password'));
		}else {

            $userdata = array(
                'email_address' => \Input::get('email_address'),
                'password' => \Input::get('password')
            );

            if (\Auth::vet()->attempt($userdata)) {
  
                return \Redirect::route('vet.dashboard');

            }

        }
	}

    public function getDelete() {
        $id =  \Auth::vet()->get()->id;
        \DB::table('animal_requests')->where('vet_id', '=', $id)->delete();
        \DB::table('vet_readings')->where('vet_id', '=', $id)->delete();
        \Auth::vet()->get()->delete();
        return \Redirect::route('vet')->with('success', 'Your account was successfully deleted');
    }

    public function getLogout() {
        \Auth::vet()->logout();
        return \Redirect::route('vet')->with('success', 'Your are now logged out!');
    }
    
}
