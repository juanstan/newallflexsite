<?php namespace App\Http\Controllers\Api;

use Input;

use Toin0u\Geotools\Facade\Geotools;
use App\Models\Entities\Vet;
use App\Http\Controllers\Controller;

use App\Models\Repositories\VetRepository;

class VetSearchController extends Controller
{

    protected $vetRepository;

    public function __construct(VetRepository $vetRepository)
    {
        $this->vetRepository = $vetRepository;
    }

    public function getAll()
    {
        $vet = $this->vetRepository->all();

        return response()->json(array(
            'error' => false,
            'result' => $vet->toArray()),
            200
        );

    }

    public function postLocation()
    {
        $location = Input::get('location');
        $distance_set = Input::get('distance');
        $data_arr = geocode($location);

        $coordA   = Geotools::coordinate([$data_arr[0], $data_arr[1]]);
        $vets = $this->vetRepository->all();
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
            return response()->json(['error' => true, 'message' => 'There are no vets in this area']);
        }

        return response()->json(array(
            'error' => false,
            'result' => $result),
            200
        );

    }

    public function postName()
    {
        $vets = $this->vetRepository->all();
        $term = Input::get('term');
        $result = [];
        foreach($vets as $vet) {
            if(strpos($vet,$term) !== false) {
                $result[] = $vet;
            }
        }

        if(empty($result)){
            return response()->json(['error' => true, 'message' => 'There are no vets matching this search']);
        }

        return response()->json(array(
            'error' => false,
            'result' => $result),
            200
        );

    }


}
