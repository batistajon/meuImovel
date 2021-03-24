<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Models\RealStatePhoto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealStatePhotoController extends Controller
{       
    /**
     * realStatePhoto
     *
     * @var mixed
     */
    protected $realStatePhoto;
    
    /**
     * Method __construct
     *
     * @param RealStatePhoto $realStatePhoto [explicite description]
     *
     * @return void
     */
    public function __construct(RealStatePhoto $realStatePhoto)
    {
        $this->realStatePhoto = $realStatePhoto;
    }
    
    /**
     * Method setThumb
     *
     * @param int $photoId [explicite description]
     * @param int $realStateId [explicite description]
     *
     * @return JsonResponse
     */
    public function setThumb(int $photoId, int $realStateId): JsonResponse
    {
        try {

            $photo = $this->realStatePhoto
                ->where('real_state_id', $realStateId)
                ->where('is_thumb', true);

            if ($photo->count()) {

                $photo->first()->update(['is_thumb' => false]);
            } 

            $photo = $this->realStatePhoto->find($photoId);
            $photo->update(['is_thumb' => true]);

            return response()->json([
                'data' => [
                    'msg' => 'Thumb atualizada com sucesso!'
                ]
            ], 200);

        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
    
    /**
     * Method remove
     *
     * @param int $photoId [explicite description]
     *
     * @return JsonResponse
     */
    public function remove(int $photoId): JsonResponse
    {
        try {

            $photo = $this->realStatePhoto->find($photoId);

            if ($photo->is_thumb) {
                $message = new ApiMessages('Não é possível remover foto de thumb! Selecione outra thumb e remova a imagem desejada');
                return response()->json($message->getMessage(), 401);
            }

            if ($photo) {
                Storage::disk('public')->delete($photo->photo);
                $photo->delete();
            }

            return response()->json([
                'data' => [
                    'msg' => 'Foto removida com sucesso!'
                ]
            ], 200);

        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
