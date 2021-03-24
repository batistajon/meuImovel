<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{    
    /**
     * category
     *
     * @var mixed
     */
    private $category;
    
    /**
     * Method __construct
     *
     * @param Category $category [explicite description]
     *
     * @return void
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $category = $this->category->paginate(10);

        return response()->json($category, 200);
    }
    
    /**
     * Method store
     *
     * @param CategoryRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $data = $request->all();

        try {

            $category = $this->category->create($data);

            return response()->json([
                'data' => [
                    'msg' => 'Categoria cadastrada com sucesso!'
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

            $category = $this->category->findOrFail($id);

            return response()->json(['data' => $category], 200);

        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
    
    /**
     * Method update
     *
     * @param CategoryRequest $request [explicite description]
     * @param int $id [explicite description]
     *
     * @return JsonResponse
     */
    public function update(CategoryRequest $request, int $id): JsonResponse
    {
        $data = $request->all();

        try {

            $category = $this->category->findOrFail($id);
            $category->update($data);

            return response()->json([
                'data' => [
                    'msg' => 'Categoria atualizada com sucesso!'
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

            $category = $this->category->findOrFail($id);
            $category->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Categoria removida com sucesso!'
                ]
            ], 200);

        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function realState(int $id): JsonResponse
    {
        try {

            $category = $this->category->findOrFail($id);

            return response()->json([
                'data' => $category->realStates
            ], 200);

        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
