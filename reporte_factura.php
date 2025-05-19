<?php
include("conexion.php");

$id = intval($_GET["id"]);

$consulta = $conexion->query("SELECT * FROM facturadetalle WHERE ID = $id");
$factura = $consulta->fetch_assoc();

if (!$factura) {
    header("Location: listar_facturas.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Factura</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">REPORTE DE FACTURA #<?php echo $factura["ID"]; ?></div>

        <form class="formulario">
            <input type="text" value="Descripción: <?php echo htmlspecialchars($factura["Descripcion"]); ?>" readonly>
            <input type="text" value="Categoría: <?php echo htmlspecialchars($factura["Categoria"]); ?>" readonly>
            <input type="text" value="Cantidad: <?php echo $factura["Cantidad"]; ?>" readonly>
            <input type="text" value="Precio Unitario: RD$<?php echo number_format($factura["PrecioUnitario"], 2); ?>" readonly>
            <input type="text" value="ITBIS: RD$<?php echo number_format($factura["Itebis"], 2); ?>" readonly>
            <input type="text" value="Descuento: RD$<?php echo number_format($factura["Descuento"], 2); ?>" readonly>
            <input type="text" value="Total General: RD$<?php echo number_format($factura["TotalGeneral"], 2); ?>" readonly>
        </form>

        <div class="acciones" style="margin-top: 20px; display: flex; justify-content: center; gap: 15px;">
            <a class="boton-accion" href="listar_facturas.php">Ver todas las facturas</a>
            <a class="boton-imprimir" href="pdf_factura.php?id=<?php echo $factura['ID']; ?>" target="_blank">Imprimir PDF</a>
        </div>
    </div>
</body>
</html>