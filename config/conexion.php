<?php
class Conexion
{
  public static function conectar()
  {
    try {
      $link = new PDO("mysql:host=localhost;dbname=login", "root", "");
      $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $link->exec("set names utf8mb4");

      return $link;
    } catch (PDOException $e) {
      die("Error de conexión: " . $e->getMessage());
    }
  }
}
