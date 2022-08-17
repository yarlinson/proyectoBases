<?php include("conexion.php");?>

<!doctype html>
<html lang="en">
  <head>
    <title>Registro</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.0-beta1 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"  integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

  </head>
  <body>
     <form action="Registro.php" method="post">

        <div class="container">
        <button class="btn btn-success" type="submit" onclick="history.back()">Volver</button>
             <div class="row">
                 <div class="col-md-4">
                    

                 </div>
                 <div class="col-md-4">
                    
                   <div class="card">
                    <div class="card-header">
                        Registro 
                    </div>
                    <div class="card-body">
                       usuario: <input class="form-control" type="text" name="usu" id="">
                        <br>
                       contraseña: <input class="form-control" type="password" name="cont" id="">
                        <br>
                        <button class="btn btn-success" type="submit">Crear</button>
                    </div>
                    <div class="card-footer text-muted">
                    </div>
                   </div>
                 </div>
                 <div class="col-md-4">
                 </div>
            </div>
     </form>
  </body>
</html>

<?php
if($_POST)
{
echo "REGISTRO";
$usuario=$_POST["usu"];
$contraseña=$_POST["cont"];

$objconexion= new Conexion();
$sql = "INSERT INTO docentes(nomb_doc,clave) VALUES ('$usuario','$contraseña')";
$objconexion->ejecutar($sql);

header('location:login.php');
}
?>