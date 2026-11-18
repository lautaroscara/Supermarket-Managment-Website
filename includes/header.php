<?php
$ruta_base = $ruta_base ?? "";
$titulo_pagina = $titulo_pagina ?? "Supermercado";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title><?php echo escapar($titulo_pagina); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo $ruta_base; ?>assets/css/styles.css">
    <?php if (!empty($incluir_js)): ?>
        <script type="text/javascript" src="<?php echo $ruta_base; ?>assets/js/js.js"></script>
    <?php endif; ?>
</head>

<body>
    <header>
        <div class="logo">
            <a href="<?php echo $ruta_base; ?>index.php">
                <img src="<?php echo $ruta_base; ?>assets/fotos/logo1.png" alt="Inicio">
            </a>
        </div>

        <nav>
            <a href="<?php echo $ruta_base; ?>pages/buscar.php" title="Consultar Productos">Búsqueda</a>
            <a href="<?php echo $ruta_base; ?>pages/alta.php" title="Agregar Productos">Alta</a>
            <a href="<?php echo $ruta_base; ?>pages/baja.php" title="Eliminar Productos">Baja</a>
            <a href="<?php echo $ruta_base; ?>pages/modificacion.php" title="Editar Productos">Modificación</a>
        </nav>
    </header>