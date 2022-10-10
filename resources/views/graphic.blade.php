<!DOCTYPE html>
<html lang="es">
<head>
    <title>PHP Gráfica Laravel 8 - Ajax</title>
    <meta charset="UTF-8">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ url('/') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Scripts para gráfico -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

</head>
<body>

    <div class="container">

        <h2 class="text-center mt-5 mb-3">CRUD PHP - Laravel 8 - Ajax</h2>

        <div class="card">

            <div class="card-header">                
                <a href="/" class   ="btn btn-success">CRUD</a>
            </div>

            <!-- INICIO FECHAS -->
            <form method="get" class="mt-3 ms-3">
                <h3>Ingrese fechas para generar la gráfica:</h3>

                <label>Desde:</label>
                <input type="date" name="date" id="fechaDesde">

                <label>Hasta:</label>
                <input type="date" name="date" id="fechaHasta">

                <input type="submit" name="submit" id="submit" value="Filtrar" class="btn btn-primary ms-2">
            </form>
            <hr>
            <!-- FIN FECHAS -->

            <!-- INICIO GRÁFICO -->
            <figure class="highcharts-figure">
                <div id="container"></div>
                <p class="highcharts-description"></p>
            </figure>
            <!-- FIN GRÁFICO -->

        </div>

    </div><!-- Fin container --> 


    <script type="text/javascript">

    // Capturando las fechas
    $('#submit').click(function(event){ 
        event.preventDefault();
        
        var fechaDesde = $('#fechaDesde').val();
        var fechaHasta = $('#fechaHasta').val();

        if(fechaDesde != '' && fechaHasta != ''){
            showAllIndicators(fechaDesde, fechaHasta);
        }
        else{
            alert('Ingrese fecha faltante');
        }

    });    

    /*Funcion que tomara todos los datos de los Indicadores*/       
    function showAllIndicators(fechaDesde, fechaHasta)
    {
        let url = $('meta[name=app-url]').attr("content") + "/indicators";
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                $("#indicators-table-body").html("");
                let indicators = response.indicators;

                // Variable para capturar fechas y valores
                var fechasValores = [];
                
                for (var i = 0; i < indicators.length; i++){

                    
                    if(indicators[i].fechaIndicador >= fechaDesde && indicators[i].fechaIndicador < fechaHasta+1){

                        // Agregando todos los datos en la variable FECHAS
                        fechasValores.push(indicators[i].fechaIndicador);
                        fechasValores.push(indicators[i].valorIndicador);
                        //valores.push(indicators[i].valorIndicador);
                        
                    }else if(indicators[i].fechaIndicador >= fechaHasta && indicators[i].fechaIndicador < fechaDesde+1){

                        // Agregando todos los datos en la variable FECHAS
                        fechasValores.push(indicators[i].fechaIndicador);
                        fechasValores.push(indicators[i].valorIndicador);                        
                    }                
                    
                }                

                // Iterando fechaValores                
                iterandoValores(fechasValores);
                
            },
        });
    }

    function iterandoValores(fechasValores){
        var pruebas = [];        

        num = 2;
        for(var i = 0; i < fechasValores.length; i++){
            pruebas.push(fechasValores.slice(i, num));
            i += 1
            num += 2
        }
        console.log(pruebas);

        // INICIO FUNCION Grafica
        $(document).ready(function(){

            var options = {
            chart: {
                type: 'column',
                renderTo: 'container'
            },
            title: {
                align: 'left',
                text: '<strong>Gráfico Indicadores</strong>'
            },
            subtitle: {
                align: 'left'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Valor Indicadores'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.0f}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.1f}</b><br/>'
            },

            series: [
                {
                    name: "Indicadores",
                    data: []
                }
            ]
        }

        $.each(pruebas, function (i, point) {
            point[0] = point[0];
            point[1] = parseFloat(point[1]);
        });        

        options.series[0].data = pruebas;

        // Create the chart
        var chart = new Highcharts.Chart(options);

        });       
        
    }
    </script>
</body>
</html>