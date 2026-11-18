<?php
require_once "../config/conexion.php";

$producto = null;
$mensaje = "";

$codigo = trim($_GET["codigo"] ?? "");

if ($codigo === "" || !ctype_digit($codigo) || strlen($codigo) > 13) {
    $mensaje = "El código del producto no es válido.";
} else {
    $consulta = $conexion->prepare(
        "SELECT codigo, descrip, stock, precio, foto
         FROM productos
         WHERE codigo = ?"
    );

    $consulta->bind_param("s", $codigo);

    if ($consulta->execute()) {
        $resultado = $consulta->get_result();
        $producto = $resultado->fetch_assoc();

        if ($producto === null) {
            $mensaje = "No se encontró el producto solicitado.";
        }
    } else {
        $mensaje = "No se pudo consultar el producto.";
    }

    $consulta->close();
}

$conexion->close();
$titulo_pagina = "Más información";
$ruta_base = "../";
require_once "../includes/header.php";
?>


    <main>
        <div class="titulo">
            <h1>Más información</h1>
        </div>

        <div class="productos">
            <?php if ($producto !== null): ?>

                <?php
                $foto = basename($producto["foto"]);
                $foto_url = "../assets/fotos/grandes/" . rawurlencode($foto);
                ?>

                <div class="ampliar">
                    <div class="foto_amp">
                        <a href="<?php echo escapar($foto_url); ?>"
                           target="_blank"
                           rel="noopener noreferrer"
                           title="Ampliar Foto">
                            <img src="<?php echo escapar($foto_url); ?>"
                                 alt="<?php echo escapar($producto["descrip"]); ?>">
                        </a>
                    </div>

                    <div class="texto_amp">
                        <p><?php echo escapar($producto["descrip"]); ?></p>
                        <p>Stock: <?php echo escapar($producto["stock"]); ?></p>
                        <p>Precio C/U: $<?php echo escapar($producto["precio"]); ?></p>

                        <a href="buscar.php" title="Volver a la búsqueda">Volver</a>
                    </div>
                </div>

            <?php else: ?>

                <div class="texto_er">
                    <p><?php echo escapar($mensaje); ?></p>
                    <a href="buscar.php">Volver a la búsqueda</a>
                </div>

            <?php endif; ?>
        </div>
    </main>

<?php
require_once "../includes/footer.php";
?>

