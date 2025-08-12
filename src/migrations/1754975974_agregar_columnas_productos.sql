-- Migración para agregar columnas faltantes a la tabla productos
-- Fecha: 2025-08-12

ALTER TABLE productos 
ADD COLUMN descripcion TEXT NULL AFTER nombre,
ADD COLUMN precio DECIMAL(10,2) NULL AFTER descripcion,
ADD COLUMN imagen VARCHAR(255) NULL AFTER precio;