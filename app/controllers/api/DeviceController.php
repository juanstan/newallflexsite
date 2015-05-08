<?php namespace Api;

use Entities\Device;
use Repositories\DeviceRepositoryInterface;
use Repositories\UserRepositoryInterface;

class DeviceController extends \BaseController
{

    protected $authUser;

    protected $repository;

    public function __construct(DeviceRepositoryInterface $repository)
    {
        $this->authUser = \Auth::user()->get();
        $this->repository = $repository;
    }

    public function index()
    {
        $this->repository->setUser($this->authUser);

        return \Response::json(['error' => false,
            'result' => $this->repository->all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() // POST
    {
        $this->repository->setUser($this->authUser);

        $input = \Input::all();
        $validator = $this->repository->getCreateValidator($input);

        if ($validator->fails()) {
            return \Response::json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        $animal = $this->repository->create($input);

        if ($animal == null) {
            \App::abort(500);
        }

        return \Response::json(['error' => false, 'result' => $animal], 201)
            ->header('Location', \URL::route('api.device.show', [$animal->id]));
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) // GET
    {
        $this->repository->setUser($this->authUser);

        return \Response::json(['error' => false,
            'result' => $this->repository->get($id)]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id) // PUT
    {
        $this->repository->setUser($this->authUser);

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
