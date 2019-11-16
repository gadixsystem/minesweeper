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
</head>
<body>

    <div class="content">
            <div class="title m-b-md">
                Grids
            </div>

    <center>
    <div class="card" style="max-width: 80%;" >

      <table class="table table-striped" >
         <thead>
         <tr>
            <th>ID</th>
            <th>Rows</th>
            <th>Columns</th>
            <th>Mines</th>
            <th>Satus</th>
         </tr>
         </thead>
         <tbody>
            @foreach($grids as $grid)
            <tr>
               <td>{{ $grid->id }}</td>
               <td>{{ $grid->rows }}</td>
               <td>{{ $grid->columns }}</td>
               <td>{{ $grid->mines }}</td>
               @if($grid->gameover)
                <th><strong>GAME OVER  &#128542; </strong></th>
               @else
                <th></th>
               @endif

            </tr>
            @endforeach
         </tbody>
      </table>
      {{ $grids->links() }}
   </div>
   <br/>
   <a class="btn btn-primary" href="/" id="button_new">BACK</a>
</body>
<script>

</script>
</html>
