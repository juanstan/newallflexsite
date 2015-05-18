<?php  namespace Vet;

class AnimalReadingRegisterController extends \BaseController {
    
    public function getIndex()
    { 
        return \View::make('vetsignup.stage3');
    }


}
