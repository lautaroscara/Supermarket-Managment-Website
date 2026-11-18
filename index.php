<?php
require_once "config/conexion.php";

$resultado = $conexion->query(
    "SELECT codigo, descrip, precio, foto
     FROM productos
     ORDER BY descrip"
);

if (!$resultado) {
    http_response_code(500);
    die("No se pudo obtener el listado de productos.");
}

$titulo_pagina = "Listado de productos";
$ruta_base = "";
require_once "includes/header.php";
?>

    <main>
        <div class="titulo">
            <h2>Listado de productos</h2>
        </div>

        <div class="productos">

            <?php if ($resultado->num_rows > 0): ?>

                <?php while ($fila = $resultado->fetch_assoc()): ?>

                    <?php
                    $url_detalle = "pages/ampliado.php?" . http_build_query([
                        "codigo" => $fila["codigo"]
                    ]);

                    $foto = rawurlencode(basename($fila["foto"]));
                    ?>

                    <div class="item">
                        <div class="foto">
                            <a href="<?php echo escapar($url_detalle); ?>"
                               title="Ampliar">

                                <img src="assets/fotos/muestras/<?php echo escapar($foto); ?>"
                                     alt="<?php echo escapar($fila["descrip"]); ?>">
                            </a>
                        </div>

                        <div class="texto">
                            <p><?php echo escapar($fila["descrip"]); ?></p>

                            <p class="precio">
                                $<?php echo escapar($fila["precio"]); ?>
                            </p>
                        </div>
                    </div>

                <?php endwhile; ?>

            <?php else: ?>

                <div class="er">
                    <div class="foto_er">
                        <img src="assets/fotos/error.png" alt="Imagen de error">
                    </div>

                    <p>Se han encontrado 0 resultados</p>
                </div>

            <?php endif; ?>

        </div>
    </main>

<?php
$resultado->free();
$conexion->close();
require_once "includes/footer.php";
?>
