-- Crear tabla para múltiples imágenes por producto
-- Fecha: 2025-08-12

CREATE TABLE producto_imagenes (
    id_imagen INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    nombre_archivo VARCHAR(255) NOT NULL,
    orden INT DEFAULT 0,
    es_principal TINYINT(1) DEFAULT 0,
    alt_text VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (producto_id) REFERENCES productos(id_producto) ON DELETE CASCADE,
    INDEX idx_producto_orden (producto_id, orden),
    INDEX idx_principal (producto_id, es_principal)
) ENGINE=InnoDB;

-- Migrar imágenes existentes de la columna 'imagen' a la nueva tabla
INSERT INTO producto_imagenes (producto_id, nombre_archivo, orden, es_principal, alt_text)
SELECT 
    id_producto,
    imagen,
    0,
    1,
    CONCAT('Imagen de ', nombre)
FROM productos 
WHERE imagen IS NOT NULL AND imagen != '';

-- Nota: La columna 'imagen' en productos se mantendrá por compatibilidad 
-- pero se usará la nueva tabla para la funcionalidad de galería