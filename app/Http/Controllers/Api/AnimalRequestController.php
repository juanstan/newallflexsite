<?php namespace App\Http\Controllers\Api;

use App\Models\Entities\User;
use App\Models\Entities\Animal;
use App\Models\Repositories\AnimalRepositoryInterface;
use App\Models\Repositories\AnimalRequestRepositoryInterface;

class AnimalRequestController extends \App\Http\Controllers\Controller
{

    protected $authUser;
    protected $animalRepository;
    protected $animalRequestRepository;

    public function __construct(AnimalRequestRepositoryInterface $animalRequestRepository, AnimalRepositoryInterface $animalRepository)
    {
        $this->authUser = \Auth::user()->get();
        $this->animalRepository = $animalRepository;
        $this->animalRequestRepository = $animalRequestRepository;
    }

    public function index()
    {
        $this->animalRequestRepository->setUser($this->authUser);

        return \Response::json(['error' => false,
            'result' => $this->animalRequestRepository->all()]);
    }

    public function store() // POST
    {
        $this->animalRequestRepository->setUser($this->authUser);

        $input = \Input::all();
        $validator = $this->animalRequestRepository->getCreateValidator($input);

        if ($validator->fails()) {
            return \Response::json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        $animalRequest = $this->animalRequestRepository->create($input);

        if ($animalRequest == null) {
            \App::abort(500);
        }

        return \Response::json(['error' => false, 'result' => $animalRequest], 201)
            ->header('Location', \URL::route('api.animal.show', [$animalRequest->id]));
    }

    public function update($id) // PUT
    {
        $this->animalRequestRepository->setUser($this->authUser);

        $input = \Input::all();
        $validator = $this->animalRequestRepository->getUpdateValidator($input);

        if ($validator->fails()) {
            return \Response::json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        if ($this->animalRequestRepository->update($id, $input) == false) {
            \App::abort(500);
        }

        return \Response::json(['error' => false,
            'result' => $this->animalRequestRepository->get($id)]);
    }

    public function show($id) // GET
    {
        $this->animalRequestRepository->setUser($this->authUser);

        return \Response::json(['error' => false,
            'result' => $this->animalRequestRepository->get($id)]);
    }

    public function destroy($id) // DELETE
    {
        $this->animalRequestRepository->setUser($this->authUser);

        $this->animalRequestRepository->delete($id);
        return \Response::json(['error' => false, 'result' => 'Request #' . $id . ' deleted']);
    }



}
