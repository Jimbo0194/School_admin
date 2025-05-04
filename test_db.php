<?php
require_once __DIR__ . '/adodb/adodb.inc.php';

$conn = ADONewConnection('mysqli'); 
$conn->Connect('localhost', 'usuario', 'contraseña', 'proyecto_db');

if ($conn->IsConnected()) {
    echo "✅ Conexión exitosa a la base de datos.";
} else {
    die("❌ Error: No se pudo conectar a la base de datos.");
}
?>