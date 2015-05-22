<?php namespace Api;

use Entities\UserRequest;
use Repositories\VetRequestRepositoryInterface;
use Repositories\VetRepositoryInterface;

class VetRequestController extends \BaseController
{

    protected $authUser;
    protected $repository;

    public function __construct(VetRequestRepositoryInterface $vetRequestRepository)
    {
        $this->authUser = \Auth::user()->get();
        $this->vetRequestRepository = $vetRequestRepository;
    }

    public function index()
    {
        $this->vetRequestRepository->setUser($this->authUser);

        return \Response::json(['error' => false,
            'result' => $this->vetRequestRepository->all()]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() // POST
    {

        $this->vetRequestRepository->setUser($this->authUser);

        $input = \Input::all();
        $validator = $this->vetRequestRepository->getCreateValidator($input);

        if ($validator->fails()) {
            return \Response::json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        $animal = $this->vetRequestRepository->create($input);

        if ($animal == null) {
            \App::abort(500);
        }

        return \Response::json(['error' => false, 'result' => $animal], 201)
            ->header('Location', \URL::route('api.user.request.show', [$animal->id]));
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) // GET
    {


        $this->vetRequestRepository->setUser($this->authUser);

        return \Response::json(['error' => false,
            'result' => $this->vetRequestRepository->get($id)]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id) // PUT
    {
        $this->vetRequestRepository->setUser($this->authUser);

        $input = \Input::all();
        $validator = $this->vetRequestRepository->getUpdateValidator($input);

        if ($validator->fails()) {
            return \Response::json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        if ($this->vetRequestRepository->update($id, $input) == false) {
            \App::abort(500);
        }

        return \Response::json(['error' => false,
            'result' => $this->vetRequestRepository->get($id)]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) // DELETE
    {
        $this->vetRequestRepository->setUser($this->authUser);

        $this->vetRequestRepository->delete($id);
        return \Response::json(['error' => false]);
    }


}
