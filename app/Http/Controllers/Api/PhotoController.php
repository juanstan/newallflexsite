<?php namespace App\Http\Controllers\Api;

use Auth;
use Input;
use URL;
use Request;

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

    public function store()
    {
        $validator = $this->photoRepository->getCreateValidator(Input::all());

        if($validator->fails())
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $request = Request::all();

        dd($request);

        $photo = \DB::transaction(function() use($request)
        {
            $input = array_filter(Request::only(['title']) + [
                    'location' => $this->photoRepository->uploadImage($request->file('image_path'), $this->user)
                ]);

            $photo = $this->photoRepository->createForUser($input, $this->user);

            return $photo;
        });

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