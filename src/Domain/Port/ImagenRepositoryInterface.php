<?php

interface ImagenRepositoryInterface
{
    public function subirImagen($archivo, $directorio = 'productos');
    public function eliminarImagen($rutaImagen);
    public function obtenerRutaImagen($nombreImagen, $directorio = 'productos');
    public function validarImagen($archivo);
    public function redimensionarImagen($rutaOrigen, $rutaDestino, $ancho, $alto);
}