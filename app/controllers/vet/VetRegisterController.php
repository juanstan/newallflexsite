<?php namespace Vet;

use Entities\Vet;
use Repositories\VetRepositoryInterface;
use Repositories\UserRepositoryInterface;

class VetRegisterController extends \BaseController {
    
    protected $authVet;
	protected $vetRepository;

	public function __construct(VetRepositoryInterface $vetRepository)
	{
		$this->authVet = \Auth::vet()->get();
        $this->vetRepository = $vetRepository;
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('vetAuth', array('only'=>array('getIndex', 'getAdd', 'postNew')));
	}

    public function getIndex()
    { 
        return \View::make('usersignup.stage4');
    }
    
    public function getAdd()
    { 
        $vets = $this->vetRepository->all();
        return \View::make('usersignup.stage5')->with('vets', $vets);
    }
    
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() // POST
	{
		$input = \Input::all();
		$validator = $this->vetRepository->getCreateValidator($input);

		if($validator->fails())
		{
			return \Response::json(['error' => true,
				'errors' => $validator->messages()], 400);
		}

		$user = $this->vetRepository->create($input);

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
			'result' => $this->vetRepository->getVetDetails($id)]);
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
		$validator = $this->vetRepository->getUpdateValidator($input);

		if($validator->fails())
		{
			return \Response::json(['error' => true,
				'errors' => $validator->messages()], 400);
		}

		if($this->vetRepository->update($id, $input) == false)
		{
			\App::abort(500);
		}

		return \Response::json(['error' => false,
			'result' => $this->vetRepository->get($id)]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) // DELETE
	{
		$this->vetRepository->delete($id);

		return \Response::json(['error' => false]);
	}

}
