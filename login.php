<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Agenda Master - Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Montserrat:wght@400;500;600;700;800;900&display=swap"
      rel="stylesheet"
    />
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
      .font-lato {
        font-family: "Lato", sans-serif;
      }
      .font-montserrat {
        font-family: "Montserrat", sans-serif;
      }
    </style>
  </head>
  <body class="font-lato flex min-h-screen items-center justify-center bg-slate-50 px-4 py-6">
    <div class="w-full max-w-md">
      <!-- Logo y título -->
      <div class="mb-8 text-center">
        <div
          class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-blue-700 shadow-md"
        >
          <i data-lucide="stethoscope" class="h-8 w-8 text-white"></i>
        </div>
        <h1 class="font-montserrat mb-2 text-3xl font-extrabold tracking-tight text-blue-800">
          Odonto365
        </h1>
        <p class="font-medium text-slate-600">Inicia sesión para acceder a tu cuenta</p>
      </div>

      <!-- Formulario de login -->
      <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <form id="loginForm" method="POST" class="space-y-6">
          <!-- Agregar token CSRF para seguridad -->
          <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>" />

          <!-- Campo de email -->
          <div>
            <label
              for="email"
              class="font-montserrat mb-3 block text-lg font-semibold text-blue-900"
            >
              Correo Electrónico
            </label>
            <div class="relative">
              <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <i data-lucide="mail" class="h-5 w-5 text-slate-400"></i>
              </div>
              <input
                id="email"
                name="email"
                type="email"
                value=""
                class="w-full rounded-xl border border-slate-200 bg-white py-3 pr-4 pl-10 font-medium text-slate-700 placeholder-slate-400 transition-all duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="tu@email.com"
                required
              />
            </div>
          </div>

          <!-- Campo de contraseña -->
          <div>
            <label
              for="password"
              class="font-montserrat mb-3 block text-lg font-semibold text-blue-900"
            >
              Contraseña
            </label>
            <div class="relative">
              <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <i data-lucide="lock" class="h-5 w-5 text-slate-400"></i>
              </div>
              <input
                id="password"
                name="password"
                type="password"
                class="w-full rounded-xl border border-slate-200 bg-white py-3 pr-12 pl-10 font-medium text-slate-700 placeholder-slate-400 transition-all duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Tu contraseña"
                required
              />
              <button
                type="button"
                onclick="togglePassword()"
                class="absolute inset-y-0 right-0 flex items-center rounded-r-xl pr-3 transition-all duration-200 hover:bg-slate-50"
              >
                <i
                  id="eyeIcon"
                  data-lucide="eye"
                  class="h-5 w-5 text-slate-400 hover:text-slate-600"
                ></i>
              </button>
            </div>
          </div>

          <!-- Recordarme y olvidé contraseña -->
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input
                id="remember"
                name="remember"
                type="checkbox"
                class="h-4 w-4 rounded border-slate-300 text-blue-600 transition-all duration-200 focus:ring-blue-500"
              />
              <label for="remember" class="ml-2 cursor-pointer font-medium text-slate-600">
                Recordarme
              </label>
            </div>
            <button
              type="button"
              class="font-medium text-blue-700 transition-all duration-200 hover:text-blue-800 hover:underline"
            >
              ¿Olvidaste tu contraseña?
            </button>
          </div>

          <!-- Botón de iniciar sesión -->
          <button
            type="submit"
            id="submitBtn"
            class="h-12 w-full rounded-xl border-0 bg-blue-700 text-lg font-semibold text-white shadow-md transition-all duration-200 hover:bg-blue-800 hover:shadow-lg active:bg-blue-900"
          >
            <span id="btnText">Iniciar Sesión</span>
            <span id="btnLoading" class="hidden">
              <i data-lucide="loader-2" class="mr-2 inline h-5 w-5 animate-spin"></i>
              Iniciando sesión...
            </span>
          </button>
        </form>

        <!-- Separador -->
        <div class="relative my-6">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-slate-200"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="bg-white px-4 font-medium text-slate-500">o continúa con</span>
          </div>
        </div>

        <!-- Botones de redes sociales -->
        <div class="grid grid-cols-2 gap-3">
          <button
            type="button"
            class="flex h-11 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-transparent font-medium transition-all duration-200 hover:border-slate-300 hover:bg-slate-50"
          >
            <svg class="h-5 w-5" viewBox="0 0 24 24">
              <path
                fill="currentColor"
                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
              />
              <path
                fill="currentColor"
                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
              />
              <path
                fill="currentColor"
                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
              />
              <path
                fill="currentColor"
                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
              />
            </svg>
            Google
          </button>
          <button
            type="button"
            class="flex h-11 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-transparent font-medium transition-all duration-200 hover:border-slate-300 hover:bg-slate-50"
          >
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"
              />
            </svg>
            Facebook
          </button>
        </div>

        <!-- Enlace de registro -->
        <div class="mt-6 text-center">
          <p class="font-medium text-slate-600">
            ¿No tienes una cuenta?
            <a
              href="register.php"
              class="font-semibold text-blue-700 transition-all duration-200 hover:text-blue-800 hover:underline"
            >
              Regístrate aquí
            </a>
          </p>
        </div>
      </div>

      <!-- Footer -->
      <div class="mt-8 text-center text-sm font-medium text-slate-500">
        <p>© 2025 Odonto365. Todos los derechos reservados.</p>
      </div>
    </div>

      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/login.js"></script>
    <script>
      lucide.createIcons();
    </script>
  </body>
</html>
