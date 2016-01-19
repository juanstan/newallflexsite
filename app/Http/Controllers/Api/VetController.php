<?php namespace App\Http\Controllers\Api;

use Input;
use URL;

use App\Models\Entities\Vet;
use App\Models\Repositories\VetRepositoryInterface;
use App\Http\Controllers\Controller;

class VetController extends Controller
{

    protected $vetRepository;

    public function __construct(VetRepositoryInterface $vetRepository)
    {
        $this->vetRepository = $vetRepository;
    }

    public function index()
    {

        return response()->json(['error' => false,
            'result' => $this->vetRepository->all()]);
    }

    public function store() // POST
    {
        $input = Input::all();
        $validator = $this->vetRepository->getCreateValidator($input);

        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        $user = $this->vetRepository->create($input);

        if ($user == null) {
            \App::abort(500);
        }

        return response()->json(['error' => false, 'result' => $user], 201)
            ->header('Location', URL::route('api.user.show', [$user->id]));
    }

    public function show($id) // GET
    {
        return response()->json(['error' => false,
            'result' => $this->vetRepository->getVetDetails($id)]);
    }

    public function update($id) // PUT
    {
        $input = Input::all();
        $validator = $this->vetRepository->getUpdateValidator($input);

        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        if (Input::hasFile('image_path')){
            $destinationPath = 'uploads/vets/'.$id;
            if(!\File::exists($destinationPath)) {
                \File::makeDirectory($destinationPath);
            }

            $extension = Input::file('image_path')->getClientOriginalExtension();
            $fileName = rand(11111,99999).'.'.$extension;

            $height = \Image::make(Input::file('image_path'))->height();
            $width = \Image::make(Input::file('image_path'))->width();

            if($width > $height) {
                \Image::make(Input::file('image_path'))->crop($height, $height)->save($destinationPath.'/'.$fileName);
            }
            else {
                \Image::make(Input::file('image_path'))->crop($width, $width)->save($destinationPath.'/'.$fileName);
            }

            $image_path = '/uploads/vets/'.$id.'/'.$fileName;
            $input = array_merge($input, array('image_path' => $image_path));

        }

        if ($this->vetRepository->update($id, $input) == false) {
            \App::abort(500);
        }

        return response()->json(['error' => false,
            'result' => $this->vetRepository->get($id)]);
    }

    public function destroy($id) // DELETE
    {
        $this->vetRepository->delete($id);

        return response()->json(['error' => false, 'result' => 'Item removed']);
    }

}
