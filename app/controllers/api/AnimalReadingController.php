<?php namespace Api;

use Entities\Reading;
use Repositories\AnimalReadingRepositoryInterface;
use Repositories\AnimalRepositoryInterface;

class AnimalReadingController extends \BaseController
{

    protected $authUser;

    protected $repository;

    protected $arepository;

    public function __construct(AnimalReadingRepositoryInterface $repository, AnimalRepositoryInterface $arepository)
    {
        $this->authUser = \Auth::getUser();
        $this->repository = $repository;
        $this->arepository = $arepository;
    }

    public function index($animal_id)
    {

        $this->arepository->setUser($this->authUser);

        $animal = $this->arepository->get($animal_id);

        $this->repository->setAnimal($animal);

        return \Response::json(['error' => false,
            'result' => $this->repository->all()]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($animal_id) // POST
    {

        $this->arepository->setUser($this->authUser);

        $animal = $this->arepository->get($animal_id);

        $this->repository->setAnimal($animal);

        $input = \Input::all();
        $input['animal_id'] = $animal_id;
        $validator = $this->repository->getCreateValidator($input);


        if ($validator->fails()) {
            return \Response::json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        $reading = $this->repository->create($input);

        if ($reading == null) {
            \App::abort(500);
        }

        return \Response::json(['error' => false, 'result' => $reading], 201)
            ->header('Location', \URL::route('api.animal.{animal_id}.reading.show', [$reading->id]));

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($animal_id, $id) // GET
    {
        $this->arepository->setUser($this->authUser);

        $animal = $this->arepository->get($animal_id);

        $this->repository->setAnimal($animal);

        return \Response::json(['error' => false,
            'result' => $this->repository->get($id)]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($animal_id, $id) // PUT
    {

        $this->arepository->setUser($this->authUser);

        $animal = $this->arepository->get($animal_id);

        $this->repository->setAnimal($animal);

        $input = \Input::all();

        $validator = $this->repository->getUpdateValidator($input);

        if ($validator->fails()) {
            return \Response::json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        if ($this->repository->update($id, $input) == false) {
            \App::abort(500);
        }

        return \Response::json(['error' => false,
            'result' => $this->repository->get($id)]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */

}
