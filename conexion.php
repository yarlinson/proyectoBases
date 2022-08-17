<?php

class Conexion{
    public $host="localhost";
    public $dbname="notas";
    public $port="5432";
    public $user="postgres";
    public $password="postgres";
    public $driver = "pgsql";
    public $conexion;
    
   public  function __construct()
   {
     try {
       
        $this->conexion = new PDO("{$this->driver}:host={$this->host};port={$this->port};
        dbname={$this->dbname}", $this->user, $this->password);
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$this->conexion;
        //echo "this succes";
        
     } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
     }
   }

   public function ejecutar($sql){ //se puede agregar, borrar y cambiar
    $this->conexion->exec($sql);
    return $this->conexion->last;
   }

   public function consultar($sql){
      $setencia=$this->conexion->prepare($sql);
      $setencia->execute();
      return $setencia->fetchAll();
   }



   function Guardado($nombc, $perio, $año)
   {
      session_start();
      $_SESSION['nomb_curso']=$nombc;
      $_SESSION['periodo']=$perio;
      $_SESSION['año']=$año;      
   }

}
?>
