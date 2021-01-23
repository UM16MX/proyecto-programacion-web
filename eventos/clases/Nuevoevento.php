<?php
class Nuevoevento extends Conexion
{
   function setEvento($id,$fec_res,$desde,$hasta,$personas,$comentarios,$fecha)
   {
    $mysqli = $this->fullConnect();
    $query="INSERT INTO eventos VALUES (?,?,?,?,?,?,?,1)";
    if ($stmt = $mysqli->prepare($query)) 
    {
     $stmt->bind_param('ssssiss', $id,$fec_res,$desde,$hasta,$personas,$comentarios,$fecha);
       if ($stmt->execute())
       {
          $stmt->free_result();
          $stmt->close();
            return true;
       }
       else
       {
          $stmt->close();
           return false;
       }
  
    }
   }   

}


?>