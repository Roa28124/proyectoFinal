<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libro de Recetas | Recetario</title>
    <script src="tailwind.js"></script>
    <style>
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1;
            white-space: nowrap;
        }
        .badge-time {
            background-color: #dcfce7;
            color: #166534;
        }
        .badge-portions {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .difficulty-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1;
        }
        .difficulty-facil {
            background-color: #dcfce7;
            color: #166534;
        }
        .difficulty-medio {
            background-color: #fef9c3;
            color: #854d0e;
        }
        .difficulty-dificil {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body class="bg-amber-50 min-h-screen p-6">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-10">
            <h1 class="text-5xl font-bold text-amber-800 font-serif mb-2">- Libro de Recetas -</h1>
            <p class="text-amber-600 italic">Tu colección culinaria personal</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-amber-500 to-amber-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left">ID</th>
                            <th class="px-6 py-4 text-left">Receta</th>
                            <th class="px-6 py-4 text-left">Detalles</th>
                            <th class="px-6 py-4 text-left">Dificultad</th>
                            <th class="px-6 py-4 text-left">Categoría</th>
                            <th class="px-6 py-4 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-amber-100">
                        <?php
                        require_once('modelos/conexion.php');
                        $consulta = $cnn->query("SELECT * FROM recetas ORDER BY id_receta ASC");
                        $recetas = $consulta->fetchAll(PDO::FETCH_ASSOC);

                        if (count($recetas) > 0) {
                            foreach ($recetas as $receta) {
                                $difficultyClass = 'difficulty-' . str_replace(
                                    ['á', 'é', 'í', 'ó', 'ú'],
                                    ['a', 'e', 'i', 'o', 'u'],
                                    strtolower($receta['dificultad'])
                                );
                                
                                $categoryIcon = match($receta['categoria']) {
                                    'Postre' => '🍰',
                                    'Principal' => '🍲',
                                    'Entrada' => '🥗',
                                    'Aperitivo' => '🍢',
                                    'Bebida' => '🍹',
                                    default => '🍽️'
                                };
                                
                                echo "<tr class='hover:bg-amber-50 transition-colors'>
                                        <td class='px-6 py-4 font-medium text-amber-900 whitespace-nowrap'>{$receta['id_receta']}</td>
                                        <td class='px-6 py-4 font-medium text-amber-900 whitespace-nowrap'>{$receta['nombre']}</td>
                                        <td class='px-6 py-4'>
                                            <div class='flex flex-wrap gap-2'>
                                                <span class='badge badge-time'>⏱️ {$receta['tiempo_preparacion']} min</span>
                                                <span class='badge badge-portions'>🍽️ {$receta['porciones']} porciones</span>
                                            </div>
                                        </td>
                                        <td class='px-6 py-4'>
                                            <span class='difficulty-badge {$difficultyClass}'>
                                                {$receta['dificultad']}
                                            </span>
                                        </td>
                                        <td class='px-6 py-4'>
                                            <span class='inline-flex items-center gap-2'>
                                                {$categoryIcon} {$receta['categoria']}
                                            </span>
                                        </td>
                                        <td class='px-6 py-4'>
                                            <div class='flex gap-2'>
                                                <a href='form_receta.php?id={$receta['id_receta']}' class='px-3 py-1 bg-amber-500 text-white rounded-md hover:bg-amber-600 transition-colors text-sm'>
                                                    Editar
                                                </a>
                                                <a href='eliminar_receta.php?id={$receta['id_receta']}' onclick='return confirm(\"¿Eliminar esta receta?\")' class='px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors text-sm'>
                                                    Eliminar
                                                </a>
                                            </div>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr>
                                    <td colspan='6' class='px-6 py-8 text-center text-amber-600'>
                                        <div class='flex flex-col items-center'>
                                            <span class='text-4xl mb-2'>🍽️</span>
                                            <p>No hay recetas registradas</p>
                                        </div>
                                    </td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-8 text-center">
            <a href="form_receta.php" class="inline-block px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg shadow-md hover:shadow-lg transition-all hover:scale-105">
                ＋ Agregar Nueva Receta
            </a>
        </div>
    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('eliminado') === '1') {
            alert('Receta eliminada correctamente');
        } else if (urlParams.get('eliminado') === '0') {
            alert('Error al eliminar la receta');
        }
        if (urlParams.get('actualizado') === '1') {
            alert('Receta actualizada correctamente');
        }
    </script>
</body>
</html>