<?php 

function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', '3264', 'bienes_raices');
    $db->set_charset("utf8"); // Para que se muestren correctamente los acentos y las ñ

    if(!$db) {
        echo "Error no se pudo conectar";
        exit;
    } 

    return $db;
}