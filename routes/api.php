<?php

use App\Http\Controllers\Api\Auth\LoginStatefullController;
use App\Http\Controllers\Api\Auth\LoginTokensController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProdutoController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\SubcategoriaController;

Route::prefix('v1')->group(function () {
    Route::middleware('web')
    ->prefix('spa')
    ->controller(LoginStatefullController::class)
    ->group(function () {
        Route::post("/login", [LoginStatefullController::class, 'login']);
        Route::post("/logout", [LoginStatefullController::class, 'logout']);
    });

    Route::prefix('tokens')
    ->controller(LoginTokensController::class)
    ->group(function () {
        Route::post('logout','logout')->middleware("auth:sanctum");
        Route::post('revoke','revoke')->middleware("auth:sanctum");
        Route::post('login','login');
    });

    Route::resource('produtos', ProdutoController::class)->only(['index', 'show']);
    Route::apiResource('itens', ItemController::class)
        ->parameters(['itens' => 'item'])
        ->only(['index','show']);
    Route::apiResource('categorias', CategoriaController::class)
        ->only(['index','show']);
    Route::apiResource('subcategorias', SubcategoriaController::class)
        ->only(['index','show']);
    Route::apiResource('users', UserController::class)
        ->only(['store']);//o store ficou fora pois um usuário pode criar se cadastrar sem ter se autenticado

    Route::middleware('auth:sanctum')->group(function () {
        Route::resource('produtos', ProdutoController::class)
            ->only(['store', 'update', 'destroy'])
            ->middleware('ability:is-admin');
        Route::apiResource('itens', ItemController::class)
            ->parameters(['itens' => 'item'])
            ->only(['store', 'update', 'destroy'])
            ->middleware('ability:is-admin,is-donor');
        Route::apiResource('categorias', CategoriaController::class)
            ->only(['store', 'update', 'destroy'])
            ->middleware('ability:is-admin');
        Route::apiResource('subcategorias', SubcategoriaController::class)
            ->only(['store', 'update', 'destroy'])
            ->middleware('ability:is-admin');
        Route::apiResource('usuarios', UsuarioController::class);
        Route::apiResource('users', UserController::class)
            ->only(['index'])
            ->middleware('ability:is-admin');

        // Rota para ver um SÓ, EDITAR, DELETAR (show, update, destroy)
        Route::apiResource('users', UserController::class)
            ->except(['index','store']); // Exclui a listagem (index)
            // ->middleware('ability:is-admin,is-donor'); //não necessário pois já faz verificação no controller
            });//Com os abilities aplicados, usuários que não sejam admin nem is-donor, não poderão alterar seus dados.

        //->except(['index','show']);
});
