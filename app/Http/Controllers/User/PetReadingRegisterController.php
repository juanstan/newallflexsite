<?php namespace App\Http\Controllers\User;

use View;
use Input;
use File;
use Lang;
use Auth;

use App\Models\Entities\Pet;
use App\Models\Entities\SensorReading;
use App\Models\Repositories\PetReadingRepositoryInterface;
use App\Models\Repositories\PetRepositoryInterface;
use App\Http\Controllers\Controller;

class PetReadingRegisterController extends Controller
{

    protected $authUser;
    protected $petReadingRepository;
    protected $petRepository;

    public function __construct(PetReadingRepositoryInterface $petReadingRepository, PetRepositoryInterface $petRepository)
    {
        $this->authUser = Auth::user()->get();
        $this->petReadingRepository = $petReadingRepository;
        $this->petRepository = $petRepository;
        $this->middleware('auth.user', array('only' => array('getIndex', 'postAssign', 'postFinish', 'getAssign', 'postAssign')));
    }

    public function getIndex()
    {
        return View::make('usersignup.petReadingUpload');
    }

    public function postReadingUpload()
    {
        $input = Input::all();
        $user = $this->authUser;

        $readingValidator = $this->petReadingRepository->getReadingUploadValidator($input);
        if ($readingValidator->fails()) {
            return redirect()->back()
                ->withErrors($readingValidator)
                ->withInput();
        }

        if($this->petReadingRepository->readingUpload($input, $user))
        {
            return redirect()->route('user.register.reading.assign');
        }

        return redirect()->route('register.reading')
            ->with('error', \Lang::get('general.Uploaded file is not valid'));

    }

    public function getAssign()
    {
        if (\Agent::isMobile()) {
            return redirect()->route('user.dashboard');
        }
        $this->petRepository->setUser($this->authUser);
        $pets = $this->petRepository->all();
        return View::make('usersignup.petAssign')
            ->with(
                array('pets' => $pets
                ));
    }

    public function postAssign($id)
    {
        $input = Input::get('pet_id');
        $query = Pet::where('id', '=', $id)->first();
        if (Pet::where('id', $input)->update(array('microchip_number' => $query->microchip_number))) {
            Pet::where('id', '=', $id)->delete();
            SensorReading::where('pet_id', '=', $id)->update(array('pet_id' => $input));
        }
        return redirect()->route('user.register.reading.assign')
            ->with('success', Lang::get('general.Pet microchip number assigned'));


    }

    public function getFinish()
    {
//        $confirmation_code = $this->authUser->confirmation_code;
//        \Mail::send('emails.user-verify', array('confirmation_code' => $confirmation_code), function ($message) {
//            $message->to($this->authUser->email, 'New user')
//                ->subject('Verify your email address');
//        });
        return redirect()->route('user.dashboard');
    }

}
