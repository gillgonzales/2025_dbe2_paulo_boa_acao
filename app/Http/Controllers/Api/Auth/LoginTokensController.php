<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginTokensController extends LoginController
{
    public function login(LoginRequest $request) {
        try {
            $user = $this->authenticate($request->validated());
            if(!$user) throw new Exception("Dados Inválidos!");
            if($user->is_admin == true) {
                $ability = ['is-admin'];
            } else if($user->is_donor == true) {
                $ability = ['is-donor'];
            } else {
                $ability = [];
            }
            $token = $user->createToken($user->email, $ability)->plainTextToken;
            return compact('token', 'user');
        }catch(Exception $error) {
            return $this->errorHandler($error->getMessage(),$error,401);
        }
    }

    public function logout(Request $request): JsonResponse {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Todas as sessões foram encerradas, realizado logout.']);
    }

    public function revoke(Request $request): JsonResponse {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sessão atual encerrada, Token Revogado.']);
    }

}
