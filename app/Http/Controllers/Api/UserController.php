<?php namespace App\Http\Controllers\Api;

use Auth;
use Input;
use Lang;
use URL;
use Request;

use App\Models\Entities\Pet;
use App\Models\Entities\User;
use App\Models\Repositories\UserRepository;
use App\Models\Repositories\PhotoRepository;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    protected $authUser;

    protected $userRepository;
    protected $photoRepository;

    public function __construct(UserRepository $userRepository, PhotoRepository $photoRepository)
    {
        $this->userRepository = $userRepository;
        $this->photoRepository = $photoRepository;
        $this->authUser = Auth::user()->get();
    }

    public function store() // POST
    {
        $input = Input::all();
        $validator = $this->userRepository->getCreateValidator($input);

        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        $user = $this->userRepository->create($input);

        if ($user == null) {
            \App::abort(500);
        }

        return response()->json(['error' => false, 'result' => $user], 201)
            ->header('Location', URL::route('api.user.show', [$user->id]));
    }

    public function show($id) // GET
    {
        if ($this->authUser->id != $id) {
            return response()->json(['error' => true, 'message' => Lang::get('error.http.403')], 403);
        }

        return response()->json(['error' => false,
            'result' => $this->userRepository->getUserDetails($id)]);
    }

    public function update($id) // PUT
    {
        $user = $this->authUser;
        if ($user->id != $id) return response()->json(['error' => true, 'message' => Lang::get('error.http.403')], 403);
        $input = Input::all();
        $validator = $this->userRepository->getUpdateValidator($input, $id);

        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        if ($this->userRepository->update($id, $input) == false) {
            \App::abort(500);
        }

        return response()->json(['error' => false,
            'result' => $this->userRepository->get($id)]);
    }

    public function postPhoto()
    {
        $validator = $this->photoRepository->getCreateValidator(Input::all());

        if($validator->fails())
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = $this->authUser;
        $request = Request::all();

        $photo = array(
            'title' => $user->id,
            'location' => $this->photoRepository->uploadImage($request['image_path'], $user)
        );

        $photo = $this->photoRepository->createForUser($photo, $user);

        unset($request['image_path']);
        $request['photo_id'] = $photo->id;

        if ($this->userRepository->update($user->id, $request) == false) {
        \App::abort(500);
        }

        return response()->json(['error' => false,
            'result' => $this->userRepository->get($user->id)]);
    }

    public function destroy() // DELETE
    {
        $user = $this->authUser;
        $this->userRepository->delete($user->id);
        return response()->json(['error' => false, 'result' => 'general.Your account was successfully deleted']);
    }

}
