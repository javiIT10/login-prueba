// /js/register.js
// /js/register.js
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("registerForm");
  const btn = document.getElementById("submitBtn");

  if (!form) return;

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(form);
    const payload = {
      nombre: formData.get("nombre")?.trim(),
      apellidos: formData.get("apellidos")?.trim(),
      email: formData.get("email")?.trim(),
      telefono: formData.get("telefono")?.trim(),
      password: formData.get("password"),
      password_confirm: formData.get("password_confirm"),
      terms: formData.get("terms") === "on",
      provider: formData.get("provider") || "local",
    };

    // Cambiar estado del botón
    btn.disabled = true;
    const originalText = btn.textContent;
    btn.textContent = "Creando cuenta...";

    try {
      const resp = await fetch("controladores/registro.controlador.php", {
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
            title: "Revisa el formulario",
            html: lista,
            confirmButtonColor: "#1e3a8a",
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: data?.error || "No se pudo crear la cuenta",
            confirmButtonColor: "#1e3a8a",
          });
        }
        return;
      }

      // Éxito
      Swal.fire({
        icon: "success",
        title: "¡Cuenta creada!",
        text: "Revisa tu correo para verificar tu email.",
        confirmButtonColor: "#1e3a8a",
      }).then(() => {
        // Redirigir después de cerrar alerta
        window.location.href = "login.php";
      });
    } catch (err) {
      console.error(err);
      Swal.fire({
        icon: "error",
        title: "Error de conexión",
        text: "Ocurrió un problema al enviar los datos. Intenta nuevamente.",
        confirmButtonColor: "#1e3a8a",
      });
    } finally {
      btn.disabled = false;
      btn.textContent = originalText;
    }
  });
});
