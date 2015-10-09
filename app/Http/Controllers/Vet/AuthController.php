<?php namespace App\Http\Controllers\Vet;

use Auth;
use View;
use Input;
use Lang;

use App\Models\Entities\Pet;
use App\Models\Entities\User;
use App\Models\Entities\Vet;
use App\Models\Repositories\PetRepositoryInterface;
use App\Models\Repositories\PetReadingRepositoryInterface;
use App\Models\Repositories\PetReadingSymptomRepositoryInterface;
use App\Models\Repositories\VetRepositoryInterface;
use App\Models\Repositories\PetRequestRepository;
use App\Http\Controllers\Controller;

class AuthController extends Controller {

	protected $vetRepository;
    protected $petRepository;
    protected $petReadingRepository;
    protected $petReadingSymptomRepository;
    protected $petRequestRepository;

	public function __construct(VetRepositoryInterface $vetRepository, 
                                PetRepositoryInterface $petRepository,
                                PetReadingRepositoryInterface $petReadingRepository,
                                PetReadingSymptomRepositoryInterface $petReadingSymptomRepository,
                                PetRequestRepository $petRequestRepository
    )
        
	{
        $this->authVet = Auth::vet()->get();
		$this->vetRepository = $vetRepository;
        $this->petReadingRepository = $petReadingRepository;
        $this->petRepository = $petRepository;
        $this->petReadingSymptomRepository = $petReadingSymptomRepository;
        $this->middleware('vetAuth', array('only'=>array('getLogout')));
	}
    
    public function getIndex() {
        if (Auth::vet()->check())
        {
            return redirect()->route('vet.dashboard');
        }
            return View::make('vet.welcome');
    }
    
    public function getRegister() {
        return View::make('vet.register');
    }
    
    public function postCreate() {

        $confirmation_code = str_random(30);
        Input::merge(array('confirmation_code' => $confirmation_code, 'units' => 1));
        $input = Input::all();

        $validator = $this->vetRepository->getCreateValidator($input);

        if($validator->fails())
        {
            
            return redirect()->route('vet.register')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
            
        }

//        \Mail::send('emails.vet-verify', array('confirmation_code' => $confirmation_code), function($message) {
//            $message->to(Input::get('email'), 'New user')
//                ->subject('Verify your email address');
//        });

        $vet = $this->vetRepository->create($input);

        if($vet == null)
        {
            \App::abort(500);
        }

        Auth::vet()->login($vet);
        
        return redirect()->route('vet.register.about');
         
    }

    public function getResendConfirmation() {
        $this->petRepository->setUser($this->authVet);
        \Mail::send('emails.vet-verify', array('confirmation_code' => $this->authVet->confirmation_code), function($message) {
            $message->to($this->authVet->email, 'New vetRepository')
                ->subject('Verify your email address');
        });
        return redirect()->route('vet.dashboard')
            ->with('message', Lang::get('general.Verification email sent'));
    }

    public function getVerify($confirmation_code) {

        if(!$confirmation_code)
        {
            return redirect()->route('vet')
                ->with('error', Lang::get('general.Confirmation not provided'));
        }

        $vet = Vet::where('confirmation_code', '=', $confirmation_code)->first();

        if(!$vet)
        {
            return redirect()->route('vet')
                ->with('error', Lang::get('general.Confirmation code invalid'));
        }

        $vet->confirmed = 1;
        $vet->confirmation_code = null;
        $vet->save();

        if (Auth::vet()->check())
        {
            return redirect()->route('vet.dashboard')
                ->with('success', Lang::get('general.You have successfully verified your account'));
        }
        return redirect()->route('vet')
            ->with('success', Lang::get('general.You have successfully verified your account'));
    }

	public function postLogin()
	{
		$input = Input::all();
		$validator = $this->vetRepository->getLoginValidator($input);
		if($validator->fails())
		{
			return redirect()->route('vet')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
		}else {

            $vetData = array(
                'email' => Input::get('email'),
                'password' => Input::get('password')
            );

            if (Auth::vet()->attempt($vetData)) {
  
                return redirect()->route('vet.dashboard')
                    ->with('success', Lang::get('general.You have logged in successfully'));

            }
            else
            {
                return redirect()->route('user')
                    ->with('error', Lang::get('general.The password used is incorrect.'))
                    ->withInput(Input::except('password'));
            }

        }
	}

    public function getDelete() {
        $id =  $this->authVet->id;
        $this->petRequestRepository->removeByVetId($id);
        \DB::table('vet_readings')->where('vet_id', '=', $id)->delete();
        $this->authVet->delete();
        return redirect()->route('vet')
            ->with('success', Lang::get('general.Your account was successfully deleted'));
    }

    public function getLogout() {
        Auth::vet()->logout();
        return redirect()->route('vet')
            ->with('success', Lang::get('general.Your are now logged out!'));
    }
    
}
