<?php

class ImagenRepository implements ImagenRepositoryInterface
{
    private $directorioBase;
    private $extensionesPermitidas;
    private $tamanoMaximo;

    public function __construct($directorioBase = '/public/imagenes/')
    {
        $this->directorioBase = rtrim($directorioBase, '/') . '/';
        $this->extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $this->tamanoMaximo = 5 * 1024 * 1024; // 5MB
    }

    public function subirImagen($archivo, $directorio = 'productos')
    {
        // Validar archivo
        $validacion = $this->validarImagen($archivo);
        if ($validacion !== true) {
            throw new Exception($validacion);
        }

        // Crear directorio si no existe
        $rutaDirectorio = $_SERVER['DOCUMENT_ROOT'] . $this->directorioBase . $directorio;
        if (!is_dir($rutaDirectorio)) {
            if (!mkdir($rutaDirectorio, 0755, true)) {
                throw new Exception('No se pudo crear el directorio de imágenes');
            }
        }

        // Generar nombre único
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        $nombreArchivo = uniqid('img_') . '_' . time() . '.' . $extension;
        $rutaCompleta = $rutaDirectorio . '/' . $nombreArchivo;

        // Subir archivo
        if (!move_uploaded_file($archivo['tmp_name'], $rutaCompleta)) {
            throw new Exception('Error al subir la imagen');
        }

        // Redimensionar si es necesario
        $this->redimensionarImagen($rutaCompleta, $rutaCompleta, 800, 600);

        return $nombreArchivo;
    }

    public function eliminarImagen($rutaImagen)
    {
        if (empty($rutaImagen)) {
            return true;
        }

        $rutaCompleta = $_SERVER['DOCUMENT_ROOT'] . $this->directorioBase . $rutaImagen;
        
        if (file_exists($rutaCompleta)) {
            return unlink($rutaCompleta);
        }
        
        return true;
    }

    public function obtenerRutaImagen($nombreImagen, $directorio = 'productos')
    {
        if (empty($nombreImagen)) {
            return $this->directorioBase . 'no-image.png'; // Imagen por defecto
        }

        return $this->directorioBase . $directorio . '/' . $nombreImagen;
    }

    public function validarImagen($archivo)
    {
        // Verificar que se subió un archivo
        if (!isset($archivo) || $archivo['error'] !== UPLOAD_ERR_OK) {
            return 'No se recibió ningún archivo o hubo un error en la subida';
        }

        // Verificar tamaño
        if ($archivo['size'] > $this->tamanoMaximo) {
            return 'El archivo es demasiado grande. Máximo 5MB';
        }

        // Verificar tipo MIME
        $tiposMime = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($archivo['type'], $tiposMime)) {
            return 'Tipo de archivo no permitido. Solo se permiten: JPG, PNG, GIF, WEBP';
        }

        // Verificar extensión
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $this->extensionesPermitidas)) {
            return 'Extensión de archivo no permitida';
        }

        // Verificar que es una imagen real
        $infoImagen = getimagesize($archivo['tmp_name']);
        if ($infoImagen === false) {
            return 'El archivo no es una imagen válida';
        }

        return true;
    }

    public function redimensionarImagen($rutaOrigen, $rutaDestino, $ancho, $alto)
    {
        $infoImagen = getimagesize($rutaOrigen);
        if (!$infoImagen) {
            return false;
        }

        list($anchoOriginal, $altoOriginal) = $infoImagen;
        $tipoImagen = $infoImagen[2];

        // Si la imagen ya es más pequeña, no redimensionar
        if ($anchoOriginal <= $ancho && $altoOriginal <= $alto) {
            return true;
        }

        // Calcular nuevas dimensiones manteniendo proporción
        $ratio = min($ancho / $anchoOriginal, $alto / $altoOriginal);
        $nuevoAncho = $anchoOriginal * $ratio;
        $nuevoAlto = $altoOriginal * $ratio;

        // Crear imagen desde el original
        switch ($tipoImagen) {
            case IMAGETYPE_JPEG:
                $imagenOriginal = imagecreatefromjpeg($rutaOrigen);
                break;
            case IMAGETYPE_PNG:
                $imagenOriginal = imagecreatefrompng($rutaOrigen);
                break;
            case IMAGETYPE_GIF:
                $imagenOriginal = imagecreatefromgif($rutaOrigen);
                break;
            default:
                return false;
        }

        if (!$imagenOriginal) {
            return false;
        }

        // Crear nueva imagen redimensionada
        $nuevaImagen = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
        
        // Preservar transparencia para PNG y GIF
        if ($tipoImagen == IMAGETYPE_PNG || $tipoImagen == IMAGETYPE_GIF) {
            imagecolortransparent($nuevaImagen, imagecolorallocatealpha($nuevaImagen, 0, 0, 0, 127));
            imagealphablending($nuevaImagen, false);
            imagesavealpha($nuevaImagen, true);
        }

        // Redimensionar
        imagecopyresampled($nuevaImagen, $imagenOriginal, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $anchoOriginal, $altoOriginal);

        // Guardar imagen redimensionada
        $resultado = false;
        switch ($tipoImagen) {
            case IMAGETYPE_JPEG:
                $resultado = imagejpeg($nuevaImagen, $rutaDestino, 85);
                break;
            case IMAGETYPE_PNG:
                $resultado = imagepng($nuevaImagen, $rutaDestino);
                break;
            case IMAGETYPE_GIF:
                $resultado = imagegif($nuevaImagen, $rutaDestino);
                break;
        }

        // Limpiar memoria
        imagedestroy($imagenOriginal);
        imagedestroy($nuevaImagen);

        return $resultado;
    }
}