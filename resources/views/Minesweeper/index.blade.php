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



            </div>
            @csrf

    </body>
    <script>

        let cells = document.querySelectorAll('td')
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
            console.log("{{ route('api_minesweeper_check') }}")
            $.ajax({
                url: "{{ route('api_minesweeper_check') }}",
                method: "POST",
                data: {
                    cell: cell_id,
                    _token: _token
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
                case "X":
                    break;
                default:
                    cell.removeClass("default")
                    cell.html(`<center>${value}</center>`)
                break;

            }

        }

        function updateGrid(){
            $.ajax({
                url: "{{ route('api_minesweeper_user_grid') }}",
                method: "GET",
                success: function(response){

                    renderGrid(response)
                }
            })
        }

        function renderGrid(response){

            console.log(response[0].length)
            console.log(response.length)

            for(let i = 0;i < response.length;i++){
                for(let v = 0; v < response[0].length; v++){
                    let cell_id = `${i}-${v}`
                    let value = response[i][v]
                    updateCell(cell_id,value)
                }

            }

        }



    </script>
</html>
