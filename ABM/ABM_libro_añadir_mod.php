<?php
$titulo = $_POST['titulo']; 
$autor = $_POST['autor'];
$ilustrador = $_POST['ilustrador'];
$editorial = $_POST['editorial'];
$clasificacion = $_POST['clasificacion'];
$color = $_POST['color'];
$resumen = $_POST['resumen'];
$imagen = $_POST['imagen'];
include "./conex.php";

$sql = "INSERT INTO `libros_1` (`libro_id`, `titulo`, `autor`, `ilustrador`, `editorial`, `clasificacion`, `color`, `observaciones`, `resumen`, `origen`, `imagen`) VALUES (NULL, '$titulo', '$autor', '$ilustrador', '$editorial', '$clasificacion', '$color', 'NULL', '$resumen', 'NULL', '$imagen');";
if ($conn->query($sql) === TRUE) {
    echo "Añadido correctamente";
    ?>
<meta http-equiv="refresh" content="2; url=./ABM_libro.php">
<?php    
} else {
    echo "Error: " . $conn->error;
}
?>