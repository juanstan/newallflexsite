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

    public function store(Request $request)
    {
        $validator = $this->photoRepository->getCreateValidator($request->all());

        if($validator->fails())
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $photo = \DB::transaction(function() use($request)
        {
            $input = array_filter($request->only(['title']) + [
                    'location' => $this->photoRepository->uploadImage($request->file('file'), $this->user)
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