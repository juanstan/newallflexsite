<?php  namespace App\Http\Controllers\Vet;

class PetReadingRegisterController extends \App\Http\Controllers\Controller {
    
    public function getIndex()
    { 
        return \View::make('vetsignup.stage3');
    }


}
