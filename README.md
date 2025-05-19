# 🧾 Sistema de Facturación en PHP

Este es un sistema de facturación básico hecho en **PHP** utilizando **MySQL** para la base de datos y **TCPDF** para la generación de reportes en PDF.

---

## 📁 Estructura del Proyecto

# facturacion2/
│
├── tcpdf/ # Librería TCPDF para generar PDFs
├── conexion.php # Conexión a la base de datos MySQL
├── insertar_factura.php # Formulario para insertar una nueva factura
├── guardar_factura.php # Lógica para guardar factura
├── listar_facturas.php # Mostrar todas las facturas registradas
├── editar_factura.php # Formulario para editar una factura
├── actualizar_factura.php # Actualiza factura en base de datos
├── eliminar_factura.php # Elimina factura
├── reporte_factura.php # Vista HTML de reporte
├── pdf_factura.php # Generador de PDF usando TCPDF
├── estilos.css # Estilos visuales del sistema
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

