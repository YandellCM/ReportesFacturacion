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