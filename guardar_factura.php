<?php
include("conexion.php");

$descripcion = $_POST["descripcion"];
$categoria = $_POST["categoria"];
$cantidad = $_POST["cantidad"];
$precio_unitario = $_POST["precio_unitario"];
$itebis = $_POST["itebis"];
$descuento = $_POST["descuento"];

$total = ($cantidad * $precio_unitario) + $itebis - $descuento;

$conexion->query("INSERT INTO facturadetalle (Descripcion, Categoria, Cantidad, PrecioUnitario, Itebis, Descuento, TotalGeneral)
VALUES ('$descripcion', '$categoria', '$cantidad', '$precio_unitario', '$itebis', '$descuento', '$total')");

header("Location: listar_facturas.php");
exit;
?>