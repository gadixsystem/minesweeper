<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MinesweeperController extends Controller
{
    public function index(Request $request){

        return view('Minesweeper.index');

    }
}
