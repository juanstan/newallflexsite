<?php namespace App\Http\Controllers\Api;

use Auth;
use Input;
use URL;

use App\Models\Repositories\DeviceRepository;
use App\Http\Controllers\Controller;

class DeviceController extends Controller
{

    protected $authUser;

    protected $deviceRepository;

    public function __construct(DeviceRepository $deviceRepository)
    {
        $this->authUser = Auth::user()->get();
        $this->deviceRepository = $deviceRepository;
    }

    public function index()
    {
        $this->deviceRepository->setUser($this->authUser);

        return response()->json(['error' => false,
            'result' => $this->deviceRepository->all()]);
    }

    public function store() // POST
    {
        $this->deviceRepository->setUser($this->authUser);

        $input = Input::all();
        $validator = $this->deviceRepository->getCreateValidator($input);

        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        $device = $this->deviceRepository->create($input);

        if ($device == null) {
            \App::abort(500);
        }

        return response()->json(['error' => false, 'result' => $device], 201)
            ->header('Location', URL::route('api.device.show', [$device->id]));
    }

    public function show($id) // GET
    {
        $this->deviceRepository->setUser($this->authUser);

        return response()->json(['error' => false,
            'result' => $this->deviceRepository->get($id)]);
    }

    public function update($id) // PUT
    {
        $this->deviceRepository->setUser($this->authUser);

        $input = Input::all();
        $validator = $this->deviceRepository->getUpdateValidator($input);

        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        if ($this->deviceRepository->update($id, $input) == false) {
            \App::abort(500);
        }

        return response()->json(['error' => false,
            'result' => $this->deviceRepository->get($id)]);
    }


    public function destroy($id) {

        $this->deviceRepository->setUser($this->authUser);
        $this->deviceRepository->destroy($id);

        return response()->json(['error' => false,
            'message' => 'The device has been removed']);

    }

}
