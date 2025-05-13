<?php

  include_once './ABM/conex.php';
  session_start();

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
    crossorigin="anonymous"
  />

  <title>Biblioteca Virtual</title>
  
  <style>
    /* Estilos generales */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    /* Barra de navegación */
    .navbar {
      background-color: #f5a8d2;
      color: white;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .navbar .nav-icon {
      font-size: 1.5rem;
      cursor: pointer;
    }

    .navbar span {
      margin-left: 1rem;
      font-weight: bold;
    }

    .navbar a,
    .navbar a:visited {
      color: white;
      text-decoration: none;
      margin: 0 10px;
    }
    .navbar a:hover {
      text-decoration: underline;
    }

    /* Footer */
    .footer {
      background-color: #f5a8d29f;
      color: white;
      text-align: center;
      padding: 10px 0;
      position: fixed;
      bottom: 0;
      width: 100%;
    }

    /* Contenido */
    .content {
      padding: 20px;
      text-align: center;
    }

    h1 {
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 1rem;
    }

    /* Sección de “Términos y condiciones” */
    .terms-container {
      margin-top: 1rem;
      margin-bottom: 2rem;
    }
    .terms-container p {
      margin: 0;
      font-size: 1rem;
      color: #555;
    }
    .terms-container a {
      color: #f5a8d2;
      text-decoration: underline;
      font-weight: bold;
    }
    .terms-container a:hover {
      color: #f5a8d2;
    }

    /* Sección de géneros literarios */
    .genre-section {
      margin-top: 3rem;
      margin-bottom: 3rem;
    }

    /* Ajusta el tamaño de las imágenes (placeholders) si lo deseas */
    .genre-image {
      max-width: 100%;
      height: auto;
      border: 1px solid #aaa;
    }

    /* Tarjetas de Libros Populares */
    .card-img-top {
      max-height: 180px;
      object-fit: cover;
    }

    /* Ajustes en móvil para el carousel y tarjetas */
    @media (max-width: 768px) {
      .card-img-top {
        max-height: 150px;
      }

    
    }
    img {
        max-height: 100px;
      }
  </style>
</head>

<body>

  <!-- NAVBAR -->
  <div class="navbar">
    <div class="nav-icon">☰</div>
    <div>
      <span>¡Hola, Lionel!</span>
    </div>
  </div>

  <!-- CONTENIDO PRINCIPAL -->
  <div class="content">
    <h1>Log</h1>

        <button type="button" class="btn btn-outline-primary">Volver</button>
        <br><br>
    <table class="table table-bordered border-black">
        <thead>
          <tr>
            <th scope="col">ID Movimiento</th>
            <th scope="col">ID Usuario</th>
            <th scope="col">Tabla Modificada</th>
            <th scope="col">Campos Modificados</th>
            <th scope="col">Valores Modificados</th>
            <th scope="col">Fecha</th>
          </tr>
        </thead>
        <tbody class="table-group-divider">
          <?php
            // Consulta para obtener los movimientos
            $sql = "SELECT * FROM movimientos";
            $result = $conn->query($sql);

            // Verificar si hay resultados
            if ($result->num_rows > 0) {
              // Mostrar los datos de cada fila
              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<th scope='row' class='align-middle'>" . $row["id_movimiento"] . "</th>";
                echo "<td class='align-middle'><p>" . $row["usuario_id"] . "</p></td>";
                echo "<td class='align-middle'><p>" . $row["tabla_modif"] . "</p></td>";
                echo "<td class='align-middle'><p>" . $row["campos_modif"] . "</p></td>";
                echo "<td class='align-middle'><p>" . $row["valores_modif"] . "</p></td>";
                echo "<td class='align-middle'><p>" . $row["fecha"] . "</p></td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='6'>No se encontraron movimientos.</td></tr>";
            }

            // Cerrar la conexión
            $conn->close();

          ?>
        </tbody>
      </table>
    

  <!-- FOOTER -->
  <div class="footer">

  </div>

  <!-- Bootstrap JS -->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"
  ></script>
</body>
</html>