<?php
// /controladores/registro.controlador.php
declare(strict_types=1);

header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *"); // Ajusta esto si usarás dominio específico
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
  http_response_code(200);
  exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  echo json_encode(["success" => false, "error" => "Método no permitido"]);
  exit();
}

require_once "../modelos/UsuariosModelo.php";

function validarEmail(string $email): bool
{
  return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
}

try {
  $inputRaw = file_get_contents("php://input");
  $input = json_decode($inputRaw, true);

  if (!is_array($input)) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "JSON inválido"]);
    exit();
  }

  // Campos requeridos del formulario
  $nombre = trim($input["nombre"] ?? "");
  $apellidos = trim($input["apellidos"] ?? "");
  $email = trim($input["email"] ?? "");
  $telefono = trim($input["telefono"] ?? "");
  $password = (string) ($input["password"] ?? "");
  $confirm = (string) ($input["password_confirm"] ?? "");
  $terms = (bool) ($input["terms"] ?? false);
  $provider = trim($input["provider"] ?? "local");

  // Validaciones
  $errores = [];

  if ($nombre === "") {
    $errores["nombre"] = "El nombre es obligatorio";
  }
  if (!validarEmail($email)) {
    $errores["email"] = "Correo electrónico inválido";
  }
  if ($password === "") {
    $errores["password"] = "La contraseña es obligatoria";
  }
  if ($password !== $confirm) {
    $errores["password_confirm"] = "Las contraseñas no coinciden";
  }
  if (!$terms) {
    $errores["terms"] = "Debes aceptar los términos";
  }

  if (!empty($errores)) {
    http_response_code(422);
    echo json_encode(["success" => false, "errors" => $errores]);
    exit();
  }

  $modelo = new UsuarioModelo();

  if ($modelo->emailExiste($email)) {
    http_response_code(409);
    echo json_encode([
      "success" => false,
      "error" => "El correo ya está registrado",
    ]);
    exit();
  }

  // Generar hash y datos de verificación
  $passwordHash = password_hash($password, PASSWORD_DEFAULT);
  $token = bin2hex(random_bytes(32));
  $expira = (new DateTimeImmutable("+24 hours"))->format("Y-m-d H:i:s");
  $termsAcceptedAt = (new DateTimeImmutable("now"))->format("Y-m-d H:i:s");

  $nuevoId = $modelo->crearUsuario([
    "nombre" => $nombre,
    "apellidos" => $apellidos ?: null,
    "email" => $email,
    "telefono" => $telefono ?: null,
    "password_hash" => $passwordHash,
    "role" => "paciente",
    "provider" => $provider,
    "provider_id" => null,
    "verificacion_token" => $token,
    "verificacion_expira" => $expira,
    "terms_accepted_at" => $termsAcceptedAt,
  ]);

  echo json_encode([
    "success" => true,
    "message" => "Usuario registrado correctamente",
    "user_id" => $nuevoId,
    // Puedes devolver la URL para verificar email si ya tienes endpoint preparado
    // 'verify_url' => "/verificar.php?token=$token&email=" . urlencode($email)
  ]);
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(["success" => false, "error" => "Error DB: " . $e->getMessage()]);
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(["success" => false, "error" => "Error del servidor: " . $e->getMessage()]);
}
