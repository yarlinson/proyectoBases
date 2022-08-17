<?php include("conexion.php");?>



<!doctype html>
<html lang="en">
  <head>
    <title>Login</title>
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
  <h1>Iniciar sesion</h1>
  &nbsp;
</div>
&nbsp;

        <div class="container">
        <button class="btn btn-success" type="submit" onclick="history.back()">Volver</button>
             <div class="row">
                 <div class="col-md-4">
                    

                 </div>
                 <div class="col-md-4">

                   <div class="card">
                    <div class="card-header">
                        Login 
                    </div>
                    <div class="card-body">
                    <form action="login.php" method="post">
                       usuario: <input class="form-control" type="text" name="usu" id="">
                        <br>
                       contraseña: <input class="form-control" type="password" name="cont" id="">
                        <br>
                        <button class="btn btn-success" type="submit">Entrar</button>
                    </form>
                    
                    
                    </div>
                    <div class="card-footer">
                    <form action="login.php">
                    <a float = "left" >Nuevo usuario</a>
                      <div class = "boton">
                    <button class="btn btn-success" type="submit" formaction="Registro.php">Registrar</button>
                      </div>
                    </form>
                    </div>
                   </div>
                 </div>
                 
            </div>
    </div>
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


  $usuario=$_POST["usu"];
  $contraseña=$_POST["cont"];

  $objconexion= new Conexion();
  $sql = "SELECT * FROM docentes WHERE nomb_doc='$usuario' AND clave='$contraseña'";
  $consulta =  $objconexion->consultar($sql);
  print_r($consulta);
  $cantidad = count($consulta);
  echo "la cantidad es de $cantidad";

  if($cantidad>0){
    $_SESSION['nomb_usuario']=$usuario;
    header('location:Seleccion.php');
  }

  else {
     echo "Usuario no existe";
  }

  }
?>