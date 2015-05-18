<?php namespace Api;

use Entities\Animal\Request;
use Repositories\AnimalRequestRepositoryInterface;
use Repositories\AnimaRequestlRepositoryInterface;

class AnimalRequestController extends \BaseController
{

    protected $authUser;
    protected $animalRepository;
    protected $animalRequestRepository;

    public function __construct(AnimalRequestRepositoryInterface $animalRequestRepository, AnimalRepositoryInterface $animalRepository)
    {
        $this->authUser = \Auth::user()->get();
        $this->animalRequestRepository = $animalRequestRepository;
    }

    public function index($vet_id)
    {

        $this->animalRepository->setUser($this->authUser);

        $animal = $this->animalRepository->get($animal_id);

        $this->animalRequestRepository->setAnimal($animal);

        return \Response::json(['error' => false,
            'result' => $this->animalRequestRepository->all()]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() // POST
    {

        $this->animalRequestRepository->setUser($this->authUser);

        $input = \Input::all();
        $validator = $this->animalRequestRepository->getCreateValidator($input);

        if ($validator->fails()) {
            return \Response::json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        $animal = $this->animalRequestRepository->create($input);

        if ($animal == null) {
            \App::abort(500);
        }

        return \Response::json(['error' => false, 'result' => $animal], 201)
            ->header('Location', \URL::route('api.animal.request.show', [$animal->id]));
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) // GET
    {


        $this->animalRequestRepository->setUser($this->authUser);

        return \Response::json(['error' => false,
            'result' => $this->animalRequestRepository->get($id)]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) // DELETE
    {
        $this->animalRequestRepository->setUser($this->authUser);

        $this->animalRequestRepository->delete($id);
        return \Response::json(['error' => false]);
    }

    public function approveRequest($id)
    {

        $this->animalRequestRepository->setUser($this->authUser);

        $this->animalRequestRepository->get($id);

        $input = \Input::all();
        $validator = $this->animalRequestRepository->getApprovalValidator($input);

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


}
