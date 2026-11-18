<?php
require_once "../config/conexion.php";

$codigo = "";
$producto = null;
$mensaje = "";
$tipo_mensaje = "";
$mostrar_formulario = false;
$alta_exitosa = false;

// Primera etapa: comprobar si el código ya existe.
if (isset($_POST["boton_cod"])) {
    $codigo = trim($_POST["code"] ?? "");

    if ($codigo === "" || !ctype_digit($codigo) || strlen($codigo) > 13) {
        $mensaje = "Ingresá un código numérico válido de hasta 13 dígitos.";
        $tipo_mensaje = "error";
    } else {
        $consulta = $conexion->prepare(
            "SELECT descrip, precio, stock, foto FROM productos WHERE codigo = ?"
        );
        $consulta->bind_param("s", $codigo);
        $consulta->execute();
        $resultado = $consulta->get_result();

        if ($resultado->num_rows > 0) {
            $producto = $resultado->fetch_assoc();
            $mensaje = "El producto ya está en la base de datos.";
            $tipo_mensaje = "info";
        } else {
            $mostrar_formulario = true;
        }

        $consulta->close();
    }
}

// Segunda etapa: registrar el producto desde este mismo archivo.
if (isset($_POST["boton_alta"])) {
    $codigo = trim($_POST["code"] ?? "");
    $descrip = trim($_POST["desc"] ?? "");
    $stock = trim($_POST["stock"] ?? "");
    $precio = trim($_POST["precio"] ?? "");
    $sector = trim($_POST["sec"] ?? "");
    $marca = trim($_POST["marca"] ?? "");
    $foto = trim($_POST["foto"] ?? "");

    if (
        $codigo === "" || !ctype_digit($codigo) || strlen($codigo) > 13 ||
        $descrip === "" || $stock === "" || !is_numeric($stock) ||
        $precio === "" || !is_numeric($precio) || $sector === "" ||
        $marca === "" || $foto === "" || strlen($descrip) > 50
    ) {
        $mensaje = "Completá todos los campos con valores válidos.";
        $tipo_mensaje = "error";
        $mostrar_formulario = true;
    } else {
        $consulta = $conexion->prepare(
            "INSERT INTO productos (codigo, descrip, stock, precio, sector, marca, foto)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        // codigo es BIGINT(13): lo enviamos como cadena para evitar desbordamientos.
        $stock_entero = (int) $stock;
        $precio_decimal = (float) $precio;
        $consulta->bind_param(
            "ssidsss",
            $codigo,
            $descrip,
            $stock_entero,
            $precio_decimal,
            $sector,
            $marca,
            $foto
        );

        if ($consulta->execute()) {
            $mensaje = "El producto se ha cargado correctamente.";
            $tipo_mensaje = "exito";
            $alta_exitosa = true;
        } else {
            $mensaje = "No se pudo cargar el producto. Verificá que el código no esté registrado.";
            $tipo_mensaje = "error";
            $mostrar_formulario = true;
        }

        $consulta->close();
    }
}

$conexion->close();

$titulo_pagina = "Alta de productos";
$ruta_base = "../";
require_once "../includes/header.php";
?>

    <main>
        <div class="titulo">
            <h1>Alta de productos</h1>
        </div>

        <?php if ($mensaje !== ""): ?>
            <div class="productos">
                <div class="texto_er">
                    <p><?php echo escapar($mensaje); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($producto !== null): ?>
            <div class="productos">
                <div class="ampliar">
                    <div class="foto_amp">
                        <a href="../assets/fotos/grandes/<?php echo rawurlencode($producto["foto"]); ?>" target="_blank" title="Ampliar Foto">
                            <img src="../assets/fotos/grandes/<?php echo rawurlencode($producto["foto"]); ?>" alt="<?php echo escapar($producto["descrip"]); ?>">
                        </a>
                    </div>
                    <div class="texto_amp">
                        <p>El producto ya está en la base de datos</p>
                        <p><?php echo escapar($producto["descrip"]); ?></p>
                        <p>Stock: <?php echo escapar($producto["stock"]); ?></p>
                        <p>Precio C/U: $<?php echo escapar($producto["precio"]); ?></p>
                        <a href="alta.php" title="Volver al inicio">Cerrar</a>
                    </div>
                </div>
            </div>
        <?php elseif ($alta_exitosa): ?>
            <div class="bus">
                <a href="alta.php" class="bot_alta">Volver</a>
            </div>
        <?php elseif ($mostrar_formulario): ?>
            <div class="alta">
                <form action="alta.php" method="post" class="alta">
                    <p>Código:<input type="text" name="code" class="inalta" value="<?php echo escapar($codigo); ?>" readonly></p>
                    <p>Descripción:<input type="text" name="desc" class="desalta" autofocus required></p>
                    <p>Stock:<input type="number" name="stock" class="inalta" required min="0" max="9999999999999"></p>
                    <p>Precio:<input type="number" name="precio" class="inalta" required min="0" max="9999999999999" step="any"></p>
                    <p>Sector:<input type="text" name="sec" class="inalta" required></p>
                    <p>Marca:<input type="text" name="marca" class="inalta" required></p>
                    <p>Foto (nombre del archivo):<input type="text" name="foto" class="inalta" required></p>
                    <button name="boton_alta" type="submit">Cargar</button>
                </form>
            </div>
        <?php else: ?>
            <div class="productos">
                <form action="alta.php" method="post">
                    <p>
                        Código:
                        <input type="number" name="code" autofocus required min="0" max="9999999999999">
                        <button name="boton_cod" type="submit">Buscar</button>
                    </p>
                </form>
            </div>
        <?php endif; ?>
    </main>
<?php
require_once "../includes/footer.php";
?>
