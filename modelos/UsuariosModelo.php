<?php
// /modelos/UsuarioModelo.php
require_once "../config/conexion.php";

class UsuarioModelo
{
  private $db;

  public function __construct()
  {
    $this->db = Conexion::conectar();
  }

  /**
   * Verifica si ya existe un usuario con ese email
   */
  public function emailExiste(string $email): bool
  {
    $sql = "SELECT 1 FROM usuarios WHERE email = :email LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    return (bool) $stmt->fetchColumn();
  }

  /**
   * Crea el usuario y devuelve el ID insertado
   */
  public function crearUsuario(array $data): int
  {
    $sql = "INSERT INTO usuarios
      (nombre, apellidos, email, telefono, password_hash, role, status,
       email_verificado, verificacion_token, verificacion_expira,
       provider, provider_id, terms_accepted_at, created_at, updated_at)
      VALUES
      (:nombre, :apellidos, :email, :telefono, :password_hash, :role, :status,
       0, :verificacion_token, :verificacion_expira,
       :provider, :provider_id, :terms_accepted_at, NOW(), NOW())";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(":nombre", $data["nombre"], PDO::PARAM_STR);
    $stmt->bindValue(":apellidos", $data["apellidos"] ?? null, PDO::PARAM_STR);
    $stmt->bindValue(":email", $data["email"], PDO::PARAM_STR);
    $stmt->bindValue(":telefono", $data["telefono"] ?? null, PDO::PARAM_STR);
    $stmt->bindValue(":password_hash", $data["password_hash"], PDO::PARAM_STR);
    $stmt->bindValue(":role", $data["role"] ?? "paciente", PDO::PARAM_STR);
    $stmt->bindValue(":status", "activo", PDO::PARAM_STR);
    $stmt->bindValue(":verificacion_token", $data["verificacion_token"], PDO::PARAM_STR);
    $stmt->bindValue(":verificacion_expira", $data["verificacion_expira"], PDO::PARAM_STR);
    $stmt->bindValue(":provider", $data["provider"] ?? "local", PDO::PARAM_STR);
    $stmt->bindValue(":provider_id", $data["provider_id"] ?? null, PDO::PARAM_STR);
    $stmt->bindValue(":terms_accepted_at", $data["terms_accepted_at"], PDO::PARAM_STR);

    $stmt->execute();
    return (int) $this->db->lastInsertId();
  }
  /* ====== Métodos para LOGIN ====== */

  /** Trae el usuario por email (incluye password_hash y banderas de seguridad) */
  public function obtenerPorEmail(string $email): ?array
  {
    $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user ?: null;
  }

  /** Resetea intentos fallidos y marca última fecha de login */
  public function marcarLoginExitoso(int $idUsuario): void
  {
    $sql = "UPDATE usuarios
            SET failed_login_attempts = 0,
                locked_until = NULL,
                last_login_at = NOW(),
                updated_at = NOW()
            WHERE id_usuario = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(":id", $idUsuario, PDO::PARAM_INT);
    $stmt->execute();
  }

  /** Suma un intento fallido y, si excede el umbral, bloquea por X minutos */
  public function sumarIntentoFallido(int $idUsuario, int $umbral = 5, int $minBlock = 15): array
  {
    // Obtenemos conteo actual
    $sql = "SELECT failed_login_attempts FROM usuarios WHERE id_usuario = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(":id", $idUsuario, PDO::PARAM_INT);
    $stmt->execute();
    $actual = (int) $stmt->fetchColumn();
    $nuevo = $actual + 1;

    if ($nuevo >= $umbral) {
      $sql2 = "UPDATE usuarios
               SET failed_login_attempts = :nuevo,
                   locked_until = DATE_ADD(NOW(), INTERVAL :minutos MINUTE),
                   updated_at = NOW()
               WHERE id_usuario = :id";
      $stmt2 = $this->db->prepare($sql2);
      $stmt2->bindValue(":nuevo", $nuevo, PDO::PARAM_INT);
      $stmt2->bindValue(":minutos", $minBlock, PDO::PARAM_INT);
      $stmt2->bindValue(":id", $idUsuario, PDO::PARAM_INT);
      $stmt2->execute();
      return ["bloqueado" => true, "intentos" => $nuevo, "minutos" => $minBlock];
    } else {
      $sql2 = "UPDATE usuarios
               SET failed_login_attempts = :nuevo,
                   updated_at = NOW()
               WHERE id_usuario = :id";
      $stmt2 = $this->db->prepare($sql2);
      $stmt2->bindValue(":nuevo", $nuevo, PDO::PARAM_INT);
      $stmt2->bindValue(":id", $idUsuario, PDO::PARAM_INT);
      $stmt2->execute();
      return ["bloqueado" => false, "intentos" => $nuevo];
    }
  }
}
