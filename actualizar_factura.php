<?php
include("conexion.php");

$id = $_POST["id"];
$descripcion = $_POST["descripcion"];
$categoria = $_POST["categoria"];
$cantidad = $_POST["cantidad"];
$precio_unitario = $_POST["precio_unitario"];
$itebis = $_POST["itebis"];
$descuento = $_POST["descuento"];

$total_general = ($cantidad * $precio_unitario) + $itebis - $descuento;

$conexion->query("
    UPDATE facturadetalle SET 
        Descripcion = '$descripcion',
        Categoria = '$categoria',
        Cantidad = $cantidad,
        PrecioUnitario = $precio_unitario,
        Itebis = $itebis,
        Descuento = $descuento,
        TotalGeneral = $total_general
    WHERE ID = $id
");

header("Location: listar_facturas.php");
exit;
?>