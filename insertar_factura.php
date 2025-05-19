<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Insertar Factura</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">Insertar Factura</div>
        <form action="guardar_factura.php" method="POST" class="formulario">
            <input type="text" name="descripcion" placeholder="Descripción" required>

            <select name="categoria" required>
                <?php
                include("conexion.php");
                $categorias = $conexion->query("SELECT * FROM categorias");
                while ($cat = $categorias->fetch_assoc()) {
                    echo "<option value='" . $cat["Nombre"] . "'>" . $cat["Nombre"] . "</option>";
                }
                ?>
            </select>

            <input type="number" step="1" name="cantidad" placeholder="Cantidad" required>
            <input type="number" step="0.01" name="precio_unitario" placeholder="Precio Unitario" required>
            <input type="number" step="0.01" name="itebis" placeholder="ITEBIS" required>
            <input type="number" step="0.01" name="descuento" placeholder="Descuento" required>

            <div class="botones-centrados">
                <button type="submit" class="boton-guardar">Guardar Factura</button>
                <a href="listar_facturas.php" class="boton-volver-secundario">Ver registros de facturas</a>
            </div>
        </form>
    </div>
</body>
</html>