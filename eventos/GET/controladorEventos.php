<?php 
include "../clases/Eventos.php";
$arts = new Eventos();
if ($_GET["source2"]=="geteventos")
$server=$arts->getEventos();

if ($_GET["source2"]=="geteventoid")
$server=$arts->getEventoId($_POST["source1"]);

if ($_GET["source2"]=="getbuscarevento")
$server=$arts->getBuscarEvento($_POST["fec_res"]);

if ($_GET["source2"]=="getlogin")
$server=$arts->getLogin($_POST["usuario"],$_POST["contra"]);
?>

