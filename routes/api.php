<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::middleware('cors')->group(function () {
Route::apiResource('anunciosapp', 'AnunciosappController');
Route::get('anunciosapp/vigentes/obtener', 'AnunciosappController@anunciosVigentes');
Route::get('anunciosapp/vigentes/obtener/{id}/locales/distritales', 'AnunciosappController@anunciosLocales');
Route::get('anunciosapp/todos/obtener/lista', 'AnunciosappController@anunciosTodos');
//});
