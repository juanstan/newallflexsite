<?php namespace Api;

use Entities\Device;
use Repositories\DeviceRepositoryInterface;
use Repositories\UserRepositoryInterface;

class DeviceController extends \BaseController
{

    protected $authUser;

    protected $deviceRepository;

    public function __construct(DeviceRepositoryInterface $deviceRepository)
    {
        $this->authUser = \Auth::user()->get();
        $this->deviceRepository = $deviceRepository;
    }

    public function index()
    {
        $this->deviceRepository->setUser($this->authUser);

        return \Response::json(['error' => false,
            'result' => $this->deviceRepository->all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() // POST
    {
        $this->deviceRepository->setUser($this->authUser);

        $input = \Input::all();
        $validator = $this->deviceRepository->getCreateValidator($input);

        if ($validator->fails()) {
            return \Response::json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        $animal = $this->deviceRepository->create($input);

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
        $this->deviceRepository->setUser($this->authUser);

        return \Response::json(['error' => false,
            'result' => $this->deviceRepository->get($id)]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id) // PUT
    {
        $this->deviceRepository->setUser($this->authUser);

        $input = \Input::all();
        $validator = $this->deviceRepository->getUpdateValidator($input);

        if ($validator->fails()) {
            return \Response::json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        if ($this->deviceRepository->update($id, $input) == false) {
            \App::abort(500);
        }

        return \Response::json(['error' => false,
            'result' => $this->deviceRepository->get($id)]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */

}
