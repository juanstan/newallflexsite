<?php namespace Vet;

use Entities\Vet;
use Repositories\VetRepositoryInterface;
use Repositories\UserRepositoryInterface;

class VetRegisterController extends \BaseController {
    
    protected $authUser;
    
	protected $repository;

	public function __construct(VetRepositoryInterface $repository)
	{
		$this->authUser = \Auth::user();
        $this->repository = $repository;
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('vetAuth', array('only'=>array('getIndex', 'getAdd', 'postNew')));
	}

    public function getIndex()
    { 
        return \View::make('petsignup.stage4');
    }
    
    public function getAdd()
    { 
        $vets = $this->repository->all();
        return \View::make('petsignup.stage5')->with('vets', $vets);
    }
    
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() // POST
	{
		$input = \Input::all();
		$validator = $this->repository->getCreateValidator($input);

		if($validator->fails())
		{
			return \Response::json(['error' => true,
				'errors' => $validator->messages()], 400);
		}

		$user = $this->repository->create($input);

		if($user == null)
		{
			\App::abort(500);
		}

		return \Response::json(['error' => false, 'result' => $user], 201)
			->header('Location', \URL::route('api.user.show', [$user->id]));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) // GET
	{
		return \Response::json(['error' => false,
			'result' => $this->repository->getVetDetails($id)]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) // PUT
	{
		$input = \Input::all();
		$validator = $this->repository->getUpdateValidator($input);

		if($validator->fails())
		{
			return \Response::json(['error' => true,
				'errors' => $validator->messages()], 400);
		}

		if($this->repository->update($id, $input) == false)
		{
			\App::abort(500);
		}

		return \Response::json(['error' => false,
			'result' => $this->repository->get($id)]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) // DELETE
	{
		$this->repository->delete($id);

		return \Response::json(['error' => false]);
	}

}
