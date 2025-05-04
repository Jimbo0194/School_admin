<?php
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function verificarToken($request, $response, $next) {
    $headers = $request->getHeaders();
    
    if (!isset($headers['Authorization'])) {
        return $response->withJson(["mensaje" => "Token requerido"], 403);
    }

    $token = str_replace("Bearer ", "", $headers['Authorization'][0]);
    $secret_key = "clave_secreta_super_segura";  

    try {
        $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
        $request = $request->withAttribute('usuario', $decoded);
        return $next($request, $response);
    } catch (Exception $e) {
        return $response->withJson(["mensaje" => "Token inválido"], 403);
    }
}
?>