<?php namespace App\Http\Controllers\User;

use View;
use Input;
use File;
use Lang;
use Auth;

use App\Models\Entities\Animal;
use App\Models\Entities\SensorReading;
use App\Models\Repositories\AnimalReadingRepositoryInterface;
use App\Models\Repositories\AnimalRepositoryInterface;
use App\Http\Controllers\Controller;

class AnimalReadingRegisterController extends Controller
{

    protected $authUser;
    protected $animalReadingRepository;
    protected $animalRepository;

    public function __construct(AnimalReadingRepositoryInterface $animalReadingRepository, AnimalRepositoryInterface $animalRepository)
    {
        $this->authUser = Auth::user()->get();
        $this->animalReadingRepository = $animalReadingRepository;
        $this->animalRepository = $animalRepository;
        $this->middleware('auth.user', array('only' => array('getIndex', 'postAssign', 'postFinish', 'getAssign', 'postAssign')));
    }

    public function getIndex()
    {
        return View::make('usersignup.animalReadingUpload');
    }

    public function postReadingUpload()
    {
        $input = Input::all();
        $user = $this->authUser;

        $readingValidator = $this->animalReadingRepository->getReadingUploadValidator($input);
        if ($readingValidator->fails()) {
            return redirect()->back()
                ->withErrors($readingValidator)
                ->withInput();
        }

        if($this->animalReadingRepository->readingUpload($input, $user))
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
        $this->animalRepository->setUser($this->authUser);
        $pets = $this->animalRepository->all();
        return View::make('usersignup.petAssign')
            ->with(
                array('pets' => $pets
                ));
    }

    public function postAssign($id)
    {
        $input = Input::get('pet_id');
        $query = Animal::where('id', '=', $id)->first();
        if (Animal::where('id', $input)->update(array('microchip_number' => $query->microchip_number))) {
            Animal::where('id', '=', $id)->delete();
            SensorReading::where('animal_id', '=', $id)->update(array('animal_id' => $input));
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
