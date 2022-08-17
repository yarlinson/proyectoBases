<?php include('conexion.php')?>
<?php

  session_start();
 $user=$_SESSION['nomb_usuario'];
 echo "HOLA $user";



  $objconexion= new Conexion();
  $nombreC=$_SESSION['nomb_curso'];
  $año=$_SESSION['periodo'];
  $periodo=$_SESSION['año'];

//Nota
$sqlnota ="SELECT * from notas";
$consultaN= $objconexion->consultar($sqlnota);
    $calificacion=$_GET['array'];


//Calificaciones
$sqlcal ="SELECT * FROM calificaciones ORDER BY nota,cod_est";
$consultaC= $objconexion->consultar($sqlcal);
//calificacion est-nota


//Estudiantes 
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

  </head>
  <body>
    <?php 
    $comprobar=$_GET['nombre_nota'];
    echo $comprobar;
    
    ?>
  <div class="container">

    <div class="row">


         <div class="col-10"> 
            <table class="table">
             <thead>
            
                 <tr>
                     <th rowspan="2" style="text-align:center" valign="middle">Codigo</th>
                        <?php $i=0;$t_notas=0;?>
                        <?php foreach($consultaN as $proyecto) { ?>
                            <th>
                                <?php 
                                
                                echo $proyecto['desc_nota'];
                                $t_notas++;?>
                            </th>
                            
                        <?php $i++; }?>
                     <th>Definitiva</th>
                 </tr>
                 <tr>
                    <?php $i=0;
                    foreach($consultaN as $proyecto) { ?>
                        <th>
                            <?php echo $proyecto['porcentaje'];?>&nbsp;%
                            <?php 
                              $por_definitiva= $por_definitiva+$proyecto['porcentaje'];
                              $porcentajes[]=$proyecto['porcentaje'];?>
                        </th>
                    <?php $i++; }?>
                        <th>
                            <?php
                            echo $por_definitiva ;
                            ?>&nbsp;%
                        </th>

                     
                </tr>
             </thead>
             <tbody>
                 <?php $i=0; $f=0;
                 $N_estudiantes=1?>
                 <?php foreach($consulta as $proyecto) { $N=1;?>
                 <tr>
                    <td><?php echo $proyecto['cod_est'];
                        $codigo=$proyecto['cod_est'];
                        ?>
                        
                    </td>
                    <?php 
                        for($t=1;$t<=$t_notas ;$t++)
                          {
                    ?>
                      <td>
                        <?php 
                        foreach($consultaC as $proyecto){
                          
                          if($codigo==$proyecto['cod_est']AND $t==$proyecto['nota']){
                            echo $proyecto['valor'];
                         }
                          
                        $N++;}
                        ?>
                      </td>
                    <?php }

                    //Toma de la definitiva---------------------------------> ?>
                    <td>
                      <?php 
                        
                        $definitiva=0; $def=0;
                        for($t=1;$t<=$t_notas ;$t++)
                        {
                          foreach($consultaC as $proyecto){
                          
                            if($codigo==$proyecto['cod_est']AND $t==$proyecto['nota']){
                              $definitiva=$definitiva+($proyecto['valor']*($porcentajes[$def]/100));
                            }
                          } 
                        $def++;}echo $definitiva;?>&nbsp;<?php
                      ?>
                    </td>
                  </tr>
                 <?php $i++; $N_estudiantes++;}?>
                 
              </tbody>
          </table>  



         </div>

         <div class="col">
         
         </div>

    </div>

  </div>
 
    
 </body>
</html>
