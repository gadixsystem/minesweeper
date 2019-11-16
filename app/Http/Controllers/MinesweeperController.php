<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Minesweeper;

class MinesweeperController extends Controller
{

    public function index(){

        return view('Minesweeper.index');
    }

    public function renderGrid(Request $request)
    {

        $currentID = $request->get("current");


        $current = Minesweeper::findOrFail($currentID);

        $columns = $current->columns;

        $rows = $current->rows;

        $data = [
            "columns" => $columns,
            "rows" => $rows,
            "current" => $currentID
        ];


        return view('Minesweeper.renderGrid', $data);
    }

    public function renderTableGrids(Request $request){

        $grids = Minesweeper::paginate(10);

        $data = [
            "grids" => $grids
        ];

        return view('Minesweeper.tableGrids',$data);

    }

}
