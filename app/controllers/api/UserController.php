<?php namespace Api;

use Entities\User;
use Repositories\UserRepositoryInterface;

class UserController extends \BaseController
{

    protected $authUser;

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->authUser = \Auth::user()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() // POST
    {
        $input = \Input::all();
        $validator = $this->userRepository->getCreateValidator($input);

        if ($validator->fails()) {
            return \Response::json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        $user = $this->userRepository->create($input);

        if ($user == null) {
            \App::abort(500);
        }

        return \Response::json(['error' => false, 'result' => $user], 201)
            ->header('Location', \URL::route('api.user.show', [$user->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id) // GET
    {

        if ($this->authUser->id != $id) return \Response::json(['error' => true, 'message' => \Lang::get('error.http.403')], 403);
        return \Response::json(['error' => false,
            'result' => $this->userRepository->getUserDetails($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id) // PUT
    {

        if ($this->authUser->id != $id) return \Response::json(['error' => true, 'message' => \Lang::get('error.http.403')], 403);
        $input = \Input::all();
        $validator = $this->userRepository->getUpdateValidator($input);

        if ($validator->fails()) {
            return \Response::json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        if ($this->userRepository->update($id, $input) == false) {
            \App::abort(500);
        }

        return \Response::json(['error' => false,
            'result' => $this->userRepository->get($id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id) // DELETE
    {

        if ($this->authUser->id != $id) return \Response::json(['error' => true, 'message' => \Lang::get('error.http.403')], 403);

        $this->userRepository->delete($id);

        return \Response::json(['error' => false]);
    }

}
