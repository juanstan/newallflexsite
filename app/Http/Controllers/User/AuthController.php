<?php namespace App\Http\Controllers\User;

use Auth;
use View;
use Input;
use Session;
use Lang;

use App\Models\Entities\Pet;
use App\Models\Entities\User;
use App\Models\Repositories\PetRepositoryInterface;
use App\Models\Repositories\PetReadingRepositoryInterface;
use App\Models\Repositories\PetReadingSymptomRepositoryInterface;
use App\Models\Repositories\UserRepositoryInterface;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    protected $userRepository;
    protected $petRepository;
    protected $petReadingRepository;
    protected $petReadingSymptomRepository;

    public function __construct(UserRepositoryInterface $userRepository, PetRepositoryInterface $petRepository, PetReadingRepositoryInterface $petReadingRepository, PetReadingSymptomRepositoryInterface $petReadingSymptomRepository)
    {
        $this->authUser = Auth::user()->get();
        $this->userRepository = $userRepository;
        $this->petReadingRepository = $petReadingRepository;
        $this->petRepository = $petRepository;
        $this->petReadingSymptomRepository = $petReadingSymptomRepository;
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
        if (Auth::user()->check()) {
            return redirect()->route('user.dashboard');
        }
        return View::make('user.welcome');
    }

    public function getRegister()
    {
        return View::make('user.register');
    }

    public function postCreate()
    {
        $input = Input::all();
        $input['confirmation_code'] = str_random(30);
        $input['units'] = 0;
        $input['weight_units'] = 0;
        $validator = $this->userRepository->getCreateValidator($input);
        if ($validator->fails()) {
            return redirect()->route('user.register')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        }

        $user = $this->userRepository->create($input);
        if ($user == null) {
            \App::abort(500);
        }
        Auth::user()->login($user);
        return redirect()->route('user.register.about');
    }

    public function getResendConfirmation()
    {
        $this->petRepository->setUser($this->authUser);
        \Mail::send('emails.user-verify', array('confirmation_code' => $this->authUser->confirmation_code), function ($message) {
            $message->to($this->authUser->email, 'New user')
                ->subject('Verify your email address');
        });
        return redirect()->route('user.dashboard')
            ->with('message', Lang::get('general.Verification email sent'));
    }

    public function getVerify($confirmation_code)
    {
        if (!$confirmation_code) {
            return redirect()->route('user')
                ->with('error', Lang::get('general.Confirmation not provided'));
        }
        $user = User::where('confirmation_code', '=', $confirmation_code)->first();
        if (!$user) {
            return redirect()->route('user')
                ->with('error', Lang::get('general.Confirmation code is invalid'));
        }
        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();
        if (Auth::user()->check()) {
            return redirect()->route('user.dashboard')
                ->with('success', Lang::get('general.You have successfully verified your account.'));
        }
        return redirect()->route('user');
    }

    public function postLogin()
    {

        $input = Input::all();
        $validator = $this->userRepository->getLoginValidator($input);
        if ($validator->fails()) {
            return redirect()->route('user')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {

            $userData = array(
                'email' => $input['email'],
                'password' => $input['password']
            );

            if (Auth::user()->attempt($userData)) {

                return redirect()->route('user.dashboard')
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

    public function getDelete()
    {
        $user = $this->authUser;
        $this->userRepository->delete($user->id);
        return redirect()->route('user')
            ->with('success', Lang::get('general.Your account was successfully deleted'));
    }

    public function getLogout()
    {
        Auth::user()->logout();
        return redirect()->route('user')
            ->with('success', Lang::get('general.You are now logged out!'));
    }

}
