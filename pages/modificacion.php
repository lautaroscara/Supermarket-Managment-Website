<?php
require_once "../config/conexion.php";

$codigo = "";
$producto = null;
$mensaje = "";
$mostrar_formulario = false;
$modificacion_exitosa = false;

// Primera etapa: buscar el producto que se desea modificar.
if (isset($_POST["boton_cod"])) {
    $codigo = trim($_POST["code"] ?? "");

    if ($codigo === "" || !ctype_digit($codigo) || strlen($codigo) > 13) {
        $mensaje = "Ingresá un código numérico válido de hasta 13 dígitos.";
    } else {
        $consulta = $conexion->prepare(
            "SELECT codigo, descrip, precio, stock, foto, marca, sector
             FROM productos WHERE codigo = ?"
        );
        $consulta->bind_param("s", $codigo);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $producto = $resultado->fetch_assoc();

        if ($producto !== null) {
            $mostrar_formulario = true;
        } else {
            $mensaje = "El producto no figura en la base de datos.";
        }

        $consulta->close();
    }
}

// Segunda etapa: validar y guardar los cambios.
if (isset($_POST["boton_mod"])) {
    $codigo = trim($_POST["cod"] ?? "");
    $descrip = trim($_POST["descripcion"] ?? "");
    $stock = trim($_POST["stoc"] ?? "");
    $precio = trim($_POST["preci"] ?? "");
    $sector = trim($_POST["sec"] ?? "");
    $marca = trim($_POST["marc"] ?? "");
    $foto = trim($_POST["fot"] ?? "");

    $stock_validado = filter_var($stock, FILTER_VALIDATE_INT);
    $precio_valido = is_numeric($precio);

    if (
        $codigo === "" || !ctype_digit($codigo) || strlen($codigo) > 13 ||
        $descrip === "" || strlen($descrip) > 50 ||
        $stock_validado === false || $stock_validado < 0 ||
        !$precio_valido || (float) $precio < 0 ||
        $sector === "" || strlen($sector) > 3 ||
        $marca === "" || strlen($marca) > 20 ||
        $foto === "" || strlen($foto) > 20
    ) {
        $mensaje = "Revisá los datos: hay campos vacíos, valores inválidos o textos demasiado largos.";
        $mostrar_formulario = true;
        $producto = [
            "codigo" => $codigo,
            "descrip" => $descrip,
            "stock" => $stock,
            "precio" => $precio,
            "sector" => $sector,
            "marca" => $marca,
            "foto" => $foto
        ];
    } else {
        $stock_entero = (int) $stock_validado;
        $precio_decimal = (float) $precio;

        $consulta = $conexion->prepare(
            "UPDATE productos
             SET descrip = ?, stock = ?, precio = ?, sector = ?, marca = ?, foto = ?
             WHERE codigo = ?"
        );
        $consulta->bind_param(
            "sidssss",
            $descrip,
            $stock_entero,
            $precio_decimal,
            $sector,
            $marca,
            $foto,
            $codigo
        );

        if ($consulta->execute() && $consulta->affected_rows >= 0) {
            $mensaje = "El producto se ha modificado correctamente.";
            $modificacion_exitosa = true;
        } else {
            $mensaje = "No se pudo modificar el producto.";
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
            <h1>Modificación de productos</h1>
        </div>

        <?php if ($mensaje !== ""): ?>
            <div class="productos">
                <div class="texto_er">
                    <p><?php echo escapar($mensaje); ?></p>
                    <?php if ($modificacion_exitosa): ?>
                        <a href="modificacion.php" class="bot_alta">Volver</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($mostrar_formulario && $producto !== null): ?>
            <div class="alta">
                <form action="modificacion.php" method="post" class="alta">
                    <p>Código:<input type="text" name="cod" class="inalta" value="<?php echo escapar($producto["codigo"]); ?>" readonly></p>
                    <p>Descripción:<input type="text" name="descripcion" class="desalta" value="<?php echo escapar($producto["descrip"]); ?>" autofocus required maxlength="50"></p>
                    <p>Stock:<input type="number" name="stoc" class="inalta" value="<?php echo escapar($producto["stock"]); ?>" required min="0" step="1"></p>
                    <p>Precio:<input type="number" name="preci" class="inalta" value="<?php echo escapar($producto["precio"]); ?>" required min="0" step="any"></p>
                    <p>Sector:<input type="text" name="sec" class="inalta" value="<?php echo escapar($producto["sector"]); ?>" required maxlength="3"></p>
                    <p>Marca:<input type="text" name="marc" class="inalta" value="<?php echo escapar($producto["marca"]); ?>" required maxlength="20"></p>
                    <p>Foto (nombre del archivo):<input type="text" name="fot" class="inalta" value="<?php echo escapar($producto["foto"]); ?>" required maxlength="20"></p>
                    <button name="boton_mod" type="submit">Guardar cambios</button>
                </form>
            </div>
        <?php elseif (!$modificacion_exitosa): ?>
            <div class="productos">
                <form action="modificacion.php" method="post">
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

