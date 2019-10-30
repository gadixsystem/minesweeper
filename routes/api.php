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


Route::prefix('minesweeper/V1')->group(function () {
    Route::get('new', 'API\Minesweeper\V1\MinesweeperAPIController@new');
    Route::post('/check', 'API\Minesweeper\V1\MinesweeperAPIController@check')->name("api_minesweeper_check");
    Route::get('/usergrid', 'API\Minesweeper\V1\MinesweeperAPIController@getUserGrid')->name("api_minesweeper_user_grid");
});
