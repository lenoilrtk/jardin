<?php
include_once './conex.php';
session_start();

function mostrarCambiosHorizontal($camposStr, $valoresStr)
{
  $campos = explode(",", $camposStr);
  $valores = explode(",", $valoresStr);
  $esAgregado = true;

  // Verifica si todos los valores anteriores son "nulo"
  for ($i = 0; $i < count($valores); $i += 2) {
    if (trim(strtolower($valores[$i])) !== "nulo") {
      $esAgregado = false;
      break;
    }
  }

  // Comienza tabla interna
  $output = "<div style='overflow-x:auto;'>
    <table class='table table-sm table-bordered' style='min-width:800px;'>
      <thead class='table-light'>
        <tr>
          <th colspan='" . ($esAgregado ? 2 : 3) . "' class='text-" . ($esAgregado ? "success" : "primary") . "'>
            " . ($esAgregado ? "Registro agregado" : "Registro editado") . "
          </th>
        </tr>
        <tr>
          <th>Campo</th>" .
    (!$esAgregado ? "<th>Valor anterior</th>" : "") .
    "<th>Valor nuevo</th>
        </tr>
      </thead>
      <tbody>";

  for ($i = 0, $j = 0; $i < count($campos); $i++, $j += 2) {
    $campo = htmlspecialchars($campos[$i]);
    $valorAnt = isset($valores[$j]) ? trim($valores[$j]) : '-';
    $valorNuevo = isset($valores[$j + 1]) ? trim($valores[$j + 1]) : '-';

    $campoHTML = "<td style='word-break: break-word;'>$campo</td>";
    $valorAntHTML = "<td style='word-break: break-word; color:#6c757d;'>"
      . ($valorAnt === 'nulo' ? '—' : htmlspecialchars($valorAnt)) . "</td>";
    $valorNuevoHTML = "<td style='word-break: break-word; color:#d15fa6;'>"
      . htmlspecialchars($valorNuevo) . "</td>";

    $output .= "<tr>" . $campoHTML .
      (!$esAgregado ? $valorAntHTML : "") .
      $valorNuevoHTML . "</tr>";
  }

  $output .= "</tbody></table></div>";
  return $output;
}


$sql = "SELECT * FROM movimientos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Biblioteca Virtual</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous" />

  <style>
    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      background: #f8f9fa;
      margin: 0;
      padding: 0;
      min-height: 100vh;
    }

    .navbar {
      background: linear-gradient(90deg, #f5a8d2 60%, #f7c6e2 100%);
      padding: 14px 32px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 8px rgba(245, 168, 210, 0.15);
    }

    .nav-icon {
      font-size: 2rem;
      cursor: pointer;
    }

    .navbar span {
      margin-left: 1rem;
      font-weight: bold;
      font-size: 1.2rem;
    }

    .navbar a {
      color: #fff;
      text-decoration: none;
      margin: 0 10px;
    }

    .navbar a:hover {
      text-decoration: underline;
      color: #fffbe7;
    }

    .footer {
      background: linear-gradient(90deg, #f5a8d29f 60%, #f7c6e29f 100%);
      color: #fff;
      text-align: center;
      padding: 12px 0;
      position: fixed;
      bottom: 0;
      width: 100%;
      font-size: 1rem;
      box-shadow: 0 -2px 8px rgba(245, 168, 210, 0.08);
    }

    .content {
      padding: 0;
      max-width: 100%;
      margin: 0 0;
      text-align: center;
    }

    h1 {
      font-size: 2.2rem;
      font-weight: bold;
      margin-bottom: 1.5rem;
      color: #d15fa6;
    }

    .table {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 12px rgba(245, 168, 210, 0.1);
      margin-bottom: 2rem;
    }

    .table thead th {
      background: #f5a8d2;
      color: #fff;
      font-size: 1.1rem;
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

    .btn-outline-primary {
      border-color: #f5a8d2;
      color: #d15fa6;
      font-weight: 500;
      margin-bottom: 10px;
    }

    .btn-outline-primary:hover {
      background: #f5a8d2;
      color: #fff;
    }

    @media (max-width: 768px) {
      .content {
        padding: 0;
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
        padding: 10px;
      }
    }

    td div {
      word-break: break-word;
      font-size: 0.95rem;
    }

    img {
      max-height: 100px;
    }

    p {
      margin-bottom: 0.5rem;
    }

    /* Estilo base de tabla */
    .table-wrapper {
      overflow-x: auto;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
      margin-bottom: 2rem;
      background: white;
      width: 100%;
    }

    .table-custom {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      border: 1.5px solid #f5a8d2;
      border-radius: 12px;
      overflow: hidden;
    }

    .table-custom thead th {
      position: sticky;
      top: 0;
      background-color: #f5a8d2;
      color: #fff;
      text-align: center;
      padding: 12px;
      cursor: pointer;
      user-select: none;
      font-size: 1rem;
      letter-spacing: 1px;
    }

    .table-custom tbody td {
      text-align: center;
      padding: 12px;
      vertical-align: middle;
      border-top: 1px solid #f3d1e4;
      font-size: 0.95rem;
      color: #333;
      max-width: 180px;
      word-wrap: break-word;
      overflow-y: auto;
    }

    .table-custom tbody tr:hover {
      background-color: #fcebf5;
    }

    /* Scroll interno para celdas largas */
    .table-custom td p {
      margin: 0.25rem 0;
      max-height: 100px;
      overflow-y: auto;
      word-break: break-word;
    }

    .table td,
    .table th {
      vertical-align: middle;
      word-break: break-word;
      white-space: normal;
    }

    .table td[colspan="2"] {
      min-width: 600px;
      max-width: 1000px;
      word-break: break-word;
      white-space: normal;
      padding: 0 !important;
    }

    @media (min-width: 992px) {
      .table td[colspan="2"] {
        width: 60vw;
      }
    }

    .table td[colspan="2"] table {
      width: 100%;
    }

    .table td[colspan="2"] th,
    .table td[colspan="2"] td {
      font-size: 0.9rem;
      padding: 6px 8px;
      vertical-align: top;
    }
  </style>
</head>

<body>

  <div class="navbar">
    <div class="nav-icon">☰</div>
    <div><span>¡Hola, Lionel!</span></div>
  </div>

  <div class="content">
    <h1>Log</h1>

    <button type="button" class="btn btn-outline-primary">Volver</button>
    <br><br>

    <div class="table-wrapper">
      <table class="table-custom">
        <thead>
          <tr>
            <th style="width: 5%;">ID</th>
            <th style="width: 10%;">Usuario</th>
            <th style="width: 15%;">Tabla</th>
            <th colspan="2" style="width: 50%;">Cambios Realizados</th>
            <th style="width: 20%;">Fecha</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $row["id_movimiento"] ?></td>
                <td>
                  <p><?= $row["usuario_id"] ?></p>
                </td>
                <td>
                  <p><?= $row["tabla_modif"] ?></p>
                </td>
                <td class='align-middle' colspan='2'><?= mostrarCambiosHorizontal($row["campos_modif"], $row["valores_modif"]) ?></td>
                <td>
                  <p><?= $row["fecha"] ?></p>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="6">No se encontraron movimientos.</td>
            </tr>
          <?php endif; ?>
          <?php $conn->close(); ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="footer"></div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const table = document.querySelector('.table-custom');
      const headers = table.querySelectorAll('th');
      let sortDirection = 1; // 1: asc, -1: desc
      let lastIndex = -1;

      headers.forEach((header, index) => {
        header.addEventListener('click', () => {
          const tbody = table.querySelector('tbody');
          const rows = Array.from(tbody.querySelectorAll('tr'));

          if (lastIndex === index) {
            sortDirection *= -1; // reverse order
          } else {
            sortDirection = 1;
          }

          lastIndex = index;

          rows.sort((a, b) => {
            const cellA = a.children[index].innerText.trim().toLowerCase();
            const cellB = b.children[index].innerText.trim().toLowerCase();

            // Comparar números si ambos valores son numéricos
            const isNumeric = !isNaN(cellA) && !isNaN(cellB);
            if (isNumeric) {
              return sortDirection * (parseFloat(cellA) - parseFloat(cellB));
            }

            return sortDirection * cellA.localeCompare(cellB);
          });

          // Reordenar las filas
          rows.forEach(row => tbody.appendChild(row));
        });
      });
    });
  </script>
</body>

</html>