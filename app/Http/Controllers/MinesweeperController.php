<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MinesweeperController extends Controller
{
    public function index(Request $request){

        $columns = $rows = 5;

        $data = [
            "columns" => $columns,
            "rows" => $rows,
        ];
        return view('Minesweeper.index',$data);

    }



    private function makeGrid(){




    }
}
