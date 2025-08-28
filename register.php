<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agenda Master - Registro</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
  <style>
    .font-lato { font-family: 'Lato', sans-serif; }
    .font-montserrat { font-family: 'Montserrat', sans-serif; }
  </style>
</head>
<body class="font-lato min-h-screen bg-slate-50 flex items-center justify-center px-4 py-6">
  <div class="w-full max-w-md">
    <!-- Logo y título -->
    <div class="text-center mb-8">
      <div class="w-16 h-16 mx-auto bg-blue-700 rounded-full flex items-center justify-center mb-4 shadow-md">
        <i data-lucide="stethoscope" class="h-8 w-8 text-white"></i>
      </div>
      <h1 class="text-3xl font-extrabold tracking-tight text-blue-800 font-montserrat mb-2">Agenda Master</h1>
      <p class="text-slate-600 font-medium">Crea tu cuenta para comenzar</p>
    </div>

    <!-- Formulario de registro -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
      <form id="registerForm" class="space-y-6">
        
        <!-- Nombre -->
        <div>
          <label for="nombre" class="block text-lg font-semibold text-blue-900 font-montserrat mb-3">Nombre</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i data-lucide="user" class="h-5 w-5 text-slate-400"></i>
            </div>
            <input id="nombre" name="nombre" type="text" placeholder="Tu nombre"
              class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-700 placeholder-slate-400 
              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 font-medium" required />
          </div>
        </div>

        <!-- Apellidos -->
        <div>
          <label for="apellidos" class="block text-lg font-semibold text-blue-900 font-montserrat mb-3">Apellidos</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i data-lucide="user-round" class="h-5 w-5 text-slate-400"></i>
            </div>
            <input id="apellidos" name="apellidos" type="text" placeholder="Tus apellidos"
              class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-700 placeholder-slate-400 
              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 font-medium" />
          </div>
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-lg font-semibold text-blue-900 font-montserrat mb-3">Correo Electrónico</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i data-lucide="mail" class="h-5 w-5 text-slate-400"></i>
            </div>
            <input id="email" name="email" type="email" placeholder="tu@email.com"
              class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-700 placeholder-slate-400 
              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 font-medium" required />
          </div>
        </div>

        <!-- Teléfono -->
        <div>
          <label for="telefono" class="block text-lg font-semibold text-blue-900 font-montserrat mb-3">Teléfono</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i data-lucide="phone" class="h-5 w-5 text-slate-400"></i>
            </div>
            <input id="telefono" name="telefono" type="tel" placeholder="+52 55 1234 5678"
              class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-700 placeholder-slate-400 
              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 font-medium" />
          </div>
        </div>

        <!-- Contraseña -->
        <div>
          <label for="password" class="block text-lg font-semibold text-blue-900 font-montserrat mb-3">Contraseña</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i data-lucide="lock" class="h-5 w-5 text-slate-400"></i>
            </div>
            <input id="password" name="password" type="password" placeholder="Crea una contraseña segura"
              class="w-full pl-10 pr-12 py-3 rounded-xl border border-slate-200 bg-white text-slate-700 placeholder-slate-400 
              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 font-medium" required />
            <button type="button" onclick="togglePassword()"
              class="absolute inset-y-0 right-0 pr-3 flex items-center hover:bg-slate-50 rounded-r-xl transition-all duration-200">
              <i id="eyeIcon" data-lucide="eye" class="h-5 w-5 text-slate-400 hover:text-slate-600"></i>
            </button>
          </div>
        </div>

        <!-- Confirmar Contraseña -->
        <div>
          <label for="password_confirm" class="block text-lg font-semibold text-blue-900 font-montserrat mb-3">Confirmar contraseña</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i data-lucide="lock" class="h-5 w-5 text-slate-400"></i>
            </div>
            <input id="password_confirm" name="password_confirm" type="password" placeholder="Repite tu contraseña"
              class="w-full pl-10 pr-12 py-3 rounded-xl border border-slate-200 bg-white text-slate-700 placeholder-slate-400 
              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 font-medium" required />
          </div>
        </div>

        <!-- Aceptar términos -->
        <div class="flex items-start gap-3">
          <input id="terms" name="terms" type="checkbox" required
            class="mt-1 h-5 w-5 rounded border-slate-300 
         checked:bg-blue-700 checked:border-blue-700 
         checked:text-white focus:ring-blue-700">
          <label for="terms" class="text-slate-700">
            Acepto los <a href="/terminos" class="text-blue-700 hover:underline">Términos y Condiciones</a>
            y el <a href="/privacidad" class="text-blue-700 hover:underline">Aviso de Privacidad</a>.
          </label>
        </div>

        <!-- Provider oculto -->
        <input type="hidden" name="provider" value="local">

        <!-- Botón de registro -->
        <button type="submit" id="submitBtn"
          class="w-full h-12 rounded-xl bg-blue-700 text-white text-lg font-semibold transition-all duration-200 border-0 shadow-md hover:bg-blue-800 cursor-pointer">
          Crear Cuenta
        </button>
      </form>

      <!-- Enlace a login -->
      <div class="mt-6 text-center">
        <p class="text-slate-600 font-medium">
          ¿Ya tienes una cuenta?
          <a href="login.php" class="text-blue-700 hover:text-blue-800 font-semibold hover:underline">Inicia sesión aquí</a>
        </p>
      </div>
    </div>

    <!-- Footer -->
    <div class="mt-8 text-center text-slate-500 text-sm font-medium">
      <p>© 2025 Odonto365. Todos los derechos reservados.</p>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="js/register.js"></script>

  <script>
    lucide.createIcons();
    function togglePassword() {
      const input = document.getElementById("password");
      const icon = document.getElementById("eyeIcon");
      if (input.type === "password") {
        input.type = "text";
        icon.setAttribute("data-lucide", "eye-off");
      } else {
        input.type = "password";
        icon.setAttribute("data-lucide", "eye");
      }
      lucide.createIcons();
    }
  </script>
</body>
</html>
