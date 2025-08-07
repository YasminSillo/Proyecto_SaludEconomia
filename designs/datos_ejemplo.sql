-- Insertar categorías de ejemplo
INSERT INTO categorias (nombre, descripcion, parent_id, activo) VALUES
('Medicamentos', 'Productos farmacéuticos y medicinas', NULL, 1),
('Equipos Médicos', 'Instrumentos y equipos para uso médico', NULL, 1),
('Suplementos', 'Vitaminas y suplementos nutricionales', NULL, 1),
('Cuidado Personal', 'Productos para higiene y cuidado personal', NULL, 1);

-- Subcategorías
INSERT INTO categorias (nombre, descripcion, parent_id, activo) VALUES
('Analgésicos', 'Medicamentos para el dolor', 1, 1),
('Antibióticos', 'Medicamentos antimicrobianos', 1, 1),
('Vitaminas', 'Suplementos vitamínicos', 3, 1),
('Termómetros', 'Instrumentos para medir temperatura', 2, 1);

-- Insertar proveedores de ejemplo
INSERT INTO proveedores (nombre_empresa, contacto_nombre, email, ruc) VALUES
('Laboratorios ABC S.A.', 'Juan Pérez', 'contacto@lababc.com', '20123456789'),
('Equipos Médicos XYZ', 'María García', 'ventas@equiposxyz.com', '20987654321'),
('Distribuidora Salud Plus', 'Carlos Mendoza', 'info@saludplus.com', '20555123456'),
('Suplementos Vitales E.I.R.L.', 'Ana Torres', 'ventas@vitales.pe', '20444789123');

-- Insertar productos de ejemplo
INSERT INTO productos (codigo_sku, nombre, categoria_id, proveedor_id) VALUES
-- Medicamentos - Analgésicos
('MED-PAR-500', 'Paracetamol 500mg - Caja x100', 5, 1),
('MED-IBU-400', 'Ibuprofeno 400mg - Caja x50', 5, 1),
('MED-ASP-100', 'Aspirina 100mg - Frasco x60', 5, 1),

-- Medicamentos - Antibióticos  
('MED-AMO-500', 'Amoxicilina 500mg - Caja x21', 6, 1),
('MED-AZI-500', 'Azitromicina 500mg - Caja x6', 6, 1),

-- Equipos Médicos - Termómetros
('EQU-TER-DIG', 'Termómetro Digital', 8, 2),
('EQU-TER-INF', 'Termómetro Infrarrojo', 8, 2),
('EQU-TEN-DIG', 'Tensiómetro Digital', 2, 2),

-- Equipos Médicos - Otros
('EQU-EST-MED', 'Estetoscopio Médico', 2, 2),
('EQU-OTO-DIA', 'Otoscopio Diagnóstico', 2, 2),

-- Suplementos - Vitaminas
('SUP-VIT-C', 'Vitamina C 1000mg - Frasco x60', 7, 4),
('SUP-VIT-D3', 'Vitamina D3 2000UI - Frasco x90', 7, 4),
('SUP-CAL-MAG', 'Calcio + Magnesio - Frasco x120', 7, 4),

-- Suplementos - Otros
('SUP-OME-3', 'Omega 3 - Cápsulas x60', 3, 4),
('SUP-PRO-COL', 'Probióticos - Cápsulas x30', 3, 4),

-- Cuidado Personal
('CUI-ALC-GEL', 'Alcohol en Gel 500ml', 4, 3),
('CUI-MAS-QUI', 'Mascarillas Quirúrgicas x50', 4, 3),
('CUI-GUA-LAT', 'Guantes de Látex x100', 4, 3),
('CUI-JER-DES', 'Jeringas Descartables 5ml x100', 4, 3),
('CUI-GAS-EST', 'Gasas Estériles x25', 4, 3);

-- Insertar algunos usuarios de ejemplo (admin y vendedor)
INSERT INTO usuarios (nombre, email, password_hash, rol) VALUES
('Administrador Sistema', 'admin@saludeconomia.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Vendedor Principal', 'vendedor@saludeconomia.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'vendedor');

-- Insertar algunos clientes de ejemplo
INSERT INTO clientes (tipo_cliente, nombre, email, ruc_dni) VALUES
('juridico', 'Farmacia Central S.A.C.', 'gerencia@farmaciacentral.com', '20123456789'),
('juridico', 'Clínica San Juan', 'compras@clinicasanjuan.pe', '20987654321'),
('natural', 'María González López', 'maria.gonzalez@email.com', '12345678'),
('natural', 'Carlos Rodríguez Vargas', 'carlos.rodriguez@email.com', '87654321'),
('juridico', 'Hospital Regional', 'adquisiciones@hospitalregional.gob.pe', '20555123456');