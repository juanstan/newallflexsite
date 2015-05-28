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

    public function getLocation()
    {
       // \Iseed::generateSeed('vets');
//        $vets = Vet::all();
//        foreach($vets as $vet) {
//            if($vet->latitude == null && $vet->longitude == null) {
//                if($vet->city == '') {
//                    $vet->delete();
//                }
//                else {
//                    $location = $vet->company_name . ', ' . $vet->city . ', UK';
//                    $a = geocode($location);
//
//                    $vet->latitude = $a[0];
//                    $vet->longitude = $a[1];
//
//                    $vet->save();
//                }
//
//            }
//        }
//        foreach($vets as $vet) {
//            $vet->address_1 = '100 Dummy Street';
//            $vet->address_2 = 'Fake lane';
//            $vet->contact_name = 'Vet McVetison';
//            $vet->county = 'Vetishire';
//            $vet->zip = 'CB500TV';
//            $vet->email_address = 'mcvetison@iownallthevets.com';
//            $vet->fax = '012345678910';
//            $vet->save();
//        }

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
                    $vet['distance'] = $distance->in('km')->haversine();
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

        if(empty($result)){
            return \Response::json(['error' => true, 'message' => 'There are no vets matching this search']);
        }

        return \Response::json(array(
            'error' => false,
            'result' => $result),
            200
        );

    }


}
