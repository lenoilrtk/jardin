<?php

// Función para limpiar y validar datos
function limpiarDato($dato)
{
    return htmlspecialchars(strip_tags(trim($dato)));
}

// Función para validar URL de imagen
function validarURL($url)
{
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}

// Validar ID
$usuario_id = filter_var($_GET['usuario_id'], FILTER_VALIDATE_INT);

// Recoger y validar datos
$usuario_id = limpiarDato($_POST['usuario_id'] ?? '');
$contraseña = limpiarDato($_POST['contraseña'] ?? '');
$nivel = limpiarDato($_POST['nivel'] ?? '');

// Incluir conexión a la base de datos
include "./conex.php";

// Obtener datos actuales del libro para comparar cambios
$sqlActual = "SELECT * FROM `usuarios` WHERE `usuario_id` LIKE ?";
$stmtActual = $conn->prepare($sqlActual);
$stmtActual->bind_param("i", $usuario_id);
$stmtActual->execute();
$resultActual = $stmtActual->get_result();

$datosActuales = $resultActual->fetch_assoc();
$stmtActual->close();

// Preparar la consulta SQL con prepared statement

$sql =  "UPDATE `usuarios` SET `usuario_id` = ?, `contraseña` = ?, `nivel` = ? WHERE `usuarios`.`usuario_id` = ?";
$stmt = $conn->prepare($sql);

// Vincular parámetros
$stmt->bind_param("sssi", $usuario_id, $contraseña, $nivel, $datosActuales['usuario_id']);

// Ejecutar la consulta
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {

        // Detectar y mostrar cambios realizados
        $cambios = [];
        if ($datosActuales['usuario_id'] != $usuario_id) $cambios[] = ['campo' => 'usuario_id', 'anterior' => $datosActuales['usuario_id'], 'nuevo' => $usuario_id];
        if ($datosActuales['contraseña'] != $contraseña) $cambios[] = ['campo' => 'contraseña', 'anterior' => $datosActuales['contraseña'], 'nuevo' => $contraseña];
        if ($datosActuales['nivel'] != $nivel) $cambios[] = ['campo' => 'nivel', 'anterior' => $datosActuales['nivel'], 'nuevo' => $nivel];
        $query = "INSERT INTO `movimientos` (`usuario_id`, `tabla_modif`, `campos_modif`, `valores_modif`, `fecha`) VALUES (?, 'usuarios', ?, ?, NOW())";
        $campos_modif = implode(',', array_column($cambios, 'campo'));
        $valores_modif = implode(',', array_map(function ($c) {
            return $c['anterior'] . ',' . $c['nuevo'];
        }, $cambios));
        $stmtMov = $conn->prepare($query);
        $stmtMov->bind_param("iss", $usuario_id, $campos_modif, $valores_modif);
        $stmtMov->execute();
        $stmtMov->close();

        // Cerrar statement y conexión
        $stmt->close();
        $conn->close();
    }
}
