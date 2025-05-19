# 🧾 Sistema de Facturación en PHP

Este es un sistema de facturación básico hecho en **PHP** utilizando **MySQL** para la base de datos y **TCPDF** para la generación de reportes en PDF.

---

## 📁 Estructura del Proyecto

# facturacion2/
│
├── conexion.php # Conexión a la base de datos MySQL

``` php
<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$basededatos = "BD_FacturacionPruebas";

$conexion = new mysqli($servidor, $usuario, $contrasena, $basededatos);
$conexion->set_charset("utf8");
?>
```

├── insertar_factura.php # Formulario para insertar una nueva factura
```php
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
```

├── guardar_factura.php # Lógica para guardar factura

```php
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
```
├── listar_facturas.php # Mostrar todas las facturas registradas

```php 
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
```

├── editar_factura.php # Formulario para editar una factura

```php
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
```

├── actualizar_factura.php # Actualiza factura en base de datos
```php 
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
```
├── eliminar_factura.php # Elimina factura

```php
<?php
include("conexion.php");

$id = intval($_GET["id"]);

$conexion->query("DELETE FROM facturadetalle WHERE ID = $id");

header("Location: listar_facturas.php");
exit;
?>
```
├── reporte_factura.php # Vista HTML de reporte

```php
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
```
├── pdf_factura.php # Generador de PDF usando TCPDF

```php
<?php
require_once('tcpdf/tcpdf.php');
include("conexion.php");

$id = intval($_GET["id"]);
$consulta = $conexion->query("SELECT * FROM facturadetalle WHERE ID = $id");
$factura = $consulta->fetch_assoc();

$pdf = new TCPDF();
$pdf->SetMargins(15, 20, 15);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

$logo = 'logo-cafam.jpg';
if (file_exists($logo)) {
    $pdf->Image($logo, 15, 10, 25);
}

$fecha = date("d/m/Y");

$html = '
<style>
    h1 {
        background-color: #3498db;
        color: #fff;
        padding: 12px;
        text-align: center;
        font-size: 20px;
        border-radius: 6px;
        margin-top: 30px;
    }
    .info {
        font-size: 13px;
        margin-top: 20px;
    }
    .info td {
        padding: 5px 10px;
    }
    .tabla {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px;
    }
    .tabla th {
        background-color: #3498db;
        color: white;
        padding: 10px;
        font-size: 13px;
    }
    .tabla td {
        border: 1px solid #ccc;
        padding: 10px;
        font-size: 13px;
        text-align: center;
    }
    .total {
        font-weight: bold;
        background-color: #ecf0f1;
    }
    .footer {
        margin-top: 30px;
        text-align: center;
        font-size: 11px;
        color: #666;
    }
</style>

<h1>Factura #' . $factura["ID"] . '</h1>

<table class="info">
    <tr>
        <td><strong>Fecha:</strong> ' . $fecha . '</td>
        <td><strong>Emitido por:</strong> Colegio Cafam Fernando Arturo de Meriño</td>
    </tr>
    <tr>
        <td><strong>Dirección:</strong> Av. 27 de Febrero, Santo Domingo</td>
        <td><strong>Correo:</strong> colegio@cafammerino.edu.do</td>
    </tr>
</table>

<table class="tabla">
    <tr>
        <th>Descripción</th>
        <th>Categoría</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>ITBIS</th>
        <th>Descuento</th>
        <th>Total</th>
    </tr>
    <tr>
        <td>' . htmlspecialchars($factura["Descripcion"]) . '</td>
        <td>' . htmlspecialchars($factura["Categoria"]) . '</td>
        <td>' . $factura["Cantidad"] . '</td>
        <td>RD$' . number_format($factura["PrecioUnitario"], 2) . '</td>
        <td>RD$' . number_format($factura["Itebis"], 2) . '</td>
        <td>RD$' . number_format($factura["Descuento"], 2) . '</td>
        <td class="total">RD$' . number_format($factura["TotalGeneral"], 2) . '</td>
    </tr>
</table>

<div class="footer">
    ¡Gracias por confiar en nuestra institución educativa!<br>
    Si tiene alguna pregunta, escríbanos al correo institucional.<br>
    © Colegio Cafam Fernando Arturo de Meriño - 2025
</div>
';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('Factura_' . $factura["ID"] . '.pdf', 'I');
```
├── estilos.css # Estilos visuales del sistema

```css
:root {
  --color-primario: #3498db;
  --color-secundario: #2d77b3;
  --color-fondo: #eef3f9;
  --color-blanco: #ffffff;
  --color-texto: #155724;
  --color-exito: #d4edda;
  --color-borde-exito: #c3e6cb;
  --color-alerta: #e74c3c;
  --color-alerta-hover: #c0392b;
  --color-imprimir: #27ae60;
  --color-imprimir-hover: #1e8449;
  --sombra: 0 10px 30px rgba(0, 0, 0, 0.1);
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: var(--color-fondo);
  margin: 0;
  padding: 0;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  animation: fadeIn 0.6s ease-in;
}

.form-container {
  background: var(--color-blanco);
  border-radius: 20px;
  box-shadow: var(--sombra);
  width: 95%;
  max-width: 900px;
  overflow: hidden;
  margin: 40px auto;
  animation: fadeIn 0.6s ease-in;
  padding: 20px;
}

.form-header {
  background-color: var(--color-primario);
  color: white;
  font-size: 22px;
  font-weight: bold;
  text-align: center;
  padding: 20px;
  border-radius: 20px 20px 0 0;
}

form.formulario {
  padding: 25px 30px;
}

.formulario input,
.formulario select {
  display: block;
  width: 100%;
  margin-bottom: 20px;
  padding: 14px;
  border: 1px solid #ccc;
  border-radius: 12px;
  font-size: 16px;
  background-color: #fdfdfd;
  box-sizing: border-box;
  transition: all 0.3s ease;
}

.formulario input:focus,
.formulario select:focus {
  border-color: var(--color-primario);
  box-shadow: 0 0 10px rgba(41, 128, 185, 0.2);
  outline: none;
}

.tabla-wrapper {
  width: 100%;
  overflow-x: auto;
}

.tabla {
  min-width: 800px;
  width: 100%;
  border-collapse: collapse;
  margin-top: 25px;
  background-color: var(--color-blanco);
  box-shadow: var(--sombra);
  border-radius: 12px;
  animation: fadeIn 0.4s ease-in;
}

.tabla th,
.tabla td {
  padding: 6px 10px;
  border-bottom: 1px solid #e0e0e0;
  text-align: center;
  font-size: 14px;
}

.tabla th {
  background-color: var(--color-primario);
  color: white;
  font-weight: bold;
}

.tabla tr:hover {
  background-color: #f2f9ff;
}

.acciones {
  display: flex;
  justify-content: center;
  gap: 8px;
  flex-wrap: wrap;
  margin-top: 10px;
}

.boton-accion,
.boton-eliminar,
.boton-imprimir,
.boton-volver {
  display: inline-block;
  padding: 10px 18px;
  border-radius: 10px;
  font-size: 15px;
  font-weight: bold;
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
  text-align: center;
  text-decoration: none;
}

.boton-accion {
  background-color: var(--color-primario);
  color: white;
}

.boton-accion:hover {
  background-color: var(--color-secundario);
  transform: scale(1.05);
}

.boton-eliminar {
  background-color: var(--color-alerta);
  color: white;
}

.boton-eliminar:hover {
  background-color: var(--color-alerta-hover);
  transform: scale(1.05);
}

.boton-imprimir {
  background-color: var(--color-imprimir);
  color: white;
}

.boton-imprimir:hover {
  background-color: var(--color-imprimir-hover);
  transform: scale(1.05);
}

.boton-volver {
  display: block;
  width: 100%;
  background-color: var(--color-alerta);
  color: white;
  margin-top: 30px;
  padding: 14px;
  font-size: 16px;
  border-radius: 12px;
}

.boton-volver:hover {
  background-color: var(--color-alerta-hover);
  transform: scale(1.05);
}

.mensaje {
  background-color: var(--color-exito);
  border: 1px solid var(--color-borde-exito);
  color: var(--color-texto);
  padding: 15px;
  border-radius: 12px;
  margin-bottom: 20px;
  text-align: center;
  font-weight: 500;
  animation: fadeIn 0.4s ease-in;
}

@media screen and (max-width: 480px) {
  .form-container {
    margin: 20px;
    border-radius: 15px;
    padding: 15px;
  }

  .formulario input,
  .formulario select {
    font-size: 14px;
    padding: 10px;
  }

  .acciones {
    flex-direction: column;
    gap: 10px;
  }

  .tabla th,
  .tabla td {
    font-size: 13px;
    padding: 10px;
  }

  .form-header {
    font-size: 18px;
  }
}

.boton-accion,
.boton-eliminar,
.boton-imprimir,
.boton-volver {
  display: inline-block;
  padding: 6px 12px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 600;
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
  text-align: center;
  text-decoration: none;
  white-space: nowrap;
}

.boton-accion {
  background-color: var(--color-primario);
  color: white;
}

.boton-accion:hover {
  background-color: var(--color-secundario);
  transform: scale(1.05);
}

.boton-eliminar {
  background-color: var(--color-alerta);
  color: white;
}

.boton-eliminar:hover {
  background-color: var(--color-alerta-hover);
  transform: scale(1.05);
}

.boton-imprimir {
  background-color: var(--color-imprimir);
  color: white;
}

.boton-imprimir:hover {
  background-color: var(--color-imprimir-hover);
  transform: scale(1.05);
}

.boton-volver {
  display: inline-block;
  margin: 25px auto 0;
  background-color: var(--color-alerta);
  color: white;
  padding: 10px 20px;
  font-size: 14px;
  border-radius: 10px;
  width: auto;
}

.boton-volver:hover {
  background-color: var(--color-alerta-hover);
  transform: scale(1.05);
}

.boton-guardar {
  background-color: var(--color-primario);
  color: white;
  padding: 14px 24px;
  font-size: 16px;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  font-weight: bold;
  transition: all 0.3s ease;
  width: 100%;
  max-width: 220px;
}

.boton-guardar:hover {
  background-color: var(--color-secundario);
  transform: scale(1.05);
}

.boton-volver-secundario {
  background-color: var(--color-alerta);
  color: white;
  padding: 10px 20px;
  font-size: 14px;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  font-weight: bold;
  transition: all 0.3s ease;
  width: 100%;
  max-width: 180px;
  text-align: center;
  display: inline-block;
}

.boton-volver-secundario:hover {
  background-color: var(--color-alerta-hover);
  transform: scale(1.05);
}
```
└── README.md # Documentación del proyecto

---

## ✅ Requisitos

- PHP 8.2.12
- MySQL / MariaDB
- Servidor local (XAMPP o otro que utilices)
- Navegador web (Chrome en mi caso)
- Editor de código como Visual Studio Code 

---

## ⚙️ Instalación

# 1. Clona el repositorio o copia la carpeta `facturacion2` a tu directorio `htdocs`.

# 2. Crea una base de datos en phpMyAdmin con el nombre:

bd_facturacionpruebas

## 3. Ejecuta este script para crear las tablas necesarias:

CREATE TABLE categorias (
  ID INT AUTO_INCREMENT PRIMARY KEY,
  Nombre VARCHAR(50) NOT NULL
);

CREATE TABLE facturadetalle (
  ID INT AUTO_INCREMENT PRIMARY KEY,
  Descripcion VARCHAR(100),
  Categoria VARCHAR(50),
  Cantidad INT,
  PrecioUnitario DECIMAL(10,2),
  Itebis DECIMAL(10,2),
  Descuento DECIMAL(10,2),
  TotalGeneral DECIMAL(10,2)
);

## Agrega categorías predefinidas (opcional pero recomendado):


INSERT INTO categorias (Nombre) VALUES
('Cereales'), ('Lácteos'), ('Carnes'), ('Verduras'), ('Frutas'),
('Bebidas'), ('Snacks'), ('Limpieza'), ('Higiene personal'),
('Panadería'), ('Otros');

## 🚀 Ejecución

Abre tu navegador y accede a:
http://localhost/facturacion2/insertar_factura.php

# Desde ahí podrás:

Registrar nuevas facturas

Ver el listado de todas

Editar o eliminar facturas

Generar reportes en PDF con TCPDF

