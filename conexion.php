<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$basededatos = "BD_FacturacionPruebas";

$conexion = new mysqli($servidor, $usuario, $contrasena, $basededatos);
$conexion->set_charset("utf8");
?>