<?php
require_once(__DIR__ . '/database/database.php');
require_once 'cache.php';

function obtenerEstudiantesOptimizado() {
    $cache = new Cache();
    $db = new Database();
    $conn = $db->getConnection();

    // Primero buscamos en caché para evitar consulta repetitiva
    $cachedData = $cache->get("estudiantes_lista");
    if ($cachedData) {
        return $cachedData;
    }

    // Si no hay caché, obtenemos los datos de la base de datos
    $resultado = $conn->Execute("SELECT id, nombre, grupo_id FROM estudiantes LIMIT 50")->GetRows();
    
    // Guardamos la respuesta en caché para futuras consultas
    $cache->set("estudiantes_lista", $resultado);
    
    return $resultado;
}

function obtenerDocentesOptimizado() {
    $cache = new Cache();
    $db = new Database();
    $conn = $db->getConnection();

    // Verificamos si los datos ya están en caché
    $cachedData = $cache->get("docentes_lista");
    if ($cachedData) {
        return $cachedData;
    }

    // Consultamos la base de datos si no está en caché
    $resultado = $conn->Execute("SELECT id, nombre, especialidad FROM docentes LIMIT 50")->GetRows();
    
    // Guardamos en caché para consultas futuras
    $cache->set("docentes_lista", $resultado);
    
    return $resultado;
}
?>