<?php namespace App\Http\Controllers\Api;

use Auth;
use Input;
use URL;

use App\Models\Repositories\PhotoRepository;
use App\Http\Controllers\Controller;

class PhotoController extends Controller
{

    protected $authUser;
    protected $photoRepository;

    public function __construct(PhotoRepository $photoRepository)
    {
        $this->authUser = Auth::user()->get();
        $this->photoRepository = $photoRepository;
    }

    public function store() // POST
    {
        $input = Input::all();
        $user = $this->authUser;
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

        $photo = $this->photoRepository->createForUser($photo, $user);

        if ($photo == null) {
            \App::abort(500);
        }

        return response()->json(['error' => false, 'result' => $photo], 201)
            ->header('Location', URL::route('api.photo.show', [$photo->id]));
    }

    public function show($id) // GET
    {

        $this->photoRepository->setUser($this->authUser);

        return response()->json(['error' => false,
            'result' => $this->photoRepository->get($id)]);
    }

}