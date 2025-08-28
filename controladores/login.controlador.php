<?php
// /controladores/login.controlador.php
declare(strict_types=1);

header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *"); // Ajusta si usas dominio específico
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

/* Sugerencia: ajustar cookies de sesión antes de session_start si quieres "remember me".
 Para simplificar, manejamos sesión estándar. */
session_start();

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

  $email = trim($input["email"] ?? "");
  $password = (string) ($input["password"] ?? "");
  $remember = (bool) ($input["remember"] ?? false);

  $errores = [];
  if (!validarEmail($email)) {
    $errores["email"] = "Correo inválido";
  }
  if ($password === "") {
    $errores["password"] = "La contraseña es obligatoria";
  }

  if (!empty($errores)) {
    http_response_code(422);
    echo json_encode(["success" => false, "errors" => $errores]);
    exit();
  }

  $modelo = new UsuarioModelo();
  $user = $modelo->obtenerPorEmail($email);

  // Mensaje genérico para no filtrar si existe o no el correo
  $msgCredenciales = "Credenciales incorrectas";

  if (!$user) {
    http_response_code(401);
    echo json_encode(["success" => false, "error" => $msgCredenciales]);
    exit();
  }

  // Verifica estado
  if ($user["status"] !== "activo") {
    http_response_code(403);
    echo json_encode(["success" => false, "error" => "Cuenta inactiva o restringida"]);
    exit();
  }

  // Verifica bloqueo temporal
  if (!empty($user["locked_until"])) {
    $lockedUntil = new DateTimeImmutable($user["locked_until"]);
    $ahora = new DateTimeImmutable("now");
    if ($lockedUntil > $ahora) {
      $mins = max(1, (int) ceil(($lockedUntil->getTimestamp() - $ahora->getTimestamp()) / 60));
      http_response_code(423); // Locked
      echo json_encode([
        "success" => false,
        "error" => "Cuenta bloqueada. Intenta de nuevo en ~{$mins} min.",
      ]);
      exit();
    }
  }

  // Verifica contraseña
  if (!password_verify($password, $user["password_hash"])) {
    // Sumar intentos y quizá bloquear
    $res = $modelo->sumarIntentoFallido((int) $user["id_usuario"], 5, 15);
    if ($res["bloqueado"] ?? false) {
      http_response_code(423);
      echo json_encode([
        "success" => false,
        "error" => "Demasiados intentos. Tu cuenta se bloqueó por {$res["minutos"]} minutos.",
      ]);
    } else {
      $restantes = 5 - ($res["intentos"] ?? 0);
      http_response_code(401);
      echo json_encode([
        "success" => false,
        "error" => $msgCredenciales . " (Intentos restantes: " . max(0, $restantes) . ")",
      ]);
    }
    exit();
  }

  // Opcional: exigir verificación de email
  // if ((int)$user['email_verificado'] !== 1) {
  //   http_response_code(403);
  //   echo json_encode(['success' => false, 'error' => 'Debes verificar tu correo antes de iniciar sesión']);
  //   exit;
  // }

  // Login OK -> reset intentos y marcar login
  $modelo->marcarLoginExitoso((int) $user["id_usuario"]);

  // Iniciar sesión
  $_SESSION["usuario"] = [
    "id" => (int) $user["id_usuario"],
    "nombre" => $user["nombre"],
    "email" => $user["email"],
    "role" => $user["role"],
  ];

  // Nota: "remember me" real requeriría un token persistente en BD + cookie httpOnly.
  // Aquí solo devolvemos success para mantenerlo simple.

  echo json_encode([
    "success" => true,
    "message" => "Login exitoso",
    "redirect" => "bienvenida.php",
  ]);
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(["success" => false, "error" => "Error DB: " . $e->getMessage()]);
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(["success" => false, "error" => "Error del servidor: " . $e->getMessage()]);
}
