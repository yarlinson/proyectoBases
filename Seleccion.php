<?php include("conexion.php");?>
<?php
 session_start();
 $user=$_SESSION['nomb_usuario'];
 //echo "hola  $user";
 $objconexion= new Conexion();
 $sqlyear = "SELECT distinct   i.year FROM cursos c, docentes d, inscripciones i, estudiantes e WHERE c.cod_doc=d.cod_doc AND c.cod_cur=i.cod_cur AND i.cod_est=e.cod_est AND d.nomb_doc='$user'";
 $consultayear =  $objconexion->consultar($sqlyear);

 $sqlcurso = "SELECT distinct   c.nomb_cur FROM cursos c, docentes d, inscripciones i, estudiantes e WHERE c.cod_doc=d.cod_doc AND c.cod_cur=i.cod_cur AND i.cod_est=e.cod_est AND d.nomb_doc='$user'";
 $consultacurso =  $objconexion->consultar($sqlcurso);

 $sqlperiodo = "SELECT distinct   i.periodo FROM cursos c, docentes d, inscripciones i, estudiantes e WHERE c.cod_doc=d.cod_doc AND c.cod_cur=i.cod_cur AND i.cod_est=e.cod_est AND d.nomb_doc='$user'";
 $consultaperiodo =  $objconexion->consultar($sqlperiodo);
?>


<!doctype html>
<html lang="en">
  <head>
    <title>Registro</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.0-beta1 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"  integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <style>
      .top{
        display: flex;
        justify-content: center;
        background: #1e1e21;
        border-color: #252529;
        color: #aaaab3;
      }
      .card{
        color: #FFFF;
        background-color: #282828;
        border-color: #252529;
        border-radius: 20px;
      }
      .dark{
        background: #3b3b41;
        border-color: #3b3b41;
        color: white;
        position: relative;
        padding-bottom: 150px;
        min-height: 100vh;
      }
      .creditos{
        position: absolute;
        bottom: 0;
        width: 100%;
        text-align: center;
        padding: 20px;
        background: #1e1e21;
        border-color: #252529;
        color: #aaaab3;
      }
      .boton{
        float: right;
      }
      .card-footer{
        color: white;
      }
      </style>
  </head>

  <body class = "dark">
  <div class = "top">
  <h1>Seleccion de cursos</h1>
  &nbsp;
</div>

     
        <div class="container">
        <button class="btn btn-success" type="submit" onclick="location.href = 'login.php'">Volver</button>
        <form action="Seleccion.php" method="post">
             <div class="row">
                 <div class="col-md-4">
                    

                 </div>
                 <div class="col-md-4">
                    
                   <div class="card">
                    <div class="card-header">
                        Seleccion
                    </div>
                    <div class="card-body">
                       <br>
                        Curso:
                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="idcurso" id="">

                        <?php
                        foreach ($consultacurso as $proyecto) {
                        ?>
                        <option value="<?php echo $proyecto['nomb_cur']; ?>"> <?php echo $proyecto['nomb_cur']; ?> </option>     
                        <?php }?>
                       </select>
                       <br>

                       Año:

                       <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="idyear" id="">

                        <?php
                        foreach ($consultayear as $proyecto) {
                        ?>
                        <option value="<?php echo $proyecto['year']; ?>"> <?php echo $proyecto['year']; ?> </option>     
                        <?php }?>
                       </select>
                       <br>

                       Periodo:

                       <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="idperiodo" id="">

                        <?php
                        foreach ($consultaperiodo as $proyecto) {
                        ?>
                        <option value="<?php echo $proyecto['periodo']; ?>"> <?php echo $proyecto['periodo'];?> </option>     
                        <?php }?>
                       </select>
                       <br>
                        <button class="btn btn-success" type="submit" >Ver Listado</button>
                        <a class="btn btn-success" href="Listado_notas.php">Ver notas</a>
                        <a class="btn btn-success" href="bitagoras.php">Ver bitagoras</a>
                        
                    </div>
                    
                   </div>
                 </div>
                 <div class="col-md-4">
                 </div>
            </div>
            </div>
            </form>
          </body>
        
        <footer class="creditos">
  <p1>Elaborado por:<br>
    YARLINSON BARRANCO 160004501<br>
    KEVIN OSMA 160004527<br>
    JIMMY CLAVIJO  160004508<br> 
  </p1>
  </footer>
</html>

<?php
  if($_POST)

  {
    session_start();

    $user=$_SESSION['nomb_usuario'];
    echo "HOLA $user";


    $objconexion= new Conexion();

    $objconexion->Guardado($_POST['idcurso'],$_POST['idyear'],$periodo=$_POST['idperiodo']);

    header('location:Listado.php');

  }
?>

