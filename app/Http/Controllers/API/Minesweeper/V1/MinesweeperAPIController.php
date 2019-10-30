<?php

namespace App\Http\Controllers\API\Minesweeper\V1;

use Illuminate\Http\Request;
use App\Engine\MinesweeperEngine;
use App\Http\Controllers\Controller;
use App\Minesweeper;

class MinesweeperAPIController extends Controller
{
    public function new()
    {
        $engine = new MinesweeperEngine();

        $rows = 5;
        $columns = 5;
        $mines = 10;

        $grid = $engine->makeGrid($columns,$rows,$mines);

        $minesweeper =Minesweeper::create([
            "grid" => $grid,
            "userGrid" => $engine->makeUserGrid($grid),
            "rows" => $rows,
            "columns" => $columns,
            "mines" => $mines,
            "gameover" => FALSE,
            "user_id" => NULL,
            "time" => 0
        ]);

        return response()->json($minesweeper->id);
    }


    public function getUserGrid(Request $request)
    {

        return response()
            ->json($request->session()->get("userGrid"));
    }


    public function check(Request $request)
    {

        $minesweeper = new MinesweeperEngine();

        if ($request->session()->get("gameover")) {
            return response()
                ->json("GAME OVER");
        }

        $cell = $request->get("cell");

        $position = explode('-', $cell);

        $grid = $request->session()->get("grid");

        $userGrid = $request->session()->get("userGrid");


        if ($grid[$position[0]][$position[1]] == 1) {

            $status = "B";

            $request->session()->push("gameover", true);
        } else {
            $status = $minesweeper->calculate($grid, $cell);

            if ($status == 0) {
                $request->session()->put("userGrid", $minesweeper->calculateAdjacentMines($grid, $userGrid, $cell));
            } else {
                $request->session()->put("userGrid", $minesweeper->updateUserGrid($userGrid, $cell, $status));
            }
        }

        return response()
            ->json($status);
    }
}
