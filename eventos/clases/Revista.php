<?php
class Revista extends Conexion
{
 var $conexion;
 var $insertId;
 private $paginador = 20;

 function __construct()
 {
 }
 function setRevista($id,$nombre,$contenido,$anuncio,$categoria,$fecha,$estatus)
 {
  $mysqli = $this->fullConnect();
  $query="INSERT INTO rev_revista VALUES (?,?,?,?,?,?,?,0,0)";
  if ($stmt = $mysqli->prepare($query))
  {
   $stmt->bind_param('sssssss', $id,$nombre,$contenido,$anuncio,$categoria,$fecha,$estatus);
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
 function updRevistaId($id,$nombre,$contenido,$anuncio,$categoria,$rank)
 {
  $mysqli = $this->fullConnect();
  $query="UPDATE rev_revista SET nombre = ?, contenido = ?, anuncio = ?, categoria = ?, rank = ? WHERE id = ?";
  if ($stmt = $mysqli->prepare($query))
  {
   $stmt->bind_param('ssssis', $nombre,$contenido,$anuncio,$categoria,$rank,$id);
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
 function updMegusta($id)
 {
  $mysqli = $this->fullConnect();
  $query="UPDATE rev_revista SET gusta = gusta + 1 WHERE id = ?";
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
 function delRevista($id)
 {
  $mysqli = $this->fullConnect();
  $query="DELETE FROM rev_revista WHERE id = ?";
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

 function getRevistaId($id)
 {
	$listado = array();
  $registro['estatus'] = "error";
	$mysqli = $this->fullConnect();
  $query = 'SELECT id,nombre,contenido,anuncio,categoria,fecha,estatus,rank,gusta FROM rev_revista WHERE id = ?';
  if ($stmt = $mysqli->prepare($query))
  {
    $stmt->bind_param('s', $id);
    if ($stmt->execute())
     $stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9);
      while ($stmt->fetch())
      {
        $registro['id'] = $col1;
        $registro['nombre'] = $col2;
        $registro['contenido'] = $col3;
        $registro['anuncio'] = $col4;
        $registro['categoria'] = $col5;
        $registro['fecha'] = $col6;
        $registro['estatus'] = $col7;
        $registro['rank'] = $col8;
        $registro['gusta'] = $col9;
        $listado = $registro;
      }
     $stmt->free_result();
     $stmt->close();
   return $listado;
  }
  else
   return $mysqli->error;
 }
 function getRevista($paginador)
 {
  $paginador = ' ORDER BY rank DESC LIMIT '.$paginador.' , '.$this->paginador;
	$listado = array();
	$mysqli = $this->fullConnect();
  $query = 'SELECT id,nombre,contenido,anuncio,categoria,fecha,estatus,rank,gusta FROM rev_revista '.$paginador;
  if ($stmt = $mysqli->prepare($query))
  {
    if ($stmt->execute())
     $stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9);
      while ($stmt->fetch())
      {
        $registro['id'] = $col1;
        $registro['nombre'] = $col2;
        $registro['contenido'] = $col3;
        $registro['anuncio'] = $col4;
        $registro['categoria'] = $col5;
        $registro['fecha'] = $col6;
        $registro['estatus'] = $col7;
        $registro['rank'] = $col8;
        $registro['gusta'] = $col9;
        $listado[] = $registro;
      }
     $stmt->free_result();
     $stmt->close();
   return $listado;
  }
  else
   return $mysqli->error;
 }

 function getBuscarRevista($cadena)
 {
  $cadena = '%'.$cadena.'%';
	$listado = array();
	$mysqli = $this->fullConnect();
  $query = 'SELECT id,nombre,contenido,anuncio,categoria,fecha,estatus,rank,gusta FROM rev_revista  WHERE (id like ? OR nombre like ? OR contenido like ? OR categoria like ?)';
   if ($stmt = $mysqli->prepare($query))
   {
    $stmt->bind_param('ssss',$cadena,$cadena,$cadena,$cadena);
    if ($stmt->execute())
    $stmt->bind_result($col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8,$col9);
     while ($stmt->fetch())
     {
       $registro['id'] = $col1;
       $registro['nombre'] = $col2;
       $registro['contenido'] = $col3;
       $registro['anuncio'] = $col4;
       $registro['categoria'] = $col5;
       $registro['fecha'] = $col6;
       $registro['estatus'] = $col7;
       $registro['rank'] = $col8;
       $registro['gusta'] = $col9;
       $listado[] = $registro;
      }
     $stmt->free_result();
     $stmt->close();
   return $listado;
  }
  else
   return $mysqli->error;
 }

}//end class
