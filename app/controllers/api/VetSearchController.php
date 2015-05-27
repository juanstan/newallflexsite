<?php namespace Api;

use Entities\Vet;

class VetSearchController extends \BaseController
{

    public function getAll()
    {
        $vet = Vet::all();

        return \Response::json(array(
            'error' => false,
            'result' => $vet->toArray()),
            200
        );

    }

    public function postLocation()
    {
        $location = \Input::get('location');
        $data_arr = geocode($location);

        if($data_arr) {
            $latitude = $data_arr[0];
            $longitude = $data_arr[1];
            $location = array('latitude' => $latitude, 'longitude' => $longitude);
        }

        dd($location);



        $breed = Breed::all();

        return \Response::json(array(
            'error' => false,
            'result' => $breed->toArray()),
            200
        );

    }

    public function postName()
    {
        $vets = Vet::all();
        $term = \Input::get('term');
        $result = [];
        foreach($vets as $vet) {
            if(strpos($vet,$term) !== false) {
                $result[] = ['value' => $vet];
            }
        }
        return \Response::json($result);

    }


}
