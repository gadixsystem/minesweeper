<?php

namespace App\Engine;


class MinesweeperEngine
{


    public function makeGrid($columns, $rows, $mines)
    {

        $cells = $columns * $rows;

        $mixMines = array_rand(range(1, $cells), $mines);

        if($mines == 1){
            $mixMines = Array($mixMines);
        }
        $cell = 1;

        $grid = array();

        for ($i = 0; $i < $rows; $i++) {

            $line = array();

            for ($v = 0; $v < $columns; $v++) {

                if (in_array($cell, $mixMines)) {
                    $mine = 1;
                } else {
                    $mine = 0;
                }

                array_push($line, $mine);
                $cell++;
            }

            array_push($grid, $line);
        }

        return $grid;
    }

    public function makeUserGrid($grid)
    {

        $emptyRow = array();
        $emptyGrid = array();

        for ($i = 0; $i < sizeof($grid[0]); $i++) {

            array_push($emptyRow, "X");
        }

        for ($i = 0; $i < sizeof($grid); $i++) {
            array_push($emptyGrid, $emptyRow);
        };

        return $emptyGrid;
    }




    public function calculate($grid, $cell)
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

    public function calculateAdjacentMines($grid, $userGrid, $cell)
    {

        $position = explode('-', $cell);

        $row = $position[0];

        $column = $position[1];

        // Dimensions
        $rows = sizeof($grid);

        $columns = sizeof($grid[0]);

        $userGrid[$row][$column] = 0;

        $userGrid = $this->calculateBottom($rows, $row, $column, $grid, $userGrid);

        $userGrid = $this->calculateTop($row, $column, $grid, $userGrid);

        $userGrid = $this->calculateLeft($rows, $row, $column, $grid, $userGrid);

        $userGrid = $this->calculateRight($rows, $columns, $row, $column, $grid, $userGrid);

        return $userGrid;
    }

    private function calculateLeft($rows, $row, $column, $grid, $userGrid)
    {

        // Line to LEFT
        $i = 1;
        $empty = TRUE;
        while ($empty) {

            if ($column -  $i  >= 0) {
                $cellString = $row . "-" . ($column - $i);
                $status = $this->calculate($grid, $cellString);
                if ($status == 0) {
                    $userGrid[$row][$column - $i] = 0;
                    $userGrid = $this->calculateBottom($rows, $row, $column - $i, $grid, $userGrid);
                    $userGrid = $this->calculateTop($row, $column - $i, $grid, $userGrid);
                } else {
                    $empty = FALSE;
                }
            } else {
                break;
            }
            $i++;
        }

        return $userGrid;
    }

    private function calculateRight($rows, $columns, $row, $column, $grid, $userGrid)
    {

        // Line to RIGHT
        $i = 1;
        $empty = TRUE;
        while ($empty) {

            if ($column +  $i   < $columns) {
                $cellString = $row . "-" . ($column + $i);
                $status = $this->calculate($grid, $cellString);
                if ($status == 0) {
                    $userGrid[$row][$column + $i] = 0;
                    $userGrid = $this->calculateBottom($rows, $row, $column + $i, $grid, $userGrid);
                    $userGrid = $this->calculateTop($row, $column + $i, $grid, $userGrid);
                } else {
                    $empty = FALSE;
                }
            } else {
                break;
            }
            $i++;
        }

        return $userGrid;
    }

    private function calculateTop($row, $column, $grid, $userGrid)
    {

        /*Line to TOP */
        $empty = TRUE;
        $i = 1;
        while ($empty) {

            if ($row - $i  >= 0) {
                $cellString = ($row - $i) . "-" . $column;
                $status = $this->calculate($grid, $cellString);
                if ($status == 0) {
                    $userGrid[$row - $i][$column] = 0;
                } else {
                    $empty = FALSE;
                }
            } else {
                break;
            }
            $i++;
        }

        return $userGrid;
    }

    private function calculateBottom($rows, $row, $column, $grid, $userGrid)
    {

        // Line to BOTTOM
        $i = 1;
        $empty = TRUE;
        while ($empty) {

            if ($row + $i  < $rows) {
                $cellString = ($row + $i) . "-" . $column;
                $status = $this->calculate($grid, $cellString);
                if ($status == 0) {
                    $userGrid[$row + $i][$column] = 0;
                } else {
                    $empty = FALSE;
                }
            } else {
                break;
            }
            $i++;
        }

        return $userGrid;
    }


    public function updateUserGrid($userGrid, $cell, $value)
    {

        $position = explode('-', $cell);

        $userGrid[$position[0]][$position[1]] = $value;

        return $userGrid;
    }

    public function checkWin($current)
    {

        // Dimensions
        $rows = $current->rows;

        $columns = $current->columns;

        $mines = $current->mines;

        $userGrid = $current->userGrid;

        $grid = $current->grid;

        if($current->gameover){

            return FALSE;

        }

        $win = TRUE;

        for ($i = 0; $i < $rows; $i++) {

            if(!$win){
                break;
            }

            for ($v = 0; $v < $columns; $v++) {

                if ($userGrid[$i][$v] !== "X" ) {

                    if ($userGrid[$i][$v] === "F" && $grid[$i][$v] === 1) {
                        $mines--;
                    }
                }else{

                    $win = FALSE;
                    break;
                }
            }
        }

        if($win &&  $mines == 0){
            return TRUE;
        }
        return FALSE;
    }
}
