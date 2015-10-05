<?php namespace App\Http\Controllers\Api;

use Auth;
use Input;
use Lang;
use URL;

use App\Models\Entities\Animal;
use App\Models\Entities\User;
use App\Models\Repositories\UserRepositoryInterface;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    protected $authUser;

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
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

        if ($this->authUser->id != $id) return response()->json(['error' => true, 'message' => Lang::get('error.http.403')], 403);
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

        if (Input::hasFile('image_path')) {

            $imageValidator = $this->photoRepository->getCreateValidator($input);

            if ($imageValidator->fails()) {
                return redirect()->back()
                    ->withErrors($imageValidator)
                    ->withInput();
            }

            $photo = array(
                'title' => $user->id,
                'location' => $this->photoRepository->uploadImage($input['image_path'], $user)
            );

            $photoId = $this->photoRepository->createForUser($photo, $user);

            unset($input['image_path']);
            $input['photo_id'] = $photoId->id;

        }

        if ($this->userRepository->update($id, $input) == false) {
            \App::abort(500);
        }

        return response()->json(['error' => false,
            'result' => $this->userRepository->get($id)]);
    }

    public function destroy() // DELETE
    {
        $user = $this->authUser;
        $this->userRepository->delete($user->id);
        return response()->json(['error' => false, 'result' => 'general.Your account was successfully deleted']);
    }

}
