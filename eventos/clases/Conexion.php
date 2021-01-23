<?php
class Conexion
{
   private $link;
 function getLink()
 {
   $token = 'prueba';
   $server = 'localhost';
   $user = 'root';
   $pass = 'cuenta12';
   $this->link=new mysqli($server, $user, $pass, $token);
   $this->link->autocommit(FALSE);
   if (mysqli_connect_errno ())
      return null;
   else
   {
      $this->link->autocommit(FALSE);
      return $this->link;
   }
 }
 function cerrarConexion()
 {
   mysqli_close($this->link);
 }
 function rollback()
 {
   mysqli_rollback($this->link);
 }
 function commit()
 {
   mysqli_commit($this->link);
 }
 function fullConnect()
 {
    $mysqli = $this->conexion = $this->getLink();
      return $mysqli;
 }
 function flexibleSingleBind($sql,$val,$val2,$val3,$val4,$params,$vars)
 {
  $mysqli = $this->fullConnect();
   if ($stmt = $mysqli->prepare($sql))
   {
        if($vars == 1)
            $stmt->bind_param($params, $val);
        if($vars == 2)
            $stmt->bind_param($params, $val, $val2);
        if($vars == 3)
            $stmt->bind_param($params, $val, $val2, $val3);
        if($vars == 4)
            $stmt->bind_param($params, $val, $val2, $val3, $val4);
            $stmt->execute();
            $stmt->bind_result($resultado);
            $stmt->fetch();
            $stmt->close();
            return $resultado;
   }
   else
        return false;
 }
}
?>
