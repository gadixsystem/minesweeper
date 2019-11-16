<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Minesweeper</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

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
            .green {
                background-color: #4CAF50;
            }

            td{
                min-width: 50px;
            }
            .btn{

                border: none;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
            }
            .btn-primary{
                background-color: #4CAF50; /* Green */
            }
            .btn-new{
                background-color: #3333FF; /* Blue */
            }



        </style>
    </head>
    <body>

            <div class="content">
                <div class="title m-b-md">
                  Minesweeper
                </div>
                <h2>Game ID #{{ $current }}</h2>


                <center>

                    <table border="1" style="font-size: 30px;">
                    @for($i = 0 ; $i < $rows ; $i++)

                        <tr>
                            @for($v = 0 ; $v < $columns ; $v++)
                            <td id="{{ $i }}-{{ $v }}" class="default">
                                &nbsp;
                            </td>
                            @endfor
                        </tr>

                    @endfor
                    </table>
                </center>
                <br/>
                <button class="btn btn-new" value="N" id="button_new">NEW GAME</button>
                <button class="btn btn-primary" value="N" id="button_mode">NORMAL</button>



            </div>
            @csrf

    </body>
    <script>

        let current = {{ $current }}
        let cells = document.querySelectorAll('td')
        let buttonMode = document.getElementById("button_mode")
        let buttonNew = document.getElementById("button_new")

        var flagMode = false

        buttonMode.addEventListener("click",e =>{
            e.preventDefault()
            e.stopPropagation()
            flagMode = !flagMode
            if(flagMode){
                e.target.firstChild.data = "FLAG MODE"
                e.target.value = "Y"
            }else{
                e.target.firstChild.data = "NORMAL"
                e.target.value = "N"
            }
        })

        buttonNew.addEventListener("click",e=>{
            e.preventDefault()
            e.stopPropagation()
            alert("Your game ID is "+current)
            window.location = "/"
        })
        // Laravel Token!
        let _token = document.getElementsByName("_token")[0].value
        for(let i = 0; i < cells.length ;i++){
            cells[i].addEventListener("click",e=>{
                e.stopPropagation()
                e.preventDefault()
                check(e.target.id)
            })
        }


        function check(cell_id){



            $.ajax({
                url: "{{ url('api/minesweeper/V1/check/')}}/"+current,
                method: "PUT",
                data: {
                    cell: cell_id,
                    _token: _token,
                    flagMode : $("#button_mode").val()
                },
                success:function(response){
                    updateCell(cell_id,response)
                    updateGrid()
                }
            })

        }

        function updateCell(cell_id,value){

            let cell = $("#"+cell_id)


            switch(value){
                case 0:
                    cell.removeClass("default")
                    cell.removeClass("green")
                    cell.addClass("white")
                break;
                case "B":
                    cell.removeClass("default")
                    cell.addClass("red");
                    alert("GAME OVER!")
                break;
                case "GAME OVER":
                    alert("GAME OVER!")
                break;
                case "WIN":
                    alert("YOU WIN!")
                break;
                case "F":
                    cell.removeClass("default")
                    cell.addClass("green");

                break;
                case "X":
                    break;
                default:
                    cell.removeClass("default")
                    cell.removeClass("green")
                    cell.html(htmlNumberColor(value))
                break;

            }

        }

        function updateGrid(){
            $.ajax({
                url: "{{ url('api/minesweeper/V1/usergrid/')}}/"+current,
                method: "GET",
                success: function(response){

                    renderGrid(response)
                }
            })
        }

        function renderGrid(response){



            for(let i = 0;i < response.length;i++){
                for(let v = 0; v < response[0].length; v++){
                    let cell_id = `${i}-${v}`
                    let value = response[i][v]
                    updateCell(cell_id,value)
                }

            }

        }

        updateGrid();

        function htmlNumberColor(value){
            color = ""
            switch(value){
                case 1:
                    color = "color='blue'"
                break;
                case 2:
                    color = "color='green'"
                break;
                case 3:
                    color = "color='red'"
                break;
                default:
                    color = "color='maroon'"
                break;
            }

            return `<center><strong><font ${color}>${value}</font></strong></center>`


        }


    </script>
</html>
