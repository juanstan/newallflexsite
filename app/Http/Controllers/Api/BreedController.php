<?php namespace App\Http\Controllers\Api;

use App\Models\Repositories\BreedRepository;
use App\Http\Controllers\Controller;

class BreedController extends Controller
{

    protected $breedRepository;

    public function __construct(BreedRepository $breedRepository)
    {
        $this->breedRepository = $breedRepository;
    }

    public function index()
    {
        $breed = $this->breedRepository->all();

        return response()->json(array(
            'error' => false,
            'result' => $breed->toArray()),
            200
        );

    }


}
