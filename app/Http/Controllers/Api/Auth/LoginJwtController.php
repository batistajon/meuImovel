<?php

namespace App\Http\Controllers\Api\Auth;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class LoginJwtController extends Controller
{    
    /**
     * Method login
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->all(['email', 'password']);

        Validator::make($credentials, [
            'email' => 'required|string ',
            'password' => 'required|string ',
        ])->validate();

        if(!$token = Auth::guard('api')->attempt($credentials)) {

            $message = new ApiMessages('Unauthorized');
            return response()->json($message->getMessage(), 401);
        }

        return response()->json(['token' => $token]);
    }
    
    /**
     * Method logout
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::guard('api')->logout();

        return response()->json(['message' => 'Logout successfully!'], 200);
    }
    
    /**
     * Method refresh
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $token = Auth::guard('api')->refresh();

        return response()->json(['token' => $token]);
    }
}
