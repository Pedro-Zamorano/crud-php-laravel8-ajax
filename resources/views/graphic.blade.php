<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gráfico PHP - Laravel - Ajax</title>
    <meta charset="UTF-8">    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
</head>
<body>

    <div class="container">

        <h2 class="text-center mt-5 mb-3">Gráfico PHP - Laravel 8 - Ajax</h2>

        <div class="card">

            <div class="card-header">
                
                <a href="/" class="btn btn-success">CRUD</a>

            </div>

            <div class="card-body">     
                
                <!--Comienzo-->
                <form class="form-inline"  method="POST"  name="formFechas" id="formFechas">

                    <div class="col-xs-10 col-xs-offset-3">

                        <div class="form-group">
                            <label for="fecha_inicio">Fecha Inicial:</label>
                            <input type="date" class="form-control" name="fecha_inicio" required>
                        </div>

                        <div class="form-group mt-3">
                            <label for="fecha_final">Fecha Final:</label>
                            <input type="date" class="form-control" name="fecha_final" required>
                        </div>

                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary">Aplicar</button>
                        </div>
                    </div>

                </form>
                
                <br><br>
                
                <section id="tabla_resultado">
                    <h1>RESULTADO</h1>
                <!-- AQUI SE DESPLEGARA NUESTRA TABLA DE CONSULTA -->
                </section>
                <!--Final-->

            </div>

        </div>

    </div><!-- Fin container -->

    <script type="text/javascript">

    </script>
    
</body>
</html>

