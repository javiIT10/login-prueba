<?php
// /logout.php
session_start();

// Destruir todos los datos de la sesión
$_SESSION = [];
session_destroy();

header("Content-Type: application/json");
echo json_encode([
  "success" => true,
  "message" => "Sesión cerrada correctamente",
]);
