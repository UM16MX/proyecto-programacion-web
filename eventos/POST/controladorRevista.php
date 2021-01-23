<?php
/* Aquí se instancía la clase y se invocan los metodos requeridos comunmente los metodos get en el parametro source2 son set/upd/del */
include '../clases/Revista.php';
/* la variable arts suele ser el contenedor estandar para almacenar clases*/
$arts = new Revista();
if($_GET['source2'] == 'setrevista')
{
$id = uniqid();
$fecha = date("Y-m-d H:i:s");
  if($arts->setRevista($id,$_POST['source1'],$_POST['source2'],$_POST['source3'],$_POST['source4'],$fecha,'Pendiente'))
  {
   $server['estatus'] = 'ok';
   $server['logId'] = $id;
   $server['logFecha'] = $fecha;
   $arts->conexion->commit();
  }
  else
  {
   $server['estatus'] = 'error';
   $arts->conexion->rollback();
  }
}
if($_GET['source2'] == 'updrevistaid')
{
  if($arts->updRevistaId($_POST['sourcee'],$_POST['sourcee1'],$_POST['sourcee2'],$_POST['sourcee3'],$_POST['sourcee4'],$_POST['sourcee5']))
  {
   $server['estatus'] = 'ok';
   $server['log'] = $idAsign;
   $arts->conexion->commit();
  }
  else
  {
   $server['status'] = 'error';
   $arts->conexion->rollback();
  }
}
if($_GET['source2'] == 'updmegusta')
{
  if($arts->updMeGusta($_POST['sourcee1']))
  {
   $server['estatus'] = 'ok';
   $server['log'] = $idAsign;
   $arts->conexion->commit();
  }
  else
  {
   $server['estatus'] = 'error';
   $arts->conexion->rollback();
  }
}
if($_GET['source2'] == 'delrevista')
{
  if($arts->delRevista($_POST['source2']))
  {
   $server['status'] = 'ok';
   $arts->conexion->commit();
  }
  else
  {
   $server['status'] = 'error';
   $server['log'] = $arts->mysqlError;
   $arts->conexion->rollback();
  }
}
