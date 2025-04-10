<?php
require_once('modelos/conexion.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $stmt = $cnn->prepare("DELETE FROM recetas WHERE id_receta = ?");
        $resultado = $stmt->execute([$id]);
        
        if ($resultado) {
            header("Location: index.php?eliminado=1");
        } else {
            header("Location: index.php?eliminado=0");
        }
    } catch (PDOException $e) {
        header("Location: index.php?eliminado=0");
    }
} else {
    header("Location: index.php");
}
exit();
?>