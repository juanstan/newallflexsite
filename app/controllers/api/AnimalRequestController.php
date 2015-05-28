<?php namespace Api;

use Entities\Animal\Request;
use Entities\User;
use Entities\Animal;
use Repositories\AnimalRepositoryInterface;
use Repositories\AnimalRequestRepositoryInterface;
use Repositories\UserRepositoryInterface;

class AnimalRequestController extends \BaseController
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
