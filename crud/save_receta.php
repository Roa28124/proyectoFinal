<?php
require_once('modelos/conexion.php');

$nombre = $_POST['nombre'];
$tiempo = $_POST['tiempo_preparacion'];
$dificultad = $_POST['dificultad'];
$porciones = $_POST['porciones'];
$categoria = $_POST['categoria'];

$verificarReceta = $cnn->prepare("SELECT * FROM recetas WHERE BINARY nombre = ?");
$verificarReceta->execute([$nombre]);
$existe = $verificarReceta->rowCount();

if ($existe > 0) {
    echo "<script>
        alert('Esta receta ya está registrada en tu libro.');
        location.href='form_receta.php';
    </script>";
    exit();
}

$sentencia = $cnn->prepare("INSERT INTO recetas (nombre, tiempo_preparacion, dificultad, porciones, categoria) VALUES (?, ?, ?, ?, ?)");

$resultado = $sentencia->execute([$nombre, $tiempo, $dificultad, $porciones, $categoria]);

if ($resultado) {
    echo "<script>
        alert('Receta agregada con éxito a tu libro.');
        location.href='index.php';
    </script>";
} else {
    echo "<script>
        alert('Error al registrar la receta: " . $sentencia->errorInfo()[2] . "');
        location.href='form_receta.php';
    </script>";
}
?>