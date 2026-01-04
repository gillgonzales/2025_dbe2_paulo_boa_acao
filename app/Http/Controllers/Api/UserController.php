<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;
use App\Http\Resources\UserUpdatedResource;
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new UserResourceCollection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        try {
            return (new UserResource(User::create($request->validated())));
        } catch (Exception $error) {
            $this->errorHandler('Erro ao criar novo usuário',$error);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user)
    {
        try {
             if ($request->user()->id == $user->id) {
                return new UserResource($user);
            } else if ($request->user()->is_admin) {
                return new UserResource($user);
            } else {
                throw new Exception("Não autorizado.");
            }
            // if(($request->user()->id != $user->id) && (!$request->user()->is_admin && !$request->user()->is_donor))

            // return new UserResource($user);
        } catch(Exception $error) {
            return $this->errorHandler('Erro ao consultar usuário - Sem permissão',$error, 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            if ($request->user()->id == $user->id) {//Isso nunca vai acontecer se o user não é is-donor
                $user->update($request->validated());
                return new UserUpdatedResource($user);
            } else if ($request->user()->is_admin) {
                $user->update($request->validated());
                return new UserUpdatedResource($user);
            } else {
                throw new Exception("Não autorizado.");
            }
        } catch(Exception $error) {
            return $this->errorHandler('Erro ao atualizar usuário - Sem permissão',$error,403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        try {
            if ($request->user()->id == $user->id) {
                $user->delete();
                return (new UserResource($user))->additional(["message" => "Usuário Removido!!!"]);
            } else if ($request->user()->is_admin) {
                $user->delete();
                return (new UserResource($user))->additional(["message" => "Usuário Removido!!!"]);
            } else {
                throw new Exception("Não autorizado.");
            }
        } catch(Exception $error) {
            return $this->errorHandler("Erro ao deletar Usuário", $error,403);
        }

    }
}
