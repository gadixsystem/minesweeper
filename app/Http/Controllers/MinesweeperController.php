<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Engine\Minesweeper ;

class MinesweeperController extends Controller
{
    public function index(Request $request)
    {

        $minesweeper = new Minesweeper();

        $columns = $rows = 5;

        $mines = 1;

        $data = [
            "columns" => $columns,
            "rows" => $rows,
        ];

        $grid =  $minesweeper->makeGrid($columns, $rows,$mines);

        $request->session()->put("grid", $grid);

        $request->session()->put("userGrid", $minesweeper->makeUserGrid($grid));

        $request->session()->put("gameover", false);

        return view('Minesweeper.index', $data);
    }



}
