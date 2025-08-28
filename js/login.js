// /js/login.js
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("loginForm");
  const btn = document.getElementById("submitBtn");
  const btnText = document.getElementById("btnText");
  const btnLoading = document.getElementById("btnLoading");

  if (!form) return;

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(form);
    const payload = {
      email: formData.get("email")?.trim(),
      password: formData.get("password"),
      remember: formData.get("remember") === "on",
    };

    // UI: loading
    btn.disabled = true;
    if (btnText && btnLoading) {
      btnText.classList.add("hidden");
      btnLoading.classList.remove("hidden");
    }

    try {
      const resp = await fetch("controladores/login.controlador.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload),
      });

      const data = await resp.json();

      if (!resp.ok || !data.success) {
        if (data?.errors) {
          const lista = Object.values(data.errors).join("<br>");
          Swal.fire({
            icon: "error",
            title: "Revisa tus datos",
            html: lista,
            confirmButtonColor: "#1e3a8a",
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "No se pudo iniciar sesión",
            text: data?.error || "Verifica tu correo y contraseña",
            confirmButtonColor: "#1e3a8a",
          });
        }
        return;
      }

      // Éxito
      Swal.fire({
        icon: "success",
        title: "¡Bienvenido!",
        text: "Inicio de sesión exitoso.",
        confirmButtonColor: "#1e3a8a",
      }).then(() => {
        window.location.href = data.redirect || "bienvenida.php";
      });
    } catch (err) {
      console.error(err);
      Swal.fire({
        icon: "error",
        title: "Error de conexión",
        text: "No fue posible conectar con el servidor.",
        confirmButtonColor: "#1e3a8a",
      });
    } finally {
      btn.disabled = false;
      if (btnText && btnLoading) {
        btnLoading.classList.add("hidden");
        btnText.classList.remove("hidden");
      }
    }
  });
});

// Toggle de contraseña (ya tienes el botón en tu HTML)
function togglePassword() {
  const input = document.getElementById("password");
  const icon = document.getElementById("eyeIcon");
  if (!input || !icon) return;

  if (input.type === "password") {
    input.type = "text";
    icon.setAttribute("data-lucide", "eye-off");
  } else {
    input.type = "password";
    icon.setAttribute("data-lucide", "eye");
  }
  if (window.lucide) window.lucide.createIcons();
}
