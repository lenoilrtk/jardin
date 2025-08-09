import "/Resources/css/tailwind.css";

// Configurar hot reload para desarrollo
if (import.meta.env.DEV) {
  import.meta.hot?.accept();
}

// Tu código JavaScript
console.log("🚀 Aplicación cargada");

// Ejemplo de funcionalidad
document.addEventListener("DOMContentLoaded", function () {
  console.log("DOM listo");

  // Ejemplo: manejar clicks
  const buttons = document.querySelectorAll(".btn");
  buttons.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      console.log("Botón clickeado:", e.target);
    });
  });
});
