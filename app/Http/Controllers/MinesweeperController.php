<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MinesweeperController extends Controller
{
    public function index(Request $request)
    {

        $columns = $rows = 5;

        $data = [
            "columns" => $columns,
            "rows" => $rows,
        ];

        $request->session()->put("grid", $this->makeGrid($columns, $rows));
        //var_dump($request->session()->get("grid"));die();
        return view('Minesweeper.index', $data);
    }



    private function makeGrid($columns, $rows)
    {

        $mines = 10;

        $cells = $columns * $rows;

        $grid = array();

        for ($i = 0; $i < $rows; $i++) {

            $line = array();

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
                } else {
                    $mine = 0;
                }
                array_push($line, $mine);
                $cells--;
            }

            array_push($grid, $line);
        }

        return $grid;
    }

    public function check(Request $request)
    {

        $position = explode('-', $request->get("cell"));

        $grid = $request->session()->get("grid");


        if ($grid[$position[0]][$position[1]] == 1) {

            $status = "OUCH!";
        } else {

            $status = $this->calculate($grid, $request->get("cell"));
        }


        return response()
            ->json($status);
    }

    private function calculate($grid, $cell)
    {

        $count = 0;

        $top = $bottom = FALSE;

        $position = explode('-', $cell);

        $row = $position[0];

        $column = $position[1];

        // Dimensions
        $rows = sizeof($grid);

        $columns = sizeof($grid[0]);

        // Search in TOP

        if ($row - 1 >= 0) {
            $top = TRUE;
            if ($grid[$row - 1][$column] == 1) {
                $count++;
            }
        }

        // Search in Bottom

        if ($row + 1 < $rows) {
            $bottom = TRUE;
            if ($grid[$row + 1][$column] == 1) {
                $count++;
            }
        }

        // Search in Left

        if ($column - 1 >= 0) {

            if ($grid[$row][$column - 1] == 1) {
                $count++;
            }
            if ($top) {
                if ($grid[$row - 1][$column - 1] == 1) {
                    $count++;
                }
            }
            if ($bottom) {
                if ($grid[$row + 1][$column - 1] == 1) {
                    $count++;
                }
            }
        }

        // Search in Right

        if ($column + 1 < $columns) {
            if ($grid[$row][$column + 1] == 1) {
                $count++;
            }
            if ($top) {
                if ($grid[$row - 1][$column + 1] == 1) {
                    $count++;
                }
            }
            if ($bottom) {
                if ($grid[$row + 1][$column + 1] == 1) {
                    $count++;
                }
            }
        }


        return $count;
    }
}
