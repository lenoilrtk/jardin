<?php
$libro_id = $_GET['libro_id'];
$titulo = $_POST['titulo']; 
$autor = $_POST['autor'];
$ilustrador = $_POST['ilustrador'];
$editorial = $_POST['editorial'];
$clasificacion = $_POST['clasificacion'];
$color = $_POST['color'];
$resumen = $_POST['resumen'];
$imagen = $_POST['imagen'];
include "./ABM/conex.php";

$sql = "UPDATE `libros_1` SET `titulo` = '$titulo', `ilustrador` = '$ilustrador', `editorial` = '$editorial', `clasificacion` = '$clasificacion', `color` = '$color', `observaciones` = 'NULL', `resumen` = '$resumen', `origen` = 'NULL', `imagen` = '$imagen' WHERE `libros_1`.`libro_id` = ".$libro_id.";";
if ($conn->query($sql) === TRUE) {
    echo "Registro actualizado correctamente";
    ?>
<meta http-equiv="refresh" content="2; url=./ABM_libro.php">
<?php    
} else {
    echo "Error al actualizar el registro: " . $conn->error;
}
?>