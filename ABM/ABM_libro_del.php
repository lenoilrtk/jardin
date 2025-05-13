<?php
$libro_id = $_GET['id'];

include "./conex.php";

$sql = "DELETE FROM `libros_1` WHERE `libros_1`.`libro_id` = $libro_id;";
if ($conn->query($sql) === TRUE) {
    echo "Eliminado con exito";
    ?>
<meta http-equiv="refresh" content="2; url=./ABM_libro.php">
<?php    
} else {
    echo "Error al eliminar: " . $conn->error;
}
?>