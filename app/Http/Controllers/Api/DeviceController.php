<?php namespace App\Http\Controllers\Api;

use App\Models\Repositories\DeviceRepositoryInterface;

class DeviceController extends \App\Http\Controllers\Controller
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

    public function show($id) // GET
    {
        $this->deviceRepository->setUser($this->authUser);

        return \Response::json(['error' => false,
            'result' => $this->deviceRepository->get($id)]);
    }

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

}
