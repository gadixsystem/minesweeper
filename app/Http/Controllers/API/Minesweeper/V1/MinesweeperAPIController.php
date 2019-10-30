<?php

namespace App\Http\Controllers\API\Minesweeper\V1;

use Illuminate\Http\Request;
use App\Engine\MinesweeperEngine;
use App\Http\Controllers\Controller;
use App\Minesweeper;

class MinesweeperAPIController extends Controller
{
    public function new(Request $request)
    {
        $engine = new MinesweeperEngine();

        $rows = $request->get("rows");
        $columns = $request->get("columns");
        $mines = $request->get("mines");

        if($rows < 2 || $columns < 2 || $mines < 1 ){
            return response()->json(["ERROR" => "Check values"]);
        }

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


    public function getUserGrid(Request $request,$gridId)
    {

        $userGrid = Minesweeper::findOrFail($gridId);

        return response()
            ->json($userGrid->userGrid);
    }

    public function getRows($gridId)
    {

        $userGrid = Minesweeper::findOrFail($gridId);

        return response()
            ->json($userGrid->rows);
    }

    public function getColumns($gridId)
    {

        $userGrid = Minesweeper::findOrFail($gridId);

        return response()
            ->json($userGrid->columns);
    }

    public function getMines($gridId)
    {

        $userGrid = Minesweeper::findOrFail($gridId);

        return response()
            ->json($userGrid->mines);
    }

    public function check($gridId)
    {

        $minesweeper = new MinesweeperEngine();

        $current = Minesweeper::findOrFail($gridId);

        if ($current->gameover) {
            return response()
                ->json("GAME OVER");
        }

        $cell = $request->get("cell");

        $position = explode('-', $cell);

        $grid = $current->grid;

        $userGrid = $current->userGrid;


        if ($grid[$position[0]][$position[1]] == 1) {

            $status = "B";

            $current->gameover = TRUE;

        } else {
            $status = $minesweeper->calculate($grid, $cell);

            if ($status == 0) {

                $current->userGrid = $minesweeper->calculateAdjacentMines($grid, $userGrid, $cell);

            } else {
                $current->userGrid = $minesweeper->updateUserGrid($userGrid, $cell, $status);
            }
        }

        $current->save();

        return response()
            ->json($status);
    }
}
