<?php  namespace Api;

use Entities\Reading;
use Repositories\AnimalReadingSymptomRepositoryInterface;
use Repositories\AnimalRepositoryInterface;
use Repositories\AnimalReadingRepositoryInterface;

class AnimalReadingSymptomController extends \BaseController {
    
    protected $authUser;
    
    protected $rrepository;
    
    protected $arepository;
    
    protected $repository;

    public function __construct(AnimalReadingRepositoryInterface $rrepository, AnimalRepositoryInterface $arepository, AnimalReadingSymptomRepositoryInterface $repository)
    {
        $this->authUser = \Auth::getUser();
        $this->repository = $repository;
        $this->arepository = $arepository;
        $this->rrepository = $rrepository;
    }
    
    public function index($animal_id, $reading_id)
    {   
        
        $this->arepository->setUser($this->authUser);
        $animal = $this->arepository->get($animal_id);
        $this->rrepository->setAnimal($animal);
        $reading = $this->rrepository->get($reading_id);
        $this->repository->setReading($reading);
        
        return \Response::json(['error' => false,
            'result' => $this->repository->all()]);
        
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($animal_id, $reading_id) // POST
    {

        $this->arepository->setUser($this->authUser);
        
        $animal = $this->arepository->get($animal_id);
           
        $this->rrepository->setAnimal($animal);
        
        $reading = $this->rrepository->get($reading_id);
        
        $this->repository->setReading($reading);
        
        $input = \Input::all();
        $input['reading_id'] = $reading_id;
        $validator = $this->repository->getCreateValidator($input);
        
        

        if($validator->fails())
        {
            return \Response::json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        $reading = $this->repository->create($input);

        if($reading == null)
        {
            \App::abort(500);
        }

        return \Response::json(['error' => false, 'result' => $reading], 201)
            ->header('Location', \URL::route('api.animal.{animal_id}.reading.{reading_id}.symptom.show', [$reading->id]));
            
    }


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($animal_id, $reading_id, $id) // GET
    {
        $this->arepository->setUser($this->authUser);
        
        $animal = $this->arepository->get($animal_id);
           
        $this->rrepository->setAnimal($animal);
        
        $reading = $this->rrepository->get($reading_id);
        
        $this->repository->setReading($reading);

        return \Response::json(['error' => false,
            'result' => $this->repository->get($id)]);
    }


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($animal_id, $reading_id, $id) // PUT
    {
        
        $this->arepository->setUser($this->authUser);
        
        $animal = $this->arepository->get($animal_id);
           
        $this->rrepository->setAnimal($animal);
        
        $reading = $this->rrepository->get($reading_id);
        
        $this->repository->setReading($reading);
        
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
	public function destroy($animal_id, $reading_id, $id) // DELETE
    {
        
        $this->arepository->setUser($this->authUser);
        
        $animal = $this->arepository->get($animal_id);
           
        $this->rrepository->setAnimal($animal);
        
        $reading = $this->rrepository->get($reading_id);
        
        $this->repository->setReading($reading);

        $this->repository->delete($id);
        return \Response::json(['error' => false]);
    }


}
