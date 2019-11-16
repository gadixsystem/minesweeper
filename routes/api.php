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
    Route::post('new', 'API\Minesweeper\V1\MinesweeperAPIController@new');
    Route::put('/check/{gridId}', 'API\Minesweeper\V1\MinesweeperAPIController@check');
    Route::get('/usergrid/{gridId}', 'API\Minesweeper\V1\MinesweeperAPIController@getUserGrid');
    Route::get('/grid/rows/{gridId}', 'API\Minesweeper\V1\MinesweeperAPIController@getRows');
    Route::get('/grid/columns/{gridId}', 'API\Minesweeper\V1\MinesweeperAPIController@getColumns');
    Route::get('/grid/mines/{gridId}', 'API\Minesweeper\V1\MinesweeperAPIController@getMines');
});

/*
api/minesweeper/V1/grid/rows/1
