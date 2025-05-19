<?php
include("conexion.php");

$id = intval($_GET["id"]);

$conexion->query("DELETE FROM facturadetalle WHERE ID = $id");

header("Location: listar_facturas.php");
exit;
?>