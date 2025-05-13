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
  <?php include "./ABM/conex.php" ?>
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
    <h1>ABM</h1>
    
    <button type="button" class="btn btn-outline-primary">Volver</button>
    <button type="button" class="btn btn-outline-success">Añadir Libro</button>
    <br><br>
      <label class="form-label">Fila</label>
      <?php
      $lista = 1;
      echo'
      <form action="ABM_libro.php" method="GET">
      <select class="form-select mb-3" name="pagina">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
    <input type="submit">
    '
    ?>
  </select>
    <div class="table-responsive">
    <table class="table table-sm table-bordered border-black table-striped table-hover">
      <thead class="table-light">
      <tr>
      <th scope="col">ID</th>
      <th scope="col">Imagen</th>
      <th scope="col">Titulo</th>
      <th scope="col">Autor</th>
      <th scope="col">Ilustrador</th>
      <th scope="col">Editorial</th>
      <th scope="col">Clasificación</th>
      <th scope="col">Color</th>
      <th scope="col">Resumen</th>
      <th scope="col">Modificar</th>
      <th scope="col">Eliminar</th>
      </tr>
      </thead>
      <tbody class="table-group-divider">
      <?php
      $limite = 99; // Número de resultados por página
      $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : $lista; // Página actual
      $offset = ($pagina - 1) * $limite; // Calcular el desplazamiento

      $sql = "SELECT * FROM `libros_1` LIMIT $limite OFFSET $offset";
      $result = $conn->query($sql);

      
        while ($row = $result->fetch_assoc()) {
        echo '
        <tr>
        <th scope="row" class="align-middle text-center">' . $row["libro_id"] . '</th>
        <td class="align-middle text-center"><img src="'.$row["imagen"].'" alt="Imagen" style="max-height: 50px; max-width: 50px;"></td>
        <td class="align-middle text-wrap"><p style="max-width: 80px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $row["titulo"] . '</p></td>
        <td class="align-middle text-wrap"><p style="max-width: 80px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $row["autor"] . '</p></td>
        <td class="align-middle text-wrap"><p style="max-width: 80px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $row["ilustrador"] . '</p></td>
        <td class="align-middle text-wrap"><p style="max-width: 80px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $row["editorial"] . '</p></td>
        <td class="align-middle text-wrap"><p style="max-width: 80px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $row["clasificacion"] . '</p></td>
        <td class="align-middle text-wrap"><p style="max-width: 80px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $row["color"] . '</p></td>
        <td class="align-middle text-wrap"><p style="max-width: 80px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $row["resumen"] . '</p></td>
        <td class="align-middle text-center"><a href="./ABM_libro_edit.php?id='.$row["libro_id"].'"><button type="button" class="btn btn-sm btn-outline-primary">Modificar</button></a></td>
        <td class="align-middle text-center"><a href="./ABM_libro_del.php?id='.$row["libro_id"].'"><button type="button" class="btn btn-sm btn-outline-danger">Borrar</button></a></td>  
        </tr>
        ';
        }
      ?>
      </tbody>
      </table>
    </div>
    
    </div>
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