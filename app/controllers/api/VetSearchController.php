<?php namespace Api;

use League\Geotools\Coordinate\Ellipsoid;
use Toin0u\Geotools\Facade\Geotools;
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
        $distance_set = \Input::get('distance');
        $data_arr = geocode($location);

        $coordA   = Geotools::coordinate([$data_arr[0], $data_arr[1]]);
        $vets = Vet::all();
        foreach($vets as $vet)
        {
            if($vet->latitude != null && $vet->longitude != null)
            {
                $coordB   = Geotools::coordinate([$vet->latitude, $vet->longitude]);
                $distance = Geotools::distance()->setFrom($coordA)->setTo($coordB);
                if($distance->in('km')->haversine() < $distance_set) {
                    $result[] = $vet;
                }
                else {
                    continue;
                }
            }
            else {
                continue;
            }
        }

        if(empty($result)){
            return \Response::json(['error' => true, 'message' => 'There are no vets in this area']);
        }

        return \Response::json(array(
            'error' => false,
            'result' => $result),
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
                $result[] = $vet;
            }
        }

        return \Response::json(array(
            'error' => false,
            'result' => $result),
            200
        );

    }


}
