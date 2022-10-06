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
                <button class="btn btn-outline-primary" onclick="createIndicator()"> 
                    Crear nuevo registro
                </button>
                
                <a href="graphic" class="btn btn-success">Gráfico</a>

            </div>

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
                            <th width="240px">Action</th>
                        </tr>
                    </thead>
                    <tbody id="indicators-table-body">
                         
                    </tbody>
                </table>

            </div>

        </div>

    </div><!-- Fin container -->

    <!-- Crear y Editar -->
    <div class="modal" tabindex="-1"  id="form-modal">

        <div class="modal-dialog" >

            <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Formulario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div id="error-div"></div>

                <form>
                    <input type="hidden" name="update_id" id="update_id">
                    
                    <div class="form-group">
                        <label for="nombreIndicador">Nombre Indicador</label>
                        <input type="text" class="form-control" id="nombreIndicador" name="nombreIndicador">
                    </div>

                    <div class="form-group">
                        <label for="codigoIndicador">Codigo Indicador</label>
                        <input type="text" class="form-control" id="codigoIndicador" name="codigoIndicador">
                    </div>

                    <div class="form-group">
                        <label for="unidadMedidaIndicador">Unidad Medida Indicador</label>
                        <input type="text" class="form-control" id="unidadMedidaIndicador" name="unidadMedidaIndicador">
                    </div>

                    <div class="form-group">
                        <label for="valorIndicador">Valor Indicador</label>
                        <input type="text" class="form-control" id="valorIndicador" name="valorIndicador">
                    </div>

                    <div class="form-group">
                        <label for="fechaIndicador">Fecha Indicador</label>
                        <input type="date" class="form-control" id="fechaIndicador" name="fechaIndicador">
                    </div>

                    <div class="form-group">
                        <label for="tiempoIndicador">Tiempo Indicador</label>
                        <input type="text" class="form-control" id="tiempoIndicador" name="tiempoIndicador">
                    </div>

                    <div class="form-group">
                        <label for="origenIndicador">Origen Indicador</label>
                        <input type="text" class="form-control" id="origenIndicador" name="origenIndicador">
                    </div>
                
                    <button type="submit" class="btn btn-outline-primary mt-3" id="save-indicator-btn">Guardar</button>                    
                </form>

            </div>
            </div>

        </div>

    </div>

    <!-- Ver registro -->
    <div class="modal" tabindex="-1" id="view-modal">

        <div class="modal-dialog" >

            <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Información del Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <b>Nombre Indicador:</b>
                <p id="nombreIndicador-info"></p>

                <b>Codigo Indicador:</b>
                <p id="codigoIndicador-info"></p>

                <b>Unidad Medida Indicador:</b>
                <p id="unidadMedidaIndicador-info"></p>

                <b>Valor Indicador:</b>
                <p id="valorIndicador-info"></p>

                <b>Fecha Indicador:</b>
                <p id="fechaIndicador-info"></p>

                <b>Tiempo Indicador:</b>
                <p id="tiempoIndicador-info"></p>

                <b>Origen Indicador:</b>
                <p id="origenIndicador-info"></p>
            </div>

            </div>

        </div>

    </div>

    <script type="text/javascript">

        showAllIndicators();

        /*
            Funcion que tomara todos los datos de los Indicadores
        */
        function showAllIndicators()
        {
            let url = $('meta[name=app-url]').attr("content") + "/indicators";
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    $("#indicators-table-body").html("");
                    let indicators = response.indicators;
                    for (var i = 0; i < indicators.length; i++) 
                    {
                        let showBtn =  '<button ' +
                            ' class="btn btn-outline-info" ' +
                            ' onclick="showIndicator(' + indicators[i].id + ')">Show' +
                        '</button> ';
                        let editBtn =  '<button ' +
                            ' class="btn btn-outline-success" ' +
                            ' onclick="editIndicator(' + indicators[i].id + ')">Edit' +
                        '</button> ';
                        let deleteBtn =  '<button ' +
                            ' class="btn btn-outline-danger" ' +
                            ' onclick="destroyIndicator(' + indicators[i].id + ')">Delete' +
                        '</button>';
     
                        let indicatorRow = '<tr>' +
                            '<td>' + indicators[i].nombreIndicador + '</td>' +
                            '<td>' + indicators[i].codigoIndicador + '</td>' +
                            '<td>' + indicators[i].unidadMedidaIndicador + '</td>' +
                            '<td>' + indicators[i].valorIndicador + '</td>' +
                            '<td>' + indicators[i].fechaIndicador + '</td>' +
                            '<td>' + indicators[i].tiempoIndicador + '</td>' +
                            '<td>' + indicators[i].origenIndicador + '</td>' +
                            '<td>' + showBtn + editBtn + deleteBtn + '</td>' +
                        '</tr>';
                        $("#indicators-table-body").append(indicatorRow);
                    }
     
                     
                },
                error: function(response) {
                    console.log(response.responseJSON)
                }
            });
        }

        /*
            Verificando si el formulario es de creacion o actualizacion
        */
        $("#save-indicator-btn").click(function(event ){
            event.preventDefault();
            if($("#update_id").val() == null || $("#update_id").val() == "")
            {
                storeIndicator();
            } else {
                updateIndicator();
            }
        })

        /*
            Creacion de registro
        */
        function createIndicator()
        {
            $("#alert-div").html("");
            $("#error-div").html("");   
            $("#update_id").val("");
            $("#nombreIndicador").val("");
            $("#codigoIndicador").val("");
            $("#unidadMedidaIndicador").val("");
            $("#valorIndicador").val("");
            $("#fechaIndicador").val("");
            $("#tiempoIndicador").val("");
            $("#origenIndicador").val("");
            $("#form-modal").modal('show'); 
        }

        /*
            Guardar cambios y guardarlo en la Base de Datos
        */
        function storeIndicator()
        {   
            $("#save-indicator-btn").prop('disabled', true);
            let url = $('meta[name=app-url]').attr("content") + "/indicators";
            let data = {
                nombreIndicador: $("#nombreIndicador").val(),
                codigoIndicador: $("#codigoIndicador").val(),
                unidadMedidaIndicador: $("#unidadMedidaIndicador").val(),
                valorIndicador: $("#valorIndicador").val(),
                fechaIndicador: $("#fechaIndicador").val(),
                tiempoIndicador: $("#tiempoIndicador").val(),
                origenIndicador: $("#origenIndicador").val(),
            };
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "POST",
                data: data,
                success: function(response) {
                    $("#save-indicator-btn").prop('disabled', false);
                    let successHtml = '<div class="alert alert-success" role="alert"><b>Registro creado satisfactoriamente</b></div>';
                    $("#alert-div").html(successHtml);
                    $("#nombreIndicador").val("");
                    $("#codigoIndicador").val("");
                    $("#unidadMedidaIndicador").val("");
                    $("#valorIndicador").val("");
                    $("#fechaIndicador").val("");
                    $("#tiempoIndicador").val("");
                    $("#origenIndicador").val("");
                    showAllIndicators();
                    $("#form-modal").modal('hide');
                },
                error: function(response) {
                    $("#save-indicator-btn").prop('disabled', false);
     
                    /*
        show validation error
                    */
                    if (typeof response.responseJSON.errors !== 'undefined') 
                    {
        let errors = response.responseJSON.errors;
        let origenIndicadorValidation = "";
        if (typeof errors.origenIndicador !== 'undefined') 
                        {
                            origenIndicadorValidation = '<li>' + errors.origenIndicador[0] + '</li>';
                        }

        let tiempoIndicadorValidation = "";
        if (typeof errors.tiempoIndicador !== 'undefined') 
                        {
                            tiempoIndicadorValidation = '<li>' + errors.tiempoIndicador[0] + '</li>';
                        }

        let fechaIndicadorValidation = "";
        if (typeof errors.fechaIndicador !== 'undefined') 
                        {
                            fechaIndicadorValidation = '<li>' + errors.fechaIndicador[0] + '</li>';
                        }

        let valorIndicadorValidation = "";
        if (typeof errors.valorIndicador !== 'undefined') 
                        {
                            valorIndicadorValidation = '<li>' + errors.valorIndicador[0] + '</li>';
                        }
        
        let unidadMedidaIndicadorValidation = "";
        if (typeof errors.unidadMedidaIndicador !== 'undefined') 
                        {
                            unidadMedidaIndicadorValidation = '<li>' + errors.unidadMedidaIndicador[0] + '</li>';
                        }

        let ccodigoIndicadorValidation = "";
        if (typeof errors.codigoIndicador !== 'undefined') 
                        {
                            codigoIndicadorValidation = '<li>' + errors.codigoIndicador[0] + '</li>';
                        }
                        
                        let nombreIndicadorValidation = "";
        if (typeof errors.nombreIndicador !== 'undefined') 
                        {
                            nombreIndicadorValidation = '<li>' + errors.nombreIndicador[0] + '</li>';
                        }
         
        let errorHtml = '<div class="alert alert-danger" role="alert">' +
            '<b>Validation Error!</b>' +
            '<ul>' + nombreIndicadorValidation + codigoIndicadorValidation + unidadMedidaIndicadorValidation + valorIndicadorValidation + fechaIndicadorValidation + tiempoIndicadorValidation + origenIndicadorValidation + '</ul>' +
        '</div>';
        $("#error-div").html(errorHtml);
    }
                }
            });
        }

         /*
            Editar registros
        */
        function editIndicator(id)
        {
            let url = $('meta[name=app-url]').attr("content") + "/indicators/" + id ;
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    let indicator = response.indicator;
                    $("#alert-div").html("");
                    $("#error-div").html("");   
                    $("#update_id").val(indicator.id);
                    $("#nombreIndicador").val(indicator.nombreIndicador);
                    $("#codigoIndicador").val(indicator.codigoIndicador);
                    $("#unidadMedidaIndicador").val(indicator.unidadMedidaIndicador);
                    $("#valorIndicador").val(indicator.valorIndicador);
                    $("#fechaIndicador").val(indicator.fechaIndicador);
                    $("#tiempoIndicador").val(indicator.tiempoIndicador);
                    $("#origenIndicador").val(indicator.origenIndicador);
                    $("#form-modal").modal('show'); 
                },
                error: function(response) {
                    console.log(response.responseJSON)
                }
            });
        }

        /*
            Guardar y actualizar los datos
        */
        function updateIndicator()
        {
            $("#save-indicator-btn").prop('disabled', true);
            let url = $('meta[name=app-url]').attr("content") + "/indicators/" + $("#update_id").val();
            let data = {
                id: $("#update_id").val(),
                nombreIndicador: $("#nombreIndicador").val(),
                codigoIndicador: $("#codigoIndicador").val(),
                unidadMedidaIndicador: $("#unidadMedidaIndicador").val(),
                valorIndicador: $("#valorIndicador").val(),
                fechaIndicador: $("#fechaIndicador").val(),
                tiempoIndicador: $("#tiempoIndicador").val(),
                origenIndicador: $("#origenIndicador").val(),
            };
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "PUT",
                data: data,
                success: function(response) {
                    $("#save-indicator-btn").prop('disabled', false);
                    let successHtml = '<div class="alert alert-success" role="alert"><b>Informacion actualizada satisfactoriamente</b></div>';
                    $("#alert-div").html(successHtml);
                    $("#nombreIndicador").val("");
                    $("#codigoIndicador").val("");
                    $("#unidadMedidaIndicador").val("");
                    $("#valorIndicador").val("");
                    $("#fechaIndicador").val("");
                    $("#tiempoIndicador").val("");
                    $("#origenIndicador").val("");
                    showAllIndicators();
                    $("#form-modal").modal('hide');
                },
                error: function(response) {
                    /*
        show validation error
                    */
                    $("#save-indicator-btn").prop('disabled', false);
                    if (typeof response.responseJSON.errors !== 'undefined') 
                    {
                        console.log(response)
        let errors = response.responseJSON.errors;

        let origenIndicadorValidation = "";
        if (typeof errors.origenIndicador !== 'undefined') 
                        {
                            origenIndicadorValidation = '<li>' + errors.origenIndicador[0] + '</li>';
                        }

        let tiempoIndicadorValidation = "";
        if (typeof errors.tiempoIndicador !== 'undefined') 
                        {
                            tiempoIndicadorValidation = '<li>' + errors.tiempoIndicador[0] + '</li>';
                        }

        let fechaIndicadorValidation = "";
        if (typeof errors.fechaIndicador !== 'undefined') 
                        {
                            fechaIndicadorValidation = '<li>' + errors.fechaIndicador[0] + '</li>';
                        }

        let valorIndicadorValidation = "";
        if (typeof errors.valorIndicador !== 'undefined') 
                        {
                            valorIndicadorValidation = '<li>' + errors.valorIndicador[0] + '</li>';
                        }

        let unidadMedidaIndicadorValidation = "";
        if (typeof errors.unidadMedidaIndicador !== 'undefined') 
                        {
                            unidadMedidaIndicadorValidation = '<li>' + errors.unidadMedidaIndicador[0] + '</li>';
                        }

        let codigoIndicadorValidation = "";
        if (typeof errors.codigoIndicador !== 'undefined') 
                        {
                            codigoIndicadorValidation = '<li>' + errors.codigoIndicador[0] + '</li>';
                        }

                        let nombreIndicadorValidation = "";
        if (typeof errors.nombreIndicador !== 'undefined') 
                        {
                            nombreIndicadorValidation = '<li>' + errors.nombreIndicador[0] + '</li>';
                        }
         
        let errorHtml = '<div class="alert alert-danger" role="alert">' +
            '<b>Validation Error!</b>' +
            '<ul>' + nombreIndicadorValidation + codigoIndicadorValidation + unidadMedidaIndicadorValidation + valorIndicadorValidation + fechaIndicadorValidation + tiempoIndicadorValidation + origenIndicadorValidation + '</ul>' +
        '</div>';
        $("#error-div").html(errorHtml);        
    }
                }
            });
        }

        /*
            Visualizar informacion
        */
        function showIndicator(id)
        {
            $("#nombreIndicador-info").html("");
            $("#codigoIndicador-info").html("");
            $("#unidadMedidaIndicador-info").html("");
            $("#valorIndicador-info").html("");
            $("#fechaIndicador-info").html("");
            $("#tiempoIndicador-info").html("");
            $("#origenIndicador-info").html("");
            let url = $('meta[name=app-url]').attr("content") + "/indicators/" + id +"";
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    let indicator = response.indicator;
                    $("#nombreIndicador-info").html(indicator.nombreIndicador);
    $("#codigoIndicador-info").html(indicator.codigoIndicador);
    $("#unidadMedidaIndicador-info").html(indicator.unidadMedidaIndicador);
    $("#valorIndicador-info").html(indicator.valorIndicador);
    $("#fechaIndicador-info").html(indicator.fechaIndicador);
    $("#tiempoIndicador-info").html(indicator.tiempoIndicador);
    $("#origenIndicador-info").html(indicator.origenIndicador);
    $("#view-modal").modal('show'); 
     
                },
                error: function(response) {
                    console.log(response.responseJSON)
                }
            });
        }

        /*
            Eliminar registro
        */
        function destroyIndicator(id)
        {
            let url = $('meta[name=app-url]').attr("content") + "/indicators/" + id;
            let data = {
                nombreIndicador: $("#nombreIndicador").val(),
                codigoIndicador: $("#codigoIndicador").val(),
                unidadMedidaIndicador: $("#unidadMedidaIndicador").val(),
                valorIndicador: $("#valorIndicador").val(),
                fechaIndicador: $("#fechaIndicador").val(),
                tiempoIndicador: $("#tiempoIndicador").val(),
                origenIndicador: $("#origenIndicador").val(),
            };
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "DELETE",
                data: data,
                success: function(response) {
                    let successHtml = '<div class="alert alert-success" role="alert"><b>Registro eliminado satisfactoriamente</b></div>';
                    $("#alert-div").html(successHtml);
                    showAllIndicators();
                },
                error: function(response) {
                    console.log(response.responseJSON)
                }
            });

        }

    </script>
    
</body>
</html>