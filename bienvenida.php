<?php
// /bienvenida.php
session_start();
$usuario = $_SESSION["usuario"] ?? null;
if (!$usuario) {
  header("Location: login.php");
  exit();
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Bienvenido</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center">
  <div class="bg-white border border-slate-200 rounded-2xl p-8 shadow-sm text-center">
    <h1 class="text-2xl font-bold text-blue-800 mb-2">¡Hola, <?php echo htmlspecialchars(
      $usuario["nombre"]
    ); ?>!</h1>
    <p class="text-slate-600 mb-6">Has iniciado sesión correctamente.</p>
    <div class="flex gap-4 justify-center">
      <a href="perfil.php" class="px-4 py-2 rounded-xl bg-blue-700 text-white hover:bg-blue-800">Ir a mi perfil</a>
      <button id="logoutBtn" class="px-4 py-2 rounded-xl bg-red-600 text-white hover:bg-red-700">Cerrar sesión</button>
    </div>
  </div>

  <script>
    document.getElementById("logoutBtn").addEventListener("click", async () => {
      const res = await fetch("logout.php", { method: "POST" });
      const data = await res.json();

      if (data.success) {
        Swal.fire({
          icon: "success",
          title: "Sesión cerrada",
          text: "Has cerrado sesión correctamente",
          confirmButtonColor: "#1e3a8a"
        }).then(() => {
          window.location.href = "login.php";
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: data.error || "No se pudo cerrar sesión",
          confirmButtonColor: "#1e3a8a"
        });
      }
    });
  </script>
</body>
</html>

