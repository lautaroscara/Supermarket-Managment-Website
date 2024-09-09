<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Formularios</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<script type="text/javascript" src="js.js"></script>
</head>
<body>
	<header>
	
		<div class="logo">
			<a href="index.php"><img src="fotos/logo1.png"></a>
		</div>
			
		<nav> 
			<a href="multibusqueda.php" title="Consultar Productos">Búsqueda</a>
			<a href="alta.php" title="Agregar Productos">Alta</a>
			<a href="baja.php" title="Eliminar Productos">Baja</a>
			<a href="modificacion.php" title="Editar Productos">Modificación</a>			
		</nav>
	</header>
	<main>
		<div class="titulo">
			<h1>Modificación de productos</h1>
		</div>
			<div class="alta">	
				<form action="modificacion2.php" method="post" class="alta">
					<?php 
					    @$codigo = $_GET["cod"];
					    @$descripcion = $_GET["desc"];
					    @$stock = $_GET["stock"];
					    @$sector = $_GET["sector"];
					    @$marca = $_GET["marca"];
					    @$precio = $_GET["precio"];
					    @$foto = $_GET["foto"];

					    echo "
					    <p>Codigo:<input type='text' class='inalta' name='cod' value='$codigo' readonly></p>
					    <p>Descripción:<input type='text' name='descripcion' class='desalta' value='$descripcion' autofocus required></p>
					    <p>Stock:<input type='number' name='stoc' class='inalta' value='$stock' required min='0' max='9999999999999'></p>
					    <p>Precio:<input type='number' name='preci' class='inalta' value='$precio' required min='0' max='9999999999999'></p>
					    <p>Sector:<input type='text' name='sec' class='inalta' value='$sector' required></p>
					    <p>Marca:<input type='text' name='marc' class='inalta' value='$marca' required></p>
					    <p>Foto (nombre del archivo):<input type='text' name='fot' class='inalta' value='$foto' required min='0' max='9999999999999'></p>";
					    ?>
						<button name="boton_mod" type="submit">Cargar</button>
					   </form>
					   <?php 
					    if (isset($_POST["boton_mod"])) {
					        $conexion = new mysqli("localhost", "root", "", "super");

					        // Verificar la conexión
					        if ($conexion->connect_error) {
					            die("Conexión fallida: " . $conexion->connect_error);
					        }

					        $codigo = $_POST["cod"];
					        $descrip = $_POST["descripcion"];
					        $stock = $_POST["stoc"];
					        $precio = $_POST["preci"];
					        $sector = $_POST["sec"];
					        $marca = $_POST["marc"];
					        $foto = $_POST["fot"];

					        $consulta = "UPDATE productos SET descrip='$descrip', stock=$stock, precio=$precio, sector='$sector', marca='$marca', foto='$foto' WHERE codigo=$codigo";
					        $resultado = $conexion->query($consulta);  

					        if ($resultado === TRUE) {
					            echo "<div class='bus'>
					                    <div class='texto_er'>
					                        <p>El producto se ha modificado correctamente.</p>
					                        <a href='modificacion.php' class='bot_alta'>Volver</a>
					                    </div>
					                  </div>";
					        } else {
					            echo "No se ha podido modificar el producto";
					        }
					        $conexion->close();         
					    }
					?>					          						   
			</div>				 							
	</main>
	<footer>
		<div class="logo">
			<img src="fotos/logo1.png">
		</div>
		<div class="info">
			<p>W. de Tata 4699, B1676 BBE, Provincia de Buenos Aires</p>
			<p>Telefono: 011 4750-4314</p>
		</div>
	</footer>
</body>
</html>