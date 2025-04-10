<?php
require_once('modelos/conexion.php');

$receta = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $cnn->prepare("SELECT * FROM recetas WHERE id_receta = ?");
    $stmt->execute([$id]);
    $receta = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$receta) {
        header("Location: index.php");
        exit();
    }
}

$error = isset($_GET['error']) ? $_GET['error'] : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($receta) ? 'Editar' : 'Nueva' ?> Receta | Formulario</title>
    <script src="tailwind.js"></script>
    <style type="text/tailwindcss">
        @layer components {
            .select-arrow {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23b45309' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
                background-position: right 0.5rem center;
                background-repeat: no-repeat;
                background-size: 1.5em 1.5em;
            }
        }
    </style>
</head>
<body class="bg-amber-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden transition-all hover:shadow-2xl">
            <div class="bg-gradient-to-r from-amber-500 to-amber-600 p-6 text-center text-white">
                <h2 class="text-2xl font-bold">
                    <?= isset($receta) ? '✏️ Editar Receta' : '+ Nueva Receta' ?>
                </h2>
                <p class="opacity-90">
                    <?= isset($receta) ? 'Actualiza los detalles' : 'Completa los datos de tu receta' ?>
                </p>
            </div>
            
            <div class="p-6">
                <?php if ($error): ?>
                    <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700">
                        <p>❌ Error al <?= isset($receta) ? 'actualizar' : 'guardar' ?> la receta</p>
                    </div>
                <?php endif; ?>
                
                <form method="post" action="<?= isset($receta) ? 'actualizar_receta.php' : 'save_receta.php' ?>">
                    <?php if (isset($receta)): ?>
                        <input type="hidden" name="id_receta" value="<?= $receta['id_receta'] ?>">
                    <?php endif; ?>
                    
                    <div class="mb-4">
                        <label for="nombre" class="block text-amber-800 font-medium mb-2">Nombre</label>
                        <input type="text" id="nombre" name="nombre" 
                               class="w-full px-3 py-2 border border-amber-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                               placeholder="Tarta de Manzana"
                               value="<?= isset($receta) ? htmlspecialchars($receta['nombre']) : '' ?>" required>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="tiempo_preparacion" class="block text-amber-800 font-medium mb-2">⏱️ Tiempo (min)</label>
                            <input type="number" id="tiempo_preparacion" name="tiempo_preparacion" min="1"
                                   class="w-full px-3 py-2 border border-amber-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                   value="<?= isset($receta) ? $receta['tiempo_preparacion'] : '' ?>" required>
                        </div>
                        <div>
                            <label for="porciones" class="block text-amber-800 font-medium mb-2">🍽️ Porciones</label>
                            <input type="number" id="porciones" name="porciones" min="1"
                                   class="w-full px-3 py-2 border border-amber-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                   value="<?= isset($receta) ? $receta['porciones'] : '' ?>" required>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label for="dificultad" class="block text-amber-800 font-medium mb-2">📊 Dificultad</label>
                            <select id="dificultad" name="dificultad" 
                                    class="w-full px-3 py-2 border border-amber-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent " required>
                                <option value="">Seleccionar...</option>
                                <option value="Fácil" <?= (isset($receta) && $receta['dificultad'] == 'Fácil') ? 'selected' : '' ?>>Fácil</option>
                                <option value="Medio" <?= (isset($receta) && $receta['dificultad'] == 'Medio') ? 'selected' : '' ?>>Medio</option>
                                <option value="Difícil" <?= (isset($receta) && $receta['dificultad'] == 'Difícil') ? 'selected' : '' ?>>Difícil</option>
                            </select>
                        </div>
                        <div>
                            <label for="categoria" class="block text-amber-800 font-medium mb-2">🍳 Categoría</label>
                            <select id="categoria" name="categoria" 
                                    class="w-full px-3 py-2 border border-amber-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent " required>
                                <option value="">Seleccionar...</option>
                                <option value="Entrada" <?= (isset($receta) && $receta['categoria'] == 'Entrada') ? 'selected' : '' ?>>Entrada</option>
                                <option value="Principal" <?= (isset($receta) && $receta['categoria'] == 'Principal') ? 'selected' : '' ?>>Principal</option>
                                <option value="Postre" <?= (isset($receta) && $receta['categoria'] == 'Postre') ? 'selected' : '' ?>>Postre</option>
                                <option value="Aperitivo" <?= (isset($receta) && $receta['categoria'] == 'Aperitivo') ? 'selected' : '' ?>>Aperitivo</option>
                                <option value="Bebida" <?= (isset($receta) && $receta['categoria'] == 'Bebida') ? 'selected' : '' ?>>Bebida</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md transition-colors font-medium">
                            <?= isset($receta) ? '💾 Guardar Cambios' : '+ Agregar Receta' ?>
                        </button>
                    
                        
                        <a href="index.php" class="flex-1 bg-amber-500 hover:bg-amber-700 text-white py-2 px-4 rounded-md transition-colors font-medium text-center">
                            ❌ Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmarEliminacion(id) {
            if (confirm('¿Estás seguro de eliminar esta receta?')) {
                window.location.href = `eliminar_receta.php?id=${id}`;
            }
        }
    </script>
</body>
</html>