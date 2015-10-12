<?php  namespace App\Http\Controllers\Vet;

use View;

use App\Http\Controllers\Controller;

class PetReadingRegisterController extends Controller {
    
    public function getIndex()
    { 
        return View::make('vetsignup.readingUpload');
    }


}
