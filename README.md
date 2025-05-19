# 🧾 Sistema de Facturación en PHP

Este es un sistema de facturación básico hecho en **PHP** utilizando **MySQL** para la base de datos y **TCPDF** para la generación de reportes en PDF.

---

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
