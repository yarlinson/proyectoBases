<?php include('conexion.php')?>

<?php

  session_start();
 $user=$_SESSION['nomb_usuario'];
 //echo "HOLA $user";


  $objconexion= new Conexion();
  $nombreC=$_SESSION['nomb_curso'];
  $año=$_SESSION['periodo'];
  $periodo=$_SESSION['año'];
  $a=1;
  $porcentajefinal=0;
  

  if(isset($_POST['añadir']))
  {
    
    $descripcion=$_POST['desc'];
    $porcentaje = $_POST['porc'];
    $id = $_POST['pos'];
    
    $cons_cod_cur = "SELECT c.cod_cur FROM docentes d, cursos c WHERE c.cod_doc=d.cod_doc AND nomb_doc='$user' AND nomb_cur='$nombreC'"; 
    
    $co_cod_cur= $objconexion->consultar($cons_cod_cur);
    
    foreach ($co_cod_cur as $proyecto) {
      $cod_cur= $proyecto['cod_cur'];
   }
   
    $insertarnota="INSERT INTO notas(desc_nota, porcentaje, posicion,cod_cur) VALUES('$descripcion', '$porcentaje', '$id','$cod_cur')";
    $objconexion->ejecutar($insertarnota);

    $p1=1;
    $sqlconsulta_notas = "SELECT n.porcentaje FROM docentes d, cursos c, notas n WHERE c.cod_doc=d.cod_doc AND c.cod_cur=n.cod_cur AND d.nomb_doc='$user' AND c.cod_cur='$cod_cur'";
    $consulta_notas= $objconexion->consultar($sqlconsulta_notas);
    $cantporcentaje= count($consulta_notas);
  
    
    foreach ($consulta_notas as  $value) {
       $porce[$p1]=$value['porcentaje'];
       $p1++;
    }

    for ($i=1; $i<=$cantporcentaje ; $i++) {
      $porcentajefinal=$porce[$i]+$porcentajefinal;  
    }

    if ($porcentajefinal>100) {
      $sqlb="DELETE FROM notas where posicion = $id ";
      $objconexion->ejecutar($sqlb);
      echo '<script language="javascript">alert("Porcentaje invalido... Supera el 100 %");</script>';
      $a=0;
    }
    else{$a=1;}
    
  }
  else if(isset($_POST['editar'])){

    $desc_nota=$_POST['desc'];
    $porcentaje = $_POST['porc'];
    $pos = $_POST['pos'];
   
    
    $cons_cod_cur = "SELECT c.cod_cur FROM docentes d, cursos c WHERE c.cod_doc=d.cod_doc AND nomb_doc='$user' AND nomb_cur='$nombreC'"; 
    
    $co_cod_cur= $objconexion->consultar($cons_cod_cur);
    
    foreach ($co_cod_cur as $proyecto) {
      $cod_cur= $proyecto['cod_cur'];
   }

   $p1=1;

   $sqlconsulta_notas = "SELECT n.porcentaje FROM docentes d, cursos c, notas n WHERE c.cod_doc=d.cod_doc AND c.cod_cur=n.cod_cur AND d.nomb_doc='$user' AND c.cod_cur='$cod_cur'";
   $consulta_notas= $objconexion->consultar($sqlconsulta_notas);
   $cantporcentaje= count($consulta_notas);
 
   
   foreach ($consulta_notas as  $value) {
      $porce[$p1]=$value['porcentaje'];
      $p1++;
   }

   for ($i=1; $i<=$cantporcentaje ; $i++) {
    if($pos!=$i)
    {
     $porcentajefinal=$porce[$i]+$porcentajefinal;
    }  
   }
    $porcentajefinal=$porcentajefinal+$porcentaje;

   if ($porcentajefinal<100) {
    
     $actualizar_nota="UPDATE notas SET porcentaje = '$porcentaje' , desc_nota = '$desc_nota' WHERE posicion = '$pos'";
     $objconexion->ejecutar($actualizar_nota);
     $a=0;
   }
   else{echo '<script language="javascript">alert("Porcentaje invalido... Supera el 100 %");</script>';}
  
  }


  if($_GET)
{
  $id=$_GET['borrar'];
  $sqlb="DELETE FROM notas where posicion = $id ";
  $objconexion->ejecutar($sqlb);

}

 $sql = "SELECT * from notas ORDER BY posicion";
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
  <div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
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
                <form action="Listado_notas.php" method="post">
                  <label for="Posicion" class="col-form-label">Posicion:</label>
                  <input type="number" class="form-control" name = "pos" id="posicion" min = 0 max=20 >
             </div>
             <div class="form-group">
                <label for="Descripcion" class="col-form-label">Descripcion:</label>
                <input type="text" class="form-control" name = "desc" id="descripcion" >
             </div>
                <div class="form-group"> 
                  <label for="Porcentaje" class="col-form-label">Porcentaje:</label>
                  <input type="number" class="form-control" name = "porc" id="porcentaje" min = 0 max=100 >
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

<!-- modal añadir -->
<div class="modal fade" id="modal_añadir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
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
        <form id= "formnotas" action="Listado_notas.php" method="post">
            <label for="Posicion" class="col-form-label">Posicion:</label>
            <input type="number" class="form-control" name = "pos" id="posicion" min = 0 max=20 >
      </div>
      <div class="form-group">
            <label for="Descripcion" class="col-form-label">Descripcion:</label>
            <input type="text" class="form-control" name = "desc" id="descripcion" >
      </div>
      <div class="form-group"> 
            <label for="Porcentaje" class="col-form-label">Porcentaje:</label>
            <input type="number" class="form-control" name = "porc" id="porcentaje" min =0 max=100 >
            <?php 

            ?>  

      </div>
    </div>
  </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      <button   id = 'btnaceptar' name = "añadir" class="btn btn-primary" type="submit">Aceptar</button>
</form>
    </div>
    </div>
  </div>
</div>

<div class = "top">
  <h1>Lista de notas</h1>
  &nbsp;
</div>

  <div class="container">
  <button class="btn btn-success" type="submit" onclick="location.href = 'Seleccion.php'">Volver</button>
  <a id= btnañadir class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal_añadir">Añadir</a>
    <div class="row">

         <div class="col">
        
         </div>

         <div class="col-10"> 
            <table class="table">
             <thead>
             
                 <tr>
                     <th>Posición</th>
                     <th>Descripción</th>
                     <th>Porcentaje</th>
                     <th>Editar</th>
                     <th>Borrar</th>
                     <th>Registar</th>
                 </tr>
             </thead>

             <tbody>
              <form action="Consolidado_notas.php" method="post">
                 <?php $i=1;
                  $Porcentaje_T="0";
                  $T_porciento=0;?>
                 <?php foreach($consulta as $proyecto) { ?>
                 <tr>
                      <td><?php echo $proyecto['posicion'];?></td>
                      <td><?php echo $proyecto['desc_nota'];?></td>
                      <td ><?php echo $proyecto['porcentaje'];?>%</td>
                 
                     <td> <a id= btneditar class="btn btn-success" data-bs-toggle="modal" >Editar</a></td>
                     <td> <a class="btn btn-danger" href="?borrar=<?php echo $proyecto['posicion'];?>">Eliminar</a></td>
                     <td> 
                        
                        <a class="btn btn-Primary" href="Registro_notas.php?Nom_notas=<?php echo $proyecto['desc_nota'];?>&por_notas=<?php echo $proyecto['porcentaje'];?>">Registrar</a>
                        
                      </td>
                  </tr>
                  <?php $i++;
                  if($a=0){}
                }?>
                 </form>
              </tbody>
          </table> 
           
         </div>

         <div class="col">
        
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
     
    <script type="text/javascript" src="main.js"></script>
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