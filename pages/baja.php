<?php
require_once "../config/conexion.php";

$codigo = "";
$producto = null;
$mensaje = "";
$tipo_mensaje = "";
$mostrar_confirmacion = false;



// Primera etapa: buscar el producto que se desea eliminar.
if (isset($_POST["boton_cod"])) {
    $codigo = trim($_POST["code"] ?? "");

    if ($codigo === "" || !ctype_digit($codigo) || strlen($codigo) > 13) {
        $mensaje = "Ingresá un código numérico válido de hasta 13 dígitos.";
        $tipo_mensaje = "error";
    } else {
        $consulta = $conexion->prepare(
            "SELECT codigo, descrip, precio, stock, foto FROM productos WHERE codigo = ?"
        );
        $consulta->bind_param("s", $codigo);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $producto = $resultado->fetch_assoc();

        if ($producto !== null) {
            $mostrar_confirmacion = true;
        } else {
            $mensaje = "El producto no figura en la base de datos.";
            $tipo_mensaje = "error";
        }

        $consulta->close();
    }
}

// Segunda etapa: eliminar únicamente después de la confirmación del usuario.
if (isset($_POST["confirmar_baja"])) {
    $codigo = trim($_POST["code"] ?? "");

    if ($codigo === "" || !ctype_digit($codigo) || strlen($codigo) > 13) {
        $mensaje = "El código recibido no es válido.";
        $tipo_mensaje = "error";
    } else {
        $consulta = $conexion->prepare("DELETE FROM productos WHERE codigo = ?");
        $consulta->bind_param("s", $codigo);

        if ($consulta->execute() && $consulta->affected_rows === 1) {
            $mensaje = "El producto se ha eliminado correctamente.";
            $tipo_mensaje = "exito";
        } else {
            $mensaje = "No se pudo eliminar el producto. Es posible que ya no exista.";
            $tipo_mensaje = "error";
        }

        $consulta->close();
    }
}

$conexion->close();
$titulo_pagina = "Baja de productos";
$ruta_base = "../";
require_once "../includes/header.php";
?>

    <main>
        <div class="titulo">
            <h1>Baja de productos</h1>
        </div>

        <?php if ($mensaje !== ""): ?>
            <div class="productos">
                <div class="texto_er">
                    <p><?php echo escapar($mensaje); ?></p>
                    <a href="baja.php" class="bot_alta">Volver</a>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($mostrar_confirmacion && $producto !== null): ?>
            <div class="productos">
                <div class="ampliar">
                    <div class="foto_amp">
                        <a href="fotos/grandes/<?php echo rawurlencode($producto["foto"]); ?>" target="_blank" rel="noopener" title="Ampliar foto">
                            <img src="fotos/grandes/<?php echo rawurlencode($producto["foto"]); ?>" alt="<?php echo escapar($producto["descrip"]); ?>">
                        </a>
                    </div>
                    <div class="texto_amp">
                        <p><?php echo escapar($producto["descrip"]); ?></p>
                        <p>Stock: <?php echo escapar($producto["stock"]); ?></p>
                        <p>Precio C/U: $<?php echo escapar($producto["precio"]); ?></p>
                        <p>¿Deseás eliminar este producto?</p>
                        <form action="baja.php" method="post">
                            <input type="hidden" name="code" value="<?php echo escapar($producto["codigo"]); ?>">
                            <button type="submit" name="confirmar_baja">Confirmar eliminación</button>
                            <a href="baja.php">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        <?php elseif (!isset($_POST["confirmar_baja"]) && $mensaje === ""): ?>
            <div class="productos">
                <form action="baja.php" method="post">
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


