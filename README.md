# Sistema de Facturación PHP

Este proyecto consiste en un sistema de facturación desarrollado en PHP y MySQL. Incluye funcionalidad para insertar, editar, eliminar y generar reportes de facturas utilizando TCPDF.

## 📁 Estructura del Proyecto

- `conexion.php` → Conexión a la base de datos
- `insertar_factura.php` → Formulario para crear nuevas facturas
- `listar_facturas.php` → Vista con todas las facturas
- `reporte_factura.php` → Generación del PDF con TCPDF
- `tcpdf/` → Carpeta con la librería TCPDF
- `README.md` → Este archivo

## 🛠 Requisitos

- PHP 7.x o superior
- MySQL
- XAMPP o cualquier servidor local (ej: Laragon)
- Navegador web (Chrome, Firefox)

## ⚙ Instalación

1. Clona o descarga este proyecto y colócalo en `htdocs` si usas XAMPP.
2. Crea una base de datos en phpMyAdmin llamada `bd_facturacionpruebas`.
3. Importa las tablas `categorias` y `facturadetalle`.
4. Configura los datos de conexión en `conexion.php`.

```php
$conexion = new mysqli("localhost", "root", "", "bd_facturacionpruebas");
