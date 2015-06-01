<?php namespace Api;

use Entities\User;
use Entities\Animal;
use Repositories\AnimalRepositoryInterface;

class AnimalController extends \BaseController
{

    protected $authUser;
    protected $animalRepository;

    public function __construct(AnimalRepositoryInterface $animalRepository)
    {
        $this->authUser = \Auth::user()->get();
        $this->animalRepository = $animalRepository;
    }

    public function index()
    {
        $this->animalRepository->setUser($this->authUser);

        return \Response::json(['error' => false,
            'result' => $this->animalRepository->all()]);
    }

    public function store() // POST
    {
        $this->animalRepository->setUser($this->authUser);

        $input = \Input::all();
        $validator = $this->animalRepository->getCreateValidator($input);

        if ($validator->fails()) {
            return \Response::json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        $animal = $this->animalRepository->create($input);

        if ($animal == null) {
            \App::abort(500);
        }

        return \Response::json(['error' => false, 'result' => $animal], 201)
            ->header('Location', \URL::route('api.animal.show', [$animal->id]));
    }

    public function show($id) // GET
    {
        $this->animalRepository->setUser($this->authUser);

        return \Response::json(['error' => false,
            'result' => $this->animalRepository->findOrFail($id)]);
    }

    public function update($id) // PUT
    {
        $this->animalRepository->setUser($this->authUser);

        $input = \Input::all();
        $validator = $this->animalRepository->getUpdateValidator($input);

        if ($validator->fails()) {
            return \Response::json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        if ($this->animalRepository->update($id, $input) == false) {
            \App::abort(500);
        }

        return \Response::json(['error' => false,
            'result' => $this->animalRepository->findOrFail($id)]);
    }

    public function destroy($id) // DELETE
    {
        $this->animalRepository->setUser($this->authUser);

        $this->animalRepository->delete($id);
        return \Response::json(['error' => false, 'result' => 'Item removed']);
    }

}
