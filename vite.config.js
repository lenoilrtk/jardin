import { defineConfig } from "vite";
import { resolve } from "path";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
  root: "resources", // Establece 'src' como la ruta base
  base: "/assets/",
  build: {
    // Directorio de salida (relativo al root)
    outDir: "../public/assets",

    // Limpiar directorio antes del build
    emptyOutDir: true,

    // CRÍTICO: Generar manifest.json para mapear archivos
    manifest: true,

    // Configuración de Rollup
    rollupOptions: {
      input: {
        // Archivos de entrada
        app: resolve(__dirname, "resources/js/app.js"),
        main: resolve(__dirname, "resources/css/app.css"),
      },
    },
  },
  plugins: [tailwindcss()],
});
