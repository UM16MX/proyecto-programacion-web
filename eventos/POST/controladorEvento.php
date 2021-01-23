<?php 
include "../clases/Eventos.php";
$arts=new Eventos();
if ($_GET["source2"]=="setevento")
{
    $id=uniqid();
    $fecha=date("Y-m-d H:i:s");
    if($arts->setEvento($id,$_POST["fec_res"],$_POST["desde"],$_POST["hasta"],$_POST["personas"],$_POST["comentarios"],$fecha))
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

if($_GET["source2"] == "updeventoid")
{
  if($arts->updEventoId($_POST['idevento'],$_POST['fec_res_ed'],$_POST['desde_ed'],$_POST['hasta_ed'],$_POST ['personas_ed'],$_POST['comentarios_ed']))
  {
   $server['estatus'] = 'ok';
   $server['log'] = $_POST['idevento'];
   $arts->conexion->commit();
  }
  else
  {
   $server['status'] = 'error';
   $arts->conexion->rollback();
  }
}

if($_GET["source2"] == "delevento")
{
  if($arts->delEvento($_POST["id"]))
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

if ($_GET["source2"]=="setusuario")
{
    $id=uniqid();
    $fecha=date("Y-m-d H:i:s");
    if($arts->setUsuario($id,$_POST["nombre"],$_POST["correo"],$_POST["contrasena"],$fecha))
    {
        $server['logId'] = $id;
        $server['logFecha'] = $fecha;
        $server['estatus'] = 'ok';
        $arts->conexion->commit();
       }
       else
       {
        $server['estatus'] = 'error';
        $arts->conexion->rollback();
       }
    
}

if($_GET['source2'] == 'updcontrasena')
{
  if($arts->updContrasena($_POST['usuario'],$_POST['contra']))
  {
   $server['estatus'] = 'ok';
   $server['log'] = $_POST['usuario'];
   $arts->conexion->commit();
  }
  else
  {
   $server['status'] = 'error';
   $arts->conexion->rollback();
  }
}
?>