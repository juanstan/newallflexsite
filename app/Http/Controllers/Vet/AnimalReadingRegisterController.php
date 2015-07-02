<?php  namespace App\Http\Controllers\Vet;

class AnimalReadingRegisterController extends \App\Http\Controllers\Controller {
    
    public function getIndex()
    { 
        return \View::make('vetsignup.stage3');
    }


}
