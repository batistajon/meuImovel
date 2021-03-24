<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\RealStateRequest;
use App\Models\RealState;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RealStateController extends Controller
{       
    /**
     * realState
     *
     * @var mixed
     */
    private $realState;
    
    /**
     * Method __construct
     *
     * @param RealState $realState [explicite description]
     *
     * @return void
     */
    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }
        
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {   
        $realStates = Auth::guard('api')->user()->real_state();

        return response()->json($realStates->paginate(10), 200);
    }
            
    /**
     * Method store
     *
     * @param RealStateRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(RealStateRequest $request): JsonResponse
    {   
        $data = $request->all();
        $images = $request->file('images');

        try {
            
            $data['user_id'] = Auth::guard('api')->user()->id;

            $realState = $this->realState->create($data);

            if (isset($data['categories']) && count($data['categories'])) {
                $realState->categories()->sync($data['categories']);
            }

            if ($images) {

                $imagesUploaded = [];

                foreach ($images as $image) {

                    $path = $image->store('images', 'public');

                    $imagesUploaded[] = [
                        'photo' => $path,
                        'is_thumb' => false, 
                    ];
                }

                $realState->photos()->createMany($imagesUploaded);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel cadastrado com sucesso!'
                ]
            ], 200);

        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
    
    /**
     * Method show
     *
     * @param int $id [explicite description]
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {

            $realState = Auth::guard('api')->user()->real_state()->with('photos')->findOrFail($id);

            return response()->json(['data' => $realState], 200);

        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
    
    /**
     * Method update
     *
     * @param int $id [explicite description]
     * @param RealStateRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function update(int $id, RealStateRequest $request): JsonResponse
    {
        $data = $request->all();
        $images = $request->file('images');

        try {

            $realState = Auth::guard('api')->user()->real_state()->findOrFail($id);
            $realState->update($data);

            if (isset($data['categories']) && count($data['categories'])) {
                $realState->categories()->sync($data['categories']);
            }

            if ($images) {

                $imagesUploaded = [];

                foreach ($images as $image) {

                    $path = $image->store('images', 'public');

                    $imagesUploaded[] = [
                        'photo' => $path,
                        'is_thumb' => false, 
                    ];
                }

                $realState->photos()->createMany($imagesUploaded);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel atualizado com sucesso!'
                ]
            ], 200);

        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
    
    /**
     * Method destroy
     *
     * @param int $id [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {

            $realState = Auth::guard('api')->user()->real_state()->findOrFail($id);
            $realState->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel removido com sucesso!'
                ]
            ], 200);

        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}