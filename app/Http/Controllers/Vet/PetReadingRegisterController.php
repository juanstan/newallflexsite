<?php  namespace App\Http\Controllers\Vet;

use View;

use App\Http\Controllers\Controller;

class PetReadingRegisterController extends Controller {
    
    public function getIndex()
    { 
        return View::make('vetsignup.readingUpload');
    }


    /*
     * Function to show simply the Reading instructions for a specific controller
     *
     * @param string $so Operative System
     *
     * return @view
     */

    public function getInstructions($so)
    {
        if (in_array($so, array('windows', 'mac'))) {
            return View::make("vetsignup.{$so}intructions");
        }

        return redirect()->route('vet.register.reading');

    }

}
