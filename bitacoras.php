<?php include('conexion.php')?>
<?php

  session_start();
 $user=$_SESSION['nomb_usuario'];
 //echo "HOLA $user";


  $objconexion= new Conexion();
  $nombreC=$_SESSION['nomb_curso'];
  $año=$_SESSION['periodo'];
  $periodo=$_SESSION['año'];

 $sql1 = "SELECT * FROM eventosestudiantes";
 $consultaevees =  $objconexion->consultar($sql1);

 $sql2 = "SELECT * FROM eventosnotas";
 $consultaevenot =  $objconexion->consultar($sql2);
 
?>

<!doctype html>
<html lang="en">
<head>
    <title>Bitagoras</title>
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
    

  

<div class = "top">
  <h1>Bitacoras</h1>
  &nbsp;
</div>
   
  <div class="container">
  <button class="btn btn-success" type="submit" onclick="location.href = 'Seleccion.php'">Volver</button>
    <div class="row">
         <div class="col">
        
         </div>

         <div class="col-10" >   


          <h1 align='center'>Bitacora de estudiantes</h1>
            
            <table class="table">
             <thead>
            
                 <tr>
                     <th>Fecha</th>
                     <th>Codigo</th>
                     <th>Nombre</th>
                     <th>Comando</th>
                 </tr>
             </thead>
             <tbody>
                 <?php $i=1;?>
                 <?php foreach($consultaevees as $proyecto) { ?>
                 <tr>
                     <td><?php echo $proyecto['timestamp_'];?></td>
                     <td><?php echo $proyecto['cod_est'];?></td>
                     <td><?php echo $proyecto['nomb_est'];?></td>
                     <td><?php echo $proyecto['comando']; ?></td>
                  </tr>
                 <?php }?>
              </tbody>
          </table>  
          
          <h1 align='center'>Bitacora de notas</h1>
            
            <table class="table">
             <thead>
            
                 <tr>
                     <th>Fecha</th>
                     <th>Codigo</th>
                     <th>Descripcion</th>
                     <th>porcentaje</th>
                     <th>Comando</th>
                 </tr>
             </thead>
             <tbody>
                 <?php ?>
                 <?php foreach($consultaevenot as $proyecto) { ?>
                 <tr>
                     <td><?php echo $proyecto['timestamp_'];?></td>
                     <td><?php echo $proyecto['nota'];?></td>
                     <td><?php echo $proyecto['desc_nota'];?></td>
                     <td><?php echo $proyecto['porcentaje'];?></td>
                     <td><?php echo $proyecto['comando']; ?></td>
                  </tr>
                 <?php }?>
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