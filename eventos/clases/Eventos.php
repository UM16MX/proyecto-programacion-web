<?php
class Eventos extends Conexion{
  function __construct(){

  }
  function getEventos()
  {
   //$paginador = ' ORDER BY rank DESC LIMIT '.$paginador.' , '.$this->paginador;
   $listado = array();
   $mysqli = $this->fullConnect();
   $query = 'SELECT id,fec_res,desde,hasta,personas,comentarios,fecha,estatus FROM eventos ';
   if ($stmt = $mysqli->prepare($query))
   {
     if ($stmt->execute())
      $stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8);
       while ($stmt->fetch())
       {
         $registro['id'] = $col1;
         $registro['fec_res'] = $col2;
         $registro['desde'] = $col3;
         $registro['hasta'] = $col4;
         $registro['personas'] = $col5;
         $registro['comentarios'] = $col6;
         $registro['fecha'] = $col7;
         $registro['estatus'] = $col8;
         $listado[] = $registro;
       }
      $stmt->free_result();
      $stmt->close();
    return $listado;
   }
   else
    return $mysqli->error;
  }
 
  function getEventoId($id)
  {
   $listado = array();
   $registro['estatus'] = "error";
   $mysqli = $this->fullConnect();
   $query = 'SELECT id,fec_res,desde,hasta,personas,comentarios,fecha,estatus FROM eventos WHERE id = ?';
   if ($stmt = $mysqli->prepare($query))
   {
     $stmt->bind_param('s', $id);
     if ($stmt->execute())
      $stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8);
       while ($stmt->fetch())
       {
         $registro['id'] = $col1;
         $registro['fec_res'] = $col2;
         $registro['desde'] = $col3;
         $registro['hasta'] = $col4;
         $registro['personas'] = $col5;
         $registro['comentarios'] = $col6;
         $registro['fecha'] = $col7;
         $registro['estatus'] = $col8;
         $listado = $registro;
       }
      $stmt->free_result();
      $stmt->close();
    return $listado;
   }
   else
    return $mysqli->error;
  }

  function updEventoId($id,$fec_res,$desde,$hasta,$personas,$comentarios)
  {
   $mysqli = $this->fullConnect();
   $query="UPDATE eventos SET fec_res = ?, desde = ?, hasta = ?, personas = ?, comentarios = ? WHERE id = ?";
   if ($stmt = $mysqli->prepare($query))
   {
    $stmt->bind_param('sssiss', $fec_res,$desde,$hasta,$personas,$comentarios,$id);
      if ($stmt->execute())
      {
         $stmt->free_result();
         $stmt->close();
 
           return true;
      }
      else
      {
         $this->mysqlError = $stmt->error;
         $stmt->close();
          return false;
      }
   }
   else
   {
     $this->mysqlError = $mysqli->error;
      return false;
   }
  }
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
  function delEvento($id)
  {
   $mysqli = $this->fullConnect();
   $query="DELETE FROM eventos WHERE id = ?";
   if ($stmt = $mysqli->prepare($query))
   {
    $stmt->bind_param('s', $id);
      if ($stmt->execute())
      {
         $stmt->free_result();
         $stmt->close();
 
           return true;
      }
      else
      {
         $this->mysqlError = $stmt->error;
         $stmt->close();
          return false;
      }
   }
   else
   {
     $this->mysqlError = $mysqli->error;
      return false;
   }
  }

  function getBuscarEvento($cadena)
  {
   $cadena = '%'.$cadena.'%';
   $listado = array();
   $mysqli = $this->fullConnect();
   $query = 'SELECT id,fec_res,desde,hasta,personas,comentarios,fecha,estatus FROM eventos  WHERE (fec_res like ? )';
    if ($stmt = $mysqli->prepare($query))
    {
     $stmt->bind_param('s',$cadena);
     if ($stmt->execute())
     $stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8);
      while ($stmt->fetch())
      {
        $registro['id'] = $col1;
        $registro['fec_res'] = $col2;
        $registro['desde'] = $col3;
        $registro['hasta'] = $col4;
        $registro['personas'] = $col5;
        $registro['comentarios'] = $col6;
        $registro['fecha'] = $col7;
        $registro['estatus'] = $col8;
        $listado[] = $registro;
       }
      $stmt->free_result();
      $stmt->close();
    return $listado;
   }
   else
    return $mysqli->error;
  }
  function updContrasena($correo,$contrasena)
  {
   $mysqli = $this->fullConnect();
   $query="UPDATE usuarios SET contrasena = ? WHERE correo = ?";
   if ($stmt = $mysqli->prepare($query))
   {
     $stmt->bind_param('ss', $contrasena,$correo);
      if ($stmt->execute())
      {
         $stmt->free_result();
         $stmt->close();
  
           return true;
      }
      else
      {
         $this->mysqlError = $stmt->error;
         $stmt->close();
          return false;
      }
   }
   else
   {
     $this->mysqlError = $mysqli->error;
      return false;
   }
  }

  function setRegistro($nombre,$correo,$contrasena,$direccion)
   {
    $mysqli = $this->fullConnect();
    $query="INSERT INTO usuarios VALUES (?,?,?,?)";
    if ($stmt = $mysqli->prepare($query)) 
    {
     $stmt->bind_param('sssssss', $nombre,$correo,$contrasena,$direccion);
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
   function getLogin($correo,$contrasena){
    $listado = array();
$registro['estatus'] = "error";
$mysqli = $this->fullConnect();
$query = 'SELECT id,nombre FROM usuarios_seg WHERE correo = ? AND contrasena = ?';
if ($stmt = $mysqli->prepare($query))
{
$stmt->bind_param('ss', $correo,$contrasena);
if ($stmt->execute())
 $stmt->bind_result($col1,$col2);
  while ($stmt->fetch())
  {
    $registro['id'] = $col1;
    $registro['nombre'] = $col2;
    $registro['estatus'] = 'ok';
    $listado = $registro;
  }
 $stmt->free_result();
 $stmt->close();
return $listado;
}
else
return $mysqli->error;
}
function setUsuario($id,$correo,$contrasena,$nombre,$fecha)
   {
    $mysqli = $this->fullConnect();
    $query="INSERT INTO usuarios_seg VALUES (?,?,?,?,?,1)";
    if ($stmt = $mysqli->prepare($query)) 
    {
     $stmt->bind_param('sssss', $id,$correo,$contrasena,$nombre,$fecha);
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

