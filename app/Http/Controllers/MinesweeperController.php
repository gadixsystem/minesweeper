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

        $request->session()->put("grid",$this->makeGrid($columns,$rows));
        //var_dump($request->session()->get("grid"));die();
        return view('Minesweeper.index',$data);

    }



    private function makeGrid($columns,$rows){

        $mines = 10;

        $cells = $columns * $rows;

        $grid = Array();

        for ($i = 0; $i < $rows; $i++) {

            $line = Array();

            for ($v = 0; $v < $columns; $v++) {
                if ($mines > 0) {
                    if ($cells > $mines) {
                        $mine = rand(0, 1);
                    } else {
                        $mine = 1;
                    }

                    if ($mine == 1) {
                        $mines--;
                    }
                }else{
                    $mine = 0;
                }
                array_push($line, $mine);
                $cells--;
            }

            array_push($grid, $line);
        }

        return $grid;

    }

    public function check(Request $request){

        return response()
        ->json($request->get("cell"));
    }
}
