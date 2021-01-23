<?php
ini_set("display_errors",1);
include "../clases/Conexion.php";
if ($_GET["source1"]=="login"){
    include "controladorLogin.php";
}

if ($_GET["source1"]=="lista"){
    include "controladorLista.php";
}

if ($_GET["source1"]=="eventos"){
    include "controladorEventos.php";
}


echo json_encode($server);
?>