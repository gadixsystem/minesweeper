<?php

namespace App\Engine;


class Minesweeper
{


    public function makeGrid($columns, $rows,$mines)
    {

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

        $empty = TRUE;

        /*Line to TOP */
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


        // Line to LEFT
        $i = 1;
        $empty = TRUE;
        while ($empty) {

            if ($column -  $i  >= 0) {
                $cellString = $row . "-" . ($column - $i);
                $status = $this->calculate($grid, $cellString);
                if ($status == 0) {
                    $userGrid[$row][$column - $i] = 0;
                } else {
                    $empty = FALSE;
                }
            } else {
                break;
            }
            $i++;
        }


        // Line to RIGHT
        $i = 1;
        $empty = TRUE;
        while ($empty) {

            if ($column +  $i   < $columns) {
                $cellString = $row . "-" . ($column + $i);
                $status = $this->calculate($grid, $cellString);
                if ($status == 0) {
                    $userGrid[$row][$column + $i] = 0;
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
}
