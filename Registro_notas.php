<?php include('conexion.php')?>
<?php

  session_start();
 $user=$_SESSION['nomb_usuario'];
 



  $objconexion= new Conexion();
  $nombreC=$_SESSION['nomb_curso'];
  $año=$_SESSION['periodo'];
  $periodo=$_SESSION['año'];


//Nota
$sqlnota ="SELECT * from notas";
$consultaN= $objconexion->consultar($sqlnota);

//Calificaciones
$nota=$_GET['nota'];
$sqlcal ="SELECT * FROM calificaciones ORDER BY nota,cod_est";
$consultaC= $objconexion->consultar($sqlcal);

//Estudiante
$sql = "SELECT e.cod_est, e.nomb_est FROM cursos c, docentes d, inscripciones i, estudiantes e WHERE c.cod_doc=d.cod_doc
AND c.cod_cur=i.cod_cur AND i.cod_est=e.cod_est AND d.nomb_doc='$user' AND i.year='$año' AND i.periodo='$periodo' AND c.nomb_cur='$nombreC'";
$consulta =  $objconexion->consultar($sql);

$cod_est = $consulta['cod_est'];

// obtener las variables
$Nom_notas=($_GET['Nom_notas']);
$por_notas=($_GET['por_notas']);
$Nota=($_GET['nota']);

if(isset($_POST['subir_notas']))
{
  
  $valor=$_POST['valor'];
  $Nota=$_POST['nota'];
  $cod_est=$_POST['est'];
  
  $cons_cod_cur = "SELECT c.cod_cur FROM docentes d, cursos c WHERE c.cod_doc=d.cod_doc AND nomb_doc='$user'"; 
    
    $co_cod_cur= $objconexion->consultar($cons_cod_cur);
    
    foreach ($co_cod_cur as $proyecto) {
      $cod_cur= $proyecto['cod_cur'];
   }

   $i = 0;
  //recorre todas las notas

   

  foreach ($valor as $valor){
    echo'no ha insertado';

    $insertarnota="INSERT INTO calificaciones(nota, valor, fecha, cod_cur, cod_est, year, periodo ) VALUES('$Nota', '$valor', CURRENT_TIMESTAMP,'$cod_cur' ,'$cod_est[$i]','$año','$periodo')";
    
      if($objconexion->ejecutar($insertarnota)){
        echo "year $año <br> id nota $Nota <br> periodo $periodo <br>  valor $valor <br> nombre curso $nombreC <br> codcur  $cod_cur  <br>  codest $cod_est[$i]  ";
        $insertarnota="INSERT INTO calificaciones(nota, valor, fecha, cod_cur, cod_est, year, periodo ) VALUES('$Nota', '$valor', CURRENT_TIMESTAMP,'$cod_cur' ,'$cod_est[$i]','$año','$periodo')";
      }
      else{
        $insertarnota = "UPDATE calificaciones SET valor = '$valor' where cod_est = $cod_est[$i]";
        echo"hago update";
      }
    
    $objconexion->ejecutar($insertarnota);
    echo'ya inserto';
    $i++;
  }
  
  
  
  
  
  $insertarnota="INSERT INTO calificaciones(nota, valor, fecha, cod_cur, cod_est, year, periodo ) VALUES('$nota', '$valor', CURRENT_TIMESTAMP,'$cod_cur','$codigo' ,'$año','$periodo') 
  ON DUPLICATE KEY UPDATE SET valor = '$valor'";
  $objconexion->ejecutar($insertarnota);
  echo'ya inserto';
}

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

  </head>
  <body>
     <?php

  echo $Nota;
// crear las variables de Consolidado_notas.php


      ?>
  <div class="container">

    <div class="row">

         <div class="col">
        
         </div>
         <div class="col-10"> 
            <table class="table">
             <thead>
            
                 <tr>
                    <th>                        
                        <label for="Descripcion" class="col-form-label">Descripcion:</label>
                        <?php echo "$Nom_notas";?>
                    </th>

                    <th> 
                        <label for="Porcentaje" class="col-form-label">Porcentaje:</label>
                        <?php echo "$por_notas";?>&nbsp;%

                    </th>

                 </tr>
             </thead>
             <tbody>
            </tbody>
          </table>    
         </div>
         <div class="col-10"> 
            <table class="table">
             <thead>
            
                 <tr>
                     <th>Codigo</th>
                     <th>Nombre</th>
                     <th>Nota</th>
                 </tr>
             </thead>
             <tbody>
                      <form action = "Registro_notas.php" method = "post" >
                        <?php $i=1;
                          $nombre_nota=$Nom_notas;
                          echo $nombre_nota;?>
                        <?php foreach($consulta as $proyecto) { ?>
                        <tr>
                            
                                <td><?php echo $proyecto['cod_est']; $codigo=$proyecto['cod_est'];?>
                                <input type="hidden" name= 'est[]' value = <?php echo $proyecto['cod_est']; ?>>

                                  </td>
                                <td><?php echo $proyecto['nomb_est'];?></td>
                                <td>
                                  <?php
                                    foreach($consultaC as $proyecto){
                                      if($codigo==$proyecto['cod_est'] AND ($Nota==$proyecto['nota'])){
                                        $Notas=$proyecto['valor'];
                                      } 
    
                                      
                                    $N++;}
                                    ?>
                                  
                                      <input type="number" name='valor[]' min="0" max="5" step="0.01" value=<?php echo $Notas; ?>>
                                      
                                      <input type="hidden" name= 'nota' value = <?php echo $Nota ?>>
                
                                      

                                </td>
                        </tr>
                        
                        <?php $i++; }?>
                    
              </tbody>
          </table>   
                    <button class="btn btn-primary" name='subir_notas' type="submit" >Subir Notas</button>
         </div>
         </form>
         <div class="col">
                
         </div>

    </div>

  </div>
     

    
 </body>
</html>


<?php


?>