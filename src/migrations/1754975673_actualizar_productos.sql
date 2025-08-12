-- Actualizar tabla productos para añadir nuevos campos
ALTER TABLE productos 
ADD COLUMN descripcion TEXT NULL AFTER nombre,
ADD COLUMN precio DECIMAL(10,2) NULL AFTER descripcion,
ADD COLUMN imagen VARCHAR(255) NULL AFTER precio;

-- Actualizar datos existentes con valores de ejemplo
UPDATE productos SET 
descripcion = CASE 
  WHEN nombre LIKE '%Paracetamol%' THEN 'Analgésico y antipirético de uso común para el alivio del dolor y la fiebre.'
  WHEN nombre LIKE '%Ibuprofeno%' THEN 'Antiinflamatorio no esteroideo (AINE) para el tratamiento del dolor y la inflamación.'
  WHEN nombre LIKE '%Aspirina%' THEN 'Medicamento analgésico, antipirético y antiinflamatorio.'
  WHEN nombre LIKE '%Amoxicilina%' THEN 'Antibiótico de amplio espectro para el tratamiento de infecciones bacterianas.'
  WHEN nombre LIKE '%Azitromicina%' THEN 'Antibiótico macrólido efectivo contra diversas infecciones bacterianas.'
  WHEN nombre LIKE '%Termómetro%' THEN 'Instrumento médico para medir la temperatura corporal con precisión.'
  WHEN nombre LIKE '%Tensiómetro%' THEN 'Equipo médico para medir la presión arterial de forma precisa.'
  WHEN nombre LIKE '%Estetoscopio%' THEN 'Instrumento médico para auscultar sonidos del corazón y pulmones.'
  WHEN nombre LIKE '%Vitamina C%' THEN 'Suplemento antioxidante esencial para el sistema inmunológico.'
  WHEN nombre LIKE '%Alcohol en Gel%' THEN 'Solución hidroalcohólica para desinfección de manos y superficies.'
  ELSE 'Producto de calidad para uso médico y cuidado de la salud.'
END,
precio = CASE 
  WHEN nombre LIKE '%Paracetamol%' THEN 12.50
  WHEN nombre LIKE '%Ibuprofeno%' THEN 18.90
  WHEN nombre LIKE '%Aspirina%' THEN 8.75
  WHEN nombre LIKE '%Amoxicilina%' THEN 25.00
  WHEN nombre LIKE '%Azitromicina%' THEN 35.50
  WHEN nombre LIKE '%Termómetro Digital%' THEN 45.00
  WHEN nombre LIKE '%Termómetro Infrarrojo%' THEN 120.00
  WHEN nombre LIKE '%Tensiómetro%' THEN 89.90
  WHEN nombre LIKE '%Estetoscopio%' THEN 156.00
  WHEN nombre LIKE '%Otoscopio%' THEN 280.00
  WHEN nombre LIKE '%Vitamina C%' THEN 22.50
  WHEN nombre LIKE '%Vitamina D3%' THEN 28.90
  WHEN nombre LIKE '%Calcio%' THEN 32.00
  WHEN nombre LIKE '%Omega 3%' THEN 45.90
  WHEN nombre LIKE '%Probióticos%' THEN 38.50
  WHEN nombre LIKE '%Alcohol en Gel%' THEN 15.90
  WHEN nombre LIKE '%Mascarillas%' THEN 25.00
  WHEN nombre LIKE '%Guantes%' THEN 18.50
  WHEN nombre LIKE '%Jeringas%' THEN 35.00
  WHEN nombre LIKE '%Gasas%' THEN 12.90
  ELSE 25.00
END
WHERE precio IS NULL;

-- Crear imagen por defecto
-- Nota: Debes crear una imagen llamada 'no-image.png' en /public/imagenes/