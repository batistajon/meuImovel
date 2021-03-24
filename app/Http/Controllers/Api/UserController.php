<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{       
    /**
     * user
     *
     * @var mixed
     */
    private $user;
    
    /**
     * Method __construct
     *
     * @param User $user [explicite description]
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
        
    /**
     * Method index
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = $this->user->paginate(10);

        return response()->json($users, 200);
    }
    
    /**
     * Method store
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->all();

        if (!$request->has('password') || !$request->get('password')) {

            $message = new ApiMessages('É necessário informar uma senha para o usuário.');
            return response()->json($message->getMessage(), 401);
        }

        Validator::make($data, [
            'phone' => 'required',
            'mobile_phone' => 'required',
        ])->validate();

        try {

            $data['password'] = bcrypt($data['password']);
            $user = $this->user->create($data);
            $user->profile()->create([
                'phone' => $data['phone'],
                'mobile_phone' => $data['mobile_phone'],
            ]);

            return response()->json([
                'data' => [
                    'msg' => 'Usuario cadastrado com sucesso!'
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
     * @param $id $id [explicite description]
     *
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {

            $user = $this->user->with('profile')->findOrFail($id);
            $user->profile->social_networks = unserialize($user->profile->social_networks);

            return response()->json(['data' => $user], 200);

        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
       
    /**
     * Method update
     *
     * @param Request $request [explicite description]
     * @param int $id [explicite description]
     *
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $data = $request->all();

        if ($request->has('password') || $request->get('password')) {

            $data['password'] = bcrypt($data['password']);

        } else {
            
            unset($data['password']);
        }

        Validator::make($data, [
            'profile.phone' => 'required',
            'profile.mobile_phone' => 'required',
        ])->validate();

        try {

            $profile = $data['profile'];
            $profile['social_networks'] = serialize($profile['social_networks']);

            $user = $this->user->findOrFail($id);
            $user->update($data);
            
            $user->profile()->update($profile);

            return response()->json([
                'data' => [
                    'msg' => 'Usuario atualizado com sucesso!'
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
     * @param $id $id [explicite description]
     *
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {

            $user = $this->user->findOrFail($id);
            $user->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Usuario removido com sucesso!'
                ]
            ], 200);

        } catch (\Exception $e) {

            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
