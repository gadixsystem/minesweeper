#Simple Minesweeper API and Frontend

API Methods:

    Route::post('new', 'API\Minesweeper\V1\MinesweeperAPIController@new');
    Route::post('/check/{gridId}', 'API\Minesweeper\V1\MinesweeperAPIController@check');
    Route::get('/usergrid/{gridId}', 'API\Minesweeper\V1\MinesweeperAPIController@getUserGrid');
    Route::get('/grid/rows/{gridId}', 'API\Minesweeper\V1\MinesweeperAPIController@getRows');
    Route::get('/grid/columns/{gridId}', 'API\Minesweeper\V1\MinesweeperAPIController@getColumns');
    Route::get('/grid/mines/{gridId}', 'API\Minesweeper\V1\MinesweeperAPIController@getMines');
    
============================================================

/New -> Create a New Grid
Method: POST
By Default return ID Grid

You need to Pass:

    rows: value > 2
    columns: value > 2
    mines: value > 1
    
============================================================

/check/{gridId}
Method: POST

This method provides what is necessary to check a cell inside the grid

You need to pass:

cell: string "$row-$column"
Example:
    2-4

    Optional:
    you can send parameter: flagMode "Y"
    and this will mark the cell for review.
===========================================================

/usergrid/{gridId}
Method: GET
Returns the current grid (with Flags and cells)

===========================================================

/grid/rows/{gridId}
Method: GET
Returns the rows in the current grid

===========================================================

/grid/columns/{gridId}
Method: GET
Returns the columns in the current grid

===========================================================

/grid/mines/{gridId}
Method: GET
Returns the mines in the current grid

===========================================================

Installation:

You need to follow this steps:

- git clone
- composer install
- php artisan key:generate
- Now you need to configure your DB Keys!
- php artisan migrate

Enjoy!

===========================================================

About Front End:

The front end was only developed in order to test the API,

The start screen shows the configuration options, and you can also play an unfinished game (not lost).

As for the flags, you can place them by pressing the "Normal" button, this will send the Flag parameter to the api, and this will only record that it was marked for review,to check that cell, just press the normal mode and press the cell.

