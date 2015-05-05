<?php  namespace Pet;

use Entities\Animal;
use Repositories\AnimalRepositoryInterface;
use Repositories\UserRepositoryInterface;

class PetRegisterController extends \BaseController {
    
    protected $authUser;
    
    protected $repository;

    public function __construct(AnimalRepositoryInterface $repository)
    {
        $this->authUser = \Auth::user()->get();
        $this->repository = $repository;
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('auth', array('only'=>array('getIndex', 'getNew', 'postNew')));
    }
    
    public function getIndex()
    {
        $this->repository->setUser($this->authUser);
        $pets = $this->repository->all();
        return \View::make('petsignup.stage3')->with('pets', $pets);
      
    }
    
    public function getCreate()
    {
        return \View::make('petsignup.stage2');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate() // POST
    {   
        $this->repository->setUser($this->authUser);
        
        $input = \Input::all();
//        $validator = $this->repository->getCreateValidator($input);
//
//        if($validator->fails())
//        {
//            return \Redirect::to('pet/register/pet/create')
//                ->withErrors($validator);
//        }
        
        $id = \Auth::user()->get()->id;
        
        $file = array('image' => \Input::file('pet-photo'));
        $rules = array('image' => 'max:4000|mimes:jpeg,png');
        $validator = \Validator::make($file, $rules);
        if ($validator->fails()) {
            return \Redirect::to('/pet/register/pet/create')->withInput()
                ->withErrors($validator);
        }
        else {
            if (\Input::file('pet-photo')->isValid()) {
                $destinationPath = 'images/uploads/'.$id;
                if(!\File::exists($destinationPath)) {
                    \File::makeDirectory($destinationPath);
                }
                
                $extension = \Input::file('pet-photo')->getClientOriginalExtension();
                $fileName = rand(11111,99999).'.'.$extension;
                
                $height = \Image::make(\Input::file('pet-photo'))->height();
                $width = \Image::make(\Input::file('pet-photo'))->width();
                
                if($width > $height) {
                    \Image::make(\Input::file('pet-photo'))->crop($height, $height)->save($destinationPath.'/'.$fileName);
                } 
                else {
                    \Image::make(\Input::file('pet-photo'))->crop($width, $width)->save($destinationPath.'/'.$fileName);
                }
                                
                $input['image_path'] = '/images/uploads/'.$id.'/'.$fileName;
                $animal = $this->repository->create($input);
                return \Redirect::to('/pet/register/pet');
                
            }
            else {
              \Session::flash('error', 'uploaded file is not valid');
              return \Redirect::to('/pet/register/pet/create');
            }
        }

        if($animal == null)
        {
            \App::abort(500);
        }

        return \Redirect::to('pet/register/pet');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return Response
     */
    public function update($id) // PUT
    {
        $this->repository->setUser($this->authUser);

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
        $this->repository->setUser($this->authUser);

        $this->repository->delete($id);
        return \Response::json(['error' => false]);
    }
    
}
