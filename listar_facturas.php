<?php
include("conexion.php");

$facturas = $conexion->query("SELECT ID, Descripcion, Categoria, Cantidad, PrecioUnitario, Itebis, Descuento, TotalGeneral FROM facturadetalle");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Facturas</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="form-container">
        <div class="form-header">Facturas Registradas</div>

        <div class="tabla-wrapper">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>ITBIS</th>
                        <th>Descuento</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($factura = $facturas->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $factura["ID"]; ?></td>
                        <td><?php echo $factura["Descripcion"]; ?></td>
                        <td><?php echo $factura["Categoria"]; ?></td>
                        <td><?php echo $factura["Cantidad"]; ?></td>
                        <td><?php echo $factura["PrecioUnitario"]; ?></td>
                        <td><?php echo $factura["Itebis"]; ?></td>
                        <td><?php echo $factura["Descuento"]; ?></td>
                        <td><?php echo $factura["TotalGeneral"]; ?></td>
                        <td class="acciones">
                            <a class="boton-accion" href="editar_factura.php?id=<?php echo $factura["ID"]; ?>">Editar</a>
                            <a class="boton-eliminar" href="eliminar_factura.php?id=<?php echo $factura["ID"]; ?>">Eliminar</a>
                            <a class="boton-imprimir" href="reporte_factura.php?id=<?php echo $factura["ID"]; ?>" target="_blank">Imprimir</a>
                            </td>
                    </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
        </div>

        <a class="boton-volver" href="insertar_factura.php">Agregar Nueva Factura</a>
    </div>
</body>
</html>