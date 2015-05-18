<?php namespace Api;

use Entities\User;
use Entities\Animal;
use Repositories\AnimalRepositoryInterface;
use Repositories\UserRepositoryInterface;

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

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) // GET
    {
        $this->animalRepository->setUser($this->authUser);

        return \Response::json(['error' => false,
            'result' => $this->animalRepository->get($id)]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
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
            'result' => $this->animalRepository->get($id)]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) // DELETE
    {
        $this->animalRepository->setUser($this->authUser);

        $this->animalRepository->delete($id);
        return \Response::json(['error' => false]);
    }

}
