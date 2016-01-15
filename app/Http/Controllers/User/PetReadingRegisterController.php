<?php namespace App\Http\Controllers\User;

use View;
use Input;
use File;
use Lang;
use Auth;

use App\Models\Entities\Pet;
use App\Models\Entities\Reading;
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




        try {
            if ($this->petReadingRepository->readingUpload($input, $user)) {
                return response()->json([
                    'status'=>'success',
                    'message' => ''
                ]);
            }

            return response()->json([
                'status'=>'error',
                'message', \Lang::get('general.Uploaded file is not valid')
            ]);

        }catch (\Exception $e) {
            if ($e->getCode()===111) {
                return response()->json([
                    'status'=>'error',
                    'message' => \Lang::get('general.Microchip has been already registered')
                ]);
            }

            return response()->json([
                'status'=>'error',
                'message' => $e->getMessage()
            ]);

        }


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
        $pet = $this->petRepository->get(Input::get('pet_id'));
        $microchip = $this->petRepository->get($id);

        if ($pet->update(array('microchip_number' => $microchip->microchip_number))) {
            foreach($microchip->readings()->get as $reading) {
                $pet->readings()->attach($reading);
            }
            $microchip->delete();
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

    /*
     * Function to show simply the Reading instructions for a specific controller
     *
     * @param string $so Operative System
     *
     * return @view
     */

    public function getInstructions($so)
    {
        if (in_array($so, array('windows', 'mac'))) {
            return View::make("usersignup.{$so}intructions");
        }

        return redirect()->route('user.register.reading');

    }

}
