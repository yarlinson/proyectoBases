<?php include('conexion.php')?>
<?php

  session_start();
 $user=$_SESSION['nomb_usuario'];
 //echo "HOLA $user";


  $objconexion= new Conexion();
  $nombreC=$_SESSION['nomb_curso'];
  $año=$_SESSION['periodo'];
  $periodo=$_SESSION['año'];

  if($_POST)
  {
    $nomb_est=$_POST['nomb_est'];
  
    
    $insertarest="INSERT INTO estudiantes(nomb_est) VALUES('$nomb_est')";
    $objconexion->ejecutar($insertarest);
  
    $cons_cod_cur = "SELECT c.cod_cur FROM docentes d, cursos c WHERE c.cod_doc=d.cod_doc AND nomb_doc='$user'"; 
    $co_cod_cur= $objconexion->consultar($cons_cod_cur);
  
    foreach ($co_cod_cur as $proyecto) {
       $cod_cur= $proyecto['cod_cur'];
    }
  
    //echo $cod_cur;
  
    $cons_cod_est = "SELECT cod_est FROM estudiantes  WHERE   nomb_est='$nomb_est'"; 
    $co_cod_est= $objconexion->consultar($cons_cod_est);
  
    foreach ($co_cod_est as $proyecto) {
      $cod_est= $proyecto['cod_est'];
   }
  
   //echo $cod_est;
   
     
    $insertarins="INSERT INTO inscripciones VALUES('$cod_cur','$cod_est','$año','$periodo')" ;
    $objconexion->ejecutar($insertarins);
  }
  

  if($_GET)
{
  $id=$_GET['borrar'];
  $sqlb="DELETE FROM estudiantes WHERE cod_est ='$id'";
  $objconexion->ejecutar($sqlb);
}

 $sql = "SELECT e.cod_est, e.nomb_est FROM cursos c, docentes d, inscripciones i, estudiantes e WHERE c.cod_doc=d.cod_doc
  AND c.cod_cur=i.cod_cur AND i.cod_est=e.cod_est AND d.nomb_doc='$user' AND i.year='$año' AND i.periodo='$periodo' AND c.nomb_cur='$nombreC'";
  $consulta =  $objconexion->consultar($sql);
?>

<!doctype html>
<html lang="en">
<head>
    <title>Seleccion</title>
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
      .table{
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
        bottom: 0px;
        width: 100%;
        text-align: center;
        padding: 20px;
        background: #1e1e21;
        border-color: #252529;
        color: #aaaab3;
        
      }
    </style>

  </head>
  <body class="dark">
    
  <!-- modal editar -->
  <div class="modal fade" id="modalañadir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          
        </button>
      </div>
      <div id = "form_editar">
         <div class="modal-body">
             
             <div class="form-group">
             <form id="formnombre" action="Listado.php" method="post">
                <label for="nomb_est" class="col-form-label">Nombre del estudiante:</label>
                <input type="text" class="form-control" name = "nomb_est" id="descripcion" >
             </div>
                
              </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button   id = 'btnaceptar' name = "editar" class="btn btn-primary" type="submit">Aceptar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class = "top">
  <h1>Lista de estudiantes</h1>
  &nbsp;
</div>
   
  <div class="container">
  <button class="btn btn-success" type="submit" onclick="location.href = 'Seleccion.php'">Volver</button>
  <a id= bt_añadir class="btn btn-success" data-bs-toggle="modal" >Añadir</a>
    <div class="row">
         <div class="col">
        
         </div>

         <div class="col-10"> 
            <table class="table">
             <thead>
            
                 <tr>
                     <th>N</th>
                     <th>Nombre</th>
                     <th>Codigo</th>
                     <th>Acciones</th>
                 </tr>
             </thead>
             <tbody>
                 <?php $i=1;?>
                 <?php foreach($consulta as $proyecto) { ?>
                 <tr>
                     <td><?php echo $i;?></td>
                     <td><?php echo $proyecto['nomb_est'];?></td>
                     <td><?php echo $proyecto['cod_est'];?></td>
                     <td> <a class="btn btn-danger" href="?borrar=<?php echo $proyecto['cod_est'];?>">Eliminar</a></td>
                  </tr>
                 <?php $i++; }?>
              </tbody>
          </table>    
         </div>

         

    </div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <!-- jQuery, Popper.js, Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="popper/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
      
    <!-- datatables JS -->
    <script type="text/javascript" src="datatables/datatables.min.js"></script>    
     
    <script type="text/javascript" src="main2.js"></script>
    
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
?>