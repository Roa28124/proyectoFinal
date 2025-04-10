<?php
require_once('modelos/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_receta'];
    $nombre = $_POST['nombre'];
    $tiempo = $_POST['tiempo_preparacion'];
    $dificultad = $_POST['dificultad'];
    $porciones = $_POST['porciones'];
    $categoria = $_POST['categoria'];
    
    try {
        $stmt = $cnn->prepare("UPDATE recetas SET nombre = ?, tiempo_preparacion = ?, dificultad = ?, porciones = ?, categoria = ? WHERE id_receta = ?");
        $resultado = $stmt->execute([$nombre, $tiempo, $dificultad, $porciones, $categoria, $id]);
        
        if ($resultado) {
            header("Location: index.php?actualizado=1");
        } else {
            header("Location: form_receta.php?id=$id&error=1");
        }
    } catch (PDOException $e) {
        header("Location: form_receta.php?id=$id&error=1");
    }
} else {
    header("Location: index.php");
}
exit();
?>