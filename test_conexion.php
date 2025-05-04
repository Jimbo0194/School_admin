<?php
$host = 'localhost'; 
$user = 'root'; 
$password = ''; 
$dbname = 'proyecto_db';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error al conectar con la base de datos: " . $e->getMessage()]);
    exit();
}
?>
