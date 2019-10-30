<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Minesweeper</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <!-- Styles -->


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

        </style>
        <style>
            /** Minesweeper Styles **/
            .white {
                background-color : #fff;
            }
            .default {
                background-color: #636b6f;
            }
            .red {
                background-color: #ff0000;
            }

            td{
                min-width: 50px;
            }



        </style>
    </head>
    <body>

        <div class="content">
                <div class="title m-b-md">
                  Minesweeper
                </div>

        <center>
        <div class="card" style="width: 25rem;">

                <div class="card-body">
                  <h5 class="card-title"></h5>
                  <p class="card-text">Complete and enjoy!</p>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                        <label for="rows" >Rows</label>
                        <input class="form-control" type="number" min="2" id="rows" name="rows" placeholder="5" value="5">

                  </li>
                  <li class="list-group-item">
                        <label for="columns" >Columns</label>
                        <input class="form-control" type="number" min="2" id="columns" name="columns" placeholder="5" value="5">

                  </li>
                  <li class="list-group-item">
                        <label for="columns" >Mines</label>
                        <input class="form-control" type="number" min="1" id="mines" name="mines" placeholder="1" value="1">

                  </li>

                </ul>
                <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                                <label for="columns" >Saved Grid ID:</label>
                                <input class="form-control" type="number" min="1" id="saved" name="saved" placeholder="1" value="1">

                        </li>
                </ul>
                <div class="card-body">
                  <button class="btn btn-primary" id="btn_play">PLAY New</button>
                  <button class="btn btn-success" id="btn_saved">Play with Saved Grid</button>
                </div>
              </div>
            </center>
            <form id="playForm" action="{{ route('play') }}" method="POST">
                @csrf
                <input type="hidden" name="current" id="current" >
            </form>
        </div>
    </body>
    <script>

        let buttonPlay = document.getElementById("btn_play")
        let buttonSaved = document.getElementById("btn_saved")
        buttonPlay.addEventListener("click",e=>{
            e.preventDefault()
            e.stopPropagation()

            getNewGrid()

        })

        buttonSaved.addEventListener("click", e => {
            e.stopPropagation()
            e.preventDefault()
            play($("#saved").val())
        })

        function getNewGrid(){

            data = {
                'rows' : $("#rows").val(),
                'columns' : $("#columns").val(),
                'mines' : $("#mines").val(),
            }


            $.ajax({
                url: "{{ url('api/minesweeper/V1/new')}}/",
                method: "POST",
                data:data,
                success: function(response){

                    play(response)
                }
            })

        }

        function play(id){
            $("#current").val(id)
            form = document.getElementById("playForm")
            form.submit();
        }


    </script>
</html>
