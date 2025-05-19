<?php
include("conexion.php");

$id = $_GET["id"];
$sentencia = $conexion->query("SELECT * FROM facturadetalle WHERE ID = $id");
$factura = $sentencia->fetch_assoc();
$categorias = $conexion->query("SELECT * FROM categorias");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Factura</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">Editar Factura</div>
        <form class="formulario" action="actualizar_factura.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $factura['ID']; ?>">

            <input type="text" name="descripcion" placeholder="Descripción" value="<?php echo $factura['Descripcion']; ?>" required>

            <select name="categoria" required>
                <?php while ($categoria = $categorias->fetch_assoc()): ?>
                    <option value="<?php echo $categoria['Nombre']; ?>" <?php echo $factura['Categoria'] == $categoria['Nombre'] ? 'selected' : ''; ?>>
                        <?php echo $categoria['Nombre']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <input type="number" name="cantidad" placeholder="Cantidad" value="<?php echo $factura['Cantidad']; ?>" step="1" min="1" required>
            <input type="number" name="precio_unitario" placeholder="Precio Unitario" value="<?php echo $factura['PrecioUnitario']; ?>" step="0.01" min="0" required>
            <input type="number" name="itebis" placeholder="ITBIS" value="<?php echo $factura['Itebis']; ?>" step="0.01" min="0" required>
            <input type="number" name="descuento" placeholder="Descuento" value="<?php echo $factura['Descuento']; ?>" step="0.01" min="0" required>
            <input type="number" name="total_general" placeholder="Total General" value="<?php echo $factura['TotalGeneral']; ?>" step="0.01" min="0" readonly>

            <button type="submit" class="boton-guardar">Actualizar Factura</button>
            <a class="boton-volver" href="listar_facturas.php">Ver registros de facturas</a>
        </form>
    </div>
</body>
</html>