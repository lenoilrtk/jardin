import { defineConfig } from "vite";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
  root: "src", // Establece 'src' como la ruta base
  plugins: [tailwindcss()],
});
