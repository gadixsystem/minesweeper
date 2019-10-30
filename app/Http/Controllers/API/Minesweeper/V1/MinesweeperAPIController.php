<?php

namespace App\Http\Controllers\API\Minesweeper\V1;

use Illuminate\Http\Request;
use App\Engine\Minesweeper;
use App\Http\Controllers\Controller;

class MinesweeperAPIController extends Controller
{
    public function new()
    {
        return "NEW METHOD";
    }


    public function getUserGrid(Request $request)
    {

        return response()
            ->json($request->session()->get("userGrid"));
    }


    public function check(Request $request)
    {

        $minesweeper = new Minesweeper();

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
