<?php
ini_set("display_errors",1);
include "../clases/Conexion.php";

if ($_GET["source1"]=="eventos"){
    include "controladorEvento.php";
}
echo json_encode($server);

?>