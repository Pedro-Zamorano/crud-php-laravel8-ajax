<!DOCTYPE html>
<html lang="es">
<head>
    <title>PHP CRUD Laravel 8 - Ajax</title>
    <meta charset="UTF-8">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ url('/') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>

    <div class="container">

        <h2 class="text-center mt-5 mb-3">CRUD PHP - Laravel 8 - Ajax</h2>

        <div class="card">

            <div class="card-header">                
                <a href="/" class="btn btn-success">CRUD</a>
            </div>

            <!-- INICIO FECHAS -->
            <form method="get" class="mt-3 ms-3">
                <h3>Filtrar por Fechas:</h3>

                <label>Desde:</label>
                <input type="date" name="date1">

                <label class="ms-3">Hasta:</label>
                <input type="date" name="date2">

                <input type="submit" name="submit" value="Filtrar" class="btn btn-primary ms-2">
            </form>
            <hr>
            


            <!-- FIN FECHAS -->
            

            <div class="card-body">

                <div id="alert-div">
                 
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Codigo</th>
                            <th>Unidad Medida</th>
                            <th>Valor</th>
                            <th>Fecha</th>
                            <th>Tiempo</th>
                            <th>Origen</th>
                        </tr>
                    </thead>
                    <tbody id="indicators-table-body">

                    </tbody>
                </table>

            </div>

        </div>

    </div><!-- Fin container --> 

    
    @php
    // Para fecha 'DESDE'

    $dob = '';
    if(isset($_GET['submit'])){ 
        $dob = $_GET['date'];
        $result = explode('-', $dob);
        $date = $result[2];
        $month = $result[1];
        $year = $result[0];
        $space = '-';
        // echo $new = $date.'-'.$month.'-'.$year;
    }
    $fecha_desde = $year.$month.$date;
    // echo " / Formato DB: ".$dob;
    
    @endphp

    @php
    // Para fecha 'HASTA'

    $dob2 = '';
    if(isset($_GET['submit'])){ 
        $dob2 = $_GET['date'];
        $result2 = explode('-', $dob);
        $date2 = $result[2];
        $month2 = $result[1];
        $year2 = $result[0];
        $space2 = '-';        
    }
    $fecha_hasta = $year2.$month2.$date2;

    @endphp

    <script type="text/javascript">

        /* 
        var date = new Date();

        var year = date.getFullYear();

        var month = String(date.getMonth()+1).padStart(2,'0');

        var todayDate = String(date.getDate()).padStart(2,'0');

        var datePattern = year + '-' + month + '-' + todayDate;

        document.getElementById("inputFechaDesde").value = datePattern;

        document.write(datePattern);

        resta de fechas que no tengan guion

         */

        //console.log('2020-2020-2020').replace("", "-");

        // Fecha del PHP a Script con JSON
        const fecha_desde = {!! json_encode($fecha_desde) !!};
        const fecha_hasta = {!! json_encode($fecha_hasta) !!};
        console.log('DESDE:');
        console.log(fecha_desde);
        console.log('HASTA:');
        console.log(fecha_hasta);


        showAllIndicators();
                
        /*Funcion que tomara todos los datos de los Indicadores*/
       
        function showAllIndicators()
        {
            let url = $('meta[name=app-url]').attr("content") + "/indicators";
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    $("#indicators-table-body").html("");
                    let indicators = response.indicators;
                    
                    

                    for (var i = 0; i < indicators.length; i++){                  
                        
                        
                        if((indicators[i].fechaIndicador).replace('-', '').replace('-', '') == fecha_desde){
                            let indicatorRow = '<tr>' +
                            '<td>' + indicators[i].nombreIndicador + '</td>' +
                            '<td>' + indicators[i].codigoIndicador + '</td>' +
                            '<td>' + indicators[i].unidadMedidaIndicador + '</td>' +
                            '<td>' + indicators[i].valorIndicador + '</td>' +
                            '<td>' + indicators[i].fechaIndicador + '</td>' +
                            '<td>' + indicators[i].tiempoIndicador + '</td>' +
                            '<td>' + indicators[i].origenIndicador + '</td>'
                        '</tr>';
                        $("#indicators-table-body").append(indicatorRow);

                        console.log('DB_DATE:');
                        console.log((indicators[i].fechaIndicador).replace('-', '').replace('-', ''));
                            
                        }
    
                        
                    }     

                        
                   


                    
                     
                },
                error: function(response) {
                    console.log(response.responseJSON)
                }
            });
        }       

    </script>






      


    
</body>
</html>