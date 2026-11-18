<?php
require_once "../config/conexion.php";

$tipo_busqueda = "codigo";
$termino = "";
$precio_desde = "";
$precio_hasta = "";
$productos = [];
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tipo_busqueda = $_POST["tipo_busqueda"] ?? "";

    switch ($tipo_busqueda) {
        case "codigo":
            $termino = trim($_POST["codigo"] ?? "");

            if ($termino === "" || !ctype_digit($termino) || strlen($termino) > 13) {
                $mensaje = "Ingresá un código numérico válido de hasta 13 dígitos.";
            } else {
                $consulta = $conexion->prepare(
                    "SELECT codigo, descrip, stock, precio, marca, foto FROM productos WHERE codigo = ?"
                );
                $consulta->bind_param("s", $termino);
            }
            break;

        case "descripcion":
            $termino = trim($_POST["descripcion"] ?? "");

            if ($termino === "") {
                $mensaje = "Ingresá una descripción para buscar.";
            } else {
                $busqueda = "%" . $termino . "%";
                $consulta = $conexion->prepare(
                    "SELECT codigo, descrip, stock, precio, marca, foto FROM productos WHERE descrip LIKE ? ORDER BY descrip"
                );
                $consulta->bind_param("s", $busqueda);
            }
            break;

        case "marca":
            $termino = trim($_POST["marca"] ?? "");

            if ($termino === "") {
                $mensaje = "Ingresá una marca para buscar.";
            } else {
                $busqueda = $termino . "%";
                $consulta = $conexion->prepare(
                    "SELECT codigo, descrip, stock, precio, marca, foto FROM productos WHERE marca LIKE ? ORDER BY marca, descrip"
                );
                $consulta->bind_param("s", $busqueda);
            }
            break;

        case "precio":
            $precio_desde = trim($_POST["precio_desde"] ?? "");
            $precio_hasta = trim($_POST["precio_hasta"] ?? "");

            if (
                $precio_desde === "" || $precio_hasta === "" ||
                !is_numeric($precio_desde) || !is_numeric($precio_hasta) ||
                (float) $precio_desde < 0 || (float) $precio_hasta < 0
            ) {
                $mensaje = "Ingresá dos precios numéricos válidos y no negativos.";
            } elseif ((float) $precio_desde > (float) $precio_hasta) {
                $mensaje = "El precio inicial no puede ser mayor que el precio final.";
            } else {
                $desde = (float) $precio_desde;
                $hasta = (float) $precio_hasta;
                $consulta = $conexion->prepare(
                    "SELECT codigo, descrip, stock, precio, marca, foto FROM productos WHERE precio BETWEEN ? AND ? ORDER BY precio"
                );
                $consulta->bind_param("dd", $desde, $hasta);
            }
            break;

        default:
            $mensaje = "Seleccioná un criterio de búsqueda válido.";
            break;
    }

    if (isset($consulta)) {
        if ($consulta->execute()) {
            $resultado = $consulta->get_result();
            while ($fila = $resultado->fetch_assoc()) {
                $productos[] = $fila;
            }

            if (count($productos) === 0) {
                $mensaje = "No se encontraron productos que coincidan con la búsqueda.";
            }
        } else {
            $mensaje = "No se pudo realizar la búsqueda. Intentá nuevamente.";
        }
        $consulta->close();
    }
}

$conexion->close();

$titulo_pagina = "Buscar productos";
$ruta_base = "../";
$incluir_js = true;
require_once "../includes/header.php";
?>

    <main>
        <div class="titulo">
            <h1>Búsqueda de productos</h1>
        </div>

        <div class="bus">
            <form action="buscar.php" method="post">
                <label for="tipo_busqueda">Buscar por:</label>
                <select id="menu" name="tipo_busqueda" onchange="formularios()">
                    <option value="codigo" <?php echo $tipo_busqueda === "codigo" ? "selected" : ""; ?>>Código</option>
                    <option value="descripcion" <?php echo $tipo_busqueda === "descripcion" ? "selected" : ""; ?>>Descripción</option>
                    <option value="marca" <?php echo $tipo_busqueda === "marca" ? "selected" : ""; ?>>Marca</option>
                    <option value="precio" <?php echo $tipo_busqueda === "precio" ? "selected" : ""; ?>>Precio</option>
                </select>
                <div id="cod" class="bus" <?php echo $tipo_busqueda !== "codigo" ? "style='display:none'" : ""; ?>>
                    <label for="codigo">Código:</label>
                    <input id="codigo" type="text" name="codigo" value="<?php echo escapar($tipo_busqueda === "codigo" ? $termino : ""); ?>" maxlength="13" inputmode="numeric">
                </div>
                <div id="desc" class="bus" <?php echo $tipo_busqueda !== "descripcion" ? "style='display:none'" : ""; ?>>
                    <label for="descripcion">Descripción:</label>
                    <input id="descripcion" type="text" name="descripcion" value="<?php echo escapar($tipo_busqueda === "descripcion" ? $termino : ""); ?>">
                </div>
                <div id="form_marca" class="bus" <?php echo $tipo_busqueda !== "marca" ? "style='display:none'" : ""; ?>>
                    <label for="marca">Marca:</label>
                    <input id="marca" type="text" name="marca" value="<?php echo escapar($tipo_busqueda === "marca" ? $termino : ""); ?>">
                </div>
                <div id="form_precio" class="bus" <?php echo $tipo_busqueda !== "precio" ? "style='display:none'" : ""; ?>>
                    <label for="precio_desde">Desde:</label>
                    <input id="precio_desde" type="number" name="precio_desde" min="0" step="any" value="<?php echo escapar($precio_desde); ?>">
                    <label for="precio_hasta">Hasta:</label>
                    <input id="precio_hasta" type="number" name="precio_hasta" min="0" step="any" value="<?php echo escapar($precio_hasta); ?>">
                </div>
                <button type="submit">Buscar</button>
            </form>
        </div>

        <?php if ($mensaje !== ""): ?>
            <div class="productos">
                <div class="texto_er">
                    <p><?php echo escapar($mensaje); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <div class="productos">
            <?php foreach ($productos as $producto): ?>
                <?php
                    $url_detalle = "ampliado.php?" . http_build_query([
                        "codigo" => $producto["codigo"]
                    ]);
                    $foto = rawurlencode($producto["foto"]);
                ?>
                <div class="item">
                    <div class="foto">
                        <a href="<?php echo escapar($url_detalle); ?>" title="Ver detalle">
                            <img src="../assets/fotos/muestras/<?php echo escapar($foto); ?>" alt="<?php echo escapar($producto["descrip"]); ?>">
                        </a>
                    </div>
                    <div class="texto">
                        <p><?php echo escapar($producto["descrip"]); ?></p>
                        <p class="precio">$<?php echo escapar($producto["precio"]); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

<?php
require_once "../includes/footer.php";
?>