<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Models\RealState;
use App\Repository\RealStateRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RealStateSearchController extends Controller
{   
    private $realState;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }
     
    /**
     * Method index
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {   
        $repository = new RealStateRepository($this->realState);

        $repository->setLocation($request->all(['state', 'city']));

        if($request->has('conditions')) {
		    $repository->selectConditions($request->get('conditions'));
	    }

	    if($request->has('fields')) {
		    $repository->selectFilter($request->get('fields'));
	    }

        return response()->json([
            'data' => $repository->getResult()->paginate(10)
        ], 200);
    }
    
    /**
     * Method show
     *
     * @param $id $id [explicite description]
     *
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            
            $realState = $this->realState->with('address')->with('photos')->findOrFail($id);

            return response()->json([
                'data' => $realState
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}    