<?php

include_once './conex.php';
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
    crossorigin="anonymous" />

  <title>Biblioteca Virtual</title>

  <style>
    /* ...existing code... */
    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #f8f9fa;
      min-height: 100vh;
    }

    /* Navbar */
    .navbar {
      background: linear-gradient(90deg, #f5a8d2 60%, #f7c6e2 100%);
      color: #fff;
      padding: 14px 32px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 8px rgba(245, 168, 210, 0.15);
    }

    .navbar .nav-icon {
      font-size: 2rem;
      cursor: pointer;
      transition: color 0.2s;
    }

    .navbar .nav-icon:hover {
      color: #fffbe7;
    }

    .navbar span {
      margin-left: 1rem;
      font-weight: bold;
      font-size: 1.2rem;
      letter-spacing: 1px;
    }

    .navbar a,
    .navbar a:visited {
      color: #fff;
      text-decoration: none;
      margin: 0 10px;
      transition: color 0.2s;
    }

    .navbar a:hover {
      color: #fffbe7;
      text-decoration: underline;
    }

    /* Footer */
    .footer {
      background: linear-gradient(90deg, #f5a8d29f 60%, #f7c6e29f 100%);
      color: #fff;
      text-align: center;
      padding: 12px 0;
      position: fixed;
      bottom: 0;
      width: 100%;
      font-size: 1rem;
      letter-spacing: 1px;
      box-shadow: 0 -2px 8px rgba(245, 168, 210, 0.08);
    }

    /* Content */
    .content {
      padding: 32px 16px 80px 16px;
      text-align: center;
      max-width: 900px;
      margin: 0 auto;
    }

    h1 {
      font-size: 2.2rem;
      font-weight: bold;
      margin-bottom: 1.5rem;
      color: #d15fa6;
      letter-spacing: 2px;
    }

    /* Table Styles */
    .table {
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 12px rgba(245, 168, 210, 0.10);
      margin-bottom: 2rem;
    }

    .table th,
    .table td {
      vertical-align: middle !important;
      text-align: center;
      font-size: 1rem;
      padding: 12px 8px;
    }

    .table thead th {
      background: #f5a8d2;
      color: #fff;
      border-bottom: 2px solid #e6e6e6;
      font-size: 1.1rem;
      letter-spacing: 1px;
    }

    .table tbody tr {
      transition: background 0.2s;
    }

    .table tbody tr:hover {
      background: #f7e6f2;
    }

    .table-bordered {
      border: 1.5px solid #f5a8d2;
    }

    .table-group-divider>tr>td,
    .table-group-divider>tr>th {
      border-top: 1.5px solid #f5a8d2;
    }

    /* Button */
    .btn-outline-primary {
      border-color: #f5a8d2;
      color: #d15fa6;
      font-weight: 500;
      transition: background 0.2s, color 0.2s;
      margin-bottom: 10px;
    }

    .btn-outline-primary:hover {
      background: #f5a8d2;
      color: #fff;
      border-color: #f5a8d2;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .content {
        padding: 16px 4px 80px 4px;
      }

      .table th,
      .table td {
        font-size: 0.95rem;
        padding: 8px 4px;
      }

      h1 {
        font-size: 1.4rem;
      }

      .navbar {
        flex-direction: column;
        align-items: flex-start;
        padding: 10px 10px;
      }
    }

    /* Misc */
    img {
      max-height: 100px;
    }

    p {
      margin-bottom: 0.5rem;
    }

    /* ...existing code... */
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

        function displayArrayValues($array)
        {
          $stringToDisplay = "";
          for ($i = 0; $i < count($array); $i++) {
            if ($i % 2 == 0) {
              $stringToDisplay = $stringToDisplay . "<p>" . $array[$i];
            } else {
              $stringToDisplay = $stringToDisplay . " -> " . $array[$i] . "</p>";
            }
          }
          return $stringToDisplay;
        }
        function displayArray($array)
        {
          $stringToDisplay = "";
          foreach ($array as $value) {
            $stringToDisplay = $stringToDisplay . "<p>" . $value . "</p>";
          }
          return $stringToDisplay;
        }

        // Verificar si hay resultados
        if ($result->num_rows > 0) {
          // Mostrar los datos de cada fila
          while ($row = $result->fetch_assoc()) {
            $campos_modif = explode(",", $row["campos_modif"]);
            $valores_modif = explode(",", $row["valores_modif"]);
            echo "<tr>";
            echo "<th scope='row' class='align-middle'>" . $row["id_movimiento"] . "</th>";
            echo "<td class='align-middle'><p>" . $row["usuario_id"] . "</p></td>";
            echo "<td class='align-middle'><p>" . $row["tabla_modif"] . "</p></td>";
            echo "<td class='align-middle'>" . displayArray($campos_modif) . "</td>";
            echo "<td class='align-middle'>" . displayArrayValues($valores_modif) . "</td>";
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
      crossorigin="anonymous"></script>
</body>

</html>