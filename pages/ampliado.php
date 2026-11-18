<?php
$conexion = new mysqli("localhost", "root", "", "super");

if ($conexion->connect_error) {
    http_response_code(500);
    die("No se pudo conectar con la base de datos.");
}

$conexion->set_charset("utf8mb4");

function escapar($valor): string {
    return htmlspecialchars((string) $valor, ENT_QUOTES, "UTF-8");
}

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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Más información</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <header>
        <div class="logo">
            <a href="index.php">
                <img src="fotos/logo1.png" alt="Inicio">
            </a>
        </div>

        <nav>
            <a href="buscar.php" title="Consultar Productos">Búsqueda</a>
            <a href="alta.php" title="Agregar Productos">Alta</a>
            <a href="baja.php" title="Eliminar Productos">Baja</a>
            <a href="modificacion.php" title="Editar Productos">Modificación</a>
        </nav>
    </header>

    <main>
        <div class="titulo">
            <h1>Más información</h1>
        </div>

        <div class="productos">
            <?php if ($producto !== null): ?>

                <?php
                $foto = basename($producto["foto"]);
                $foto_url = "fotos/grandes/" . rawurlencode($foto);
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

    <footer>
        <div class="logo">
            <img src="fotos/logo1.png" alt="Logo">
        </div>

        <div class="info">
            <p>W. de Tata 4699, B1676 BBE, Provincia de Buenos Aires</p>
            <p>Telefono: 011 4750-4314</p>
        </div>
    </footer>
</body>
</html>
