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
				<h1>Alta de productos</h1>
			</div>	
				<div class="alta">
					<form action="alta2.php" method="post" class="alta">
					   	<?php 
						   //recuperamos el codigo
					       @$codigo= $_GET["codigo"];
					       echo "<p>Codigo:<input type='text' name='code' class='inalta' value='$codigo' readonly></p>";
					   ?>
					       <p>Descripción:<input type="text" name="desc" class='desalta' autofocus required></p>
					       <p>Stock:<input type="number" name="stock" class='inalta' required min="0" max="9999999999999"></p>
					       <p>Precio:<input type="number" name="precio" class='inalta' required min="0" max="9999999999999"></p>
					       <p>Sector:<input type="text" name="sec" class='inalta' required></p>
					       <p>Marca:<input type="text" name="marca" class='inalta' required></p>
					       <p>Foto (nombre del archivo):<input type="text" name="foto" class='inalta' required min="0" max="9999999999999"></p>
					       <button name="boton_alta" type="submit">Cargar</button>
					   </form>
					    <?php 
						    if (isset($_POST["boton_alta"])) {
						        $conexion = new mysqli("localhost", "root", "", "super");
						        if ($conexion->connect_error) {
						            die("Conexión fallida:". $conexion->connect_error . "Por favor comunicarse con el dueño de la página.");
						        }
						        $codigo2 = $_POST['code'];
						        $descrip = $_POST["desc"];
						        $stock = $_POST["stock"];
						        $precio = $_POST["precio"];
						        $sector = $_POST["sec"];
						        $marca = $_POST["marca"];
						        $foto = $_POST["foto"];
						        $resultado = $conexion->query("INSERT INTO productos (codigo, descrip, stock, precio, sector, marca, foto) VALUES ($codigo2, '$descrip', $stock, $precio, '$sector', '$marca', '$foto')");
						        if($resultado) 
						        {
						            echo "<div class='bus'>
						                    <div class='texto_er'>
						                        <p>El producto se ha cargado correctamente.</p>
						                        <a href='alta.php' class='bot_alta'>Volver</a>
						                    </div>
						                  </div>";
						        } 
						        else 
						        {
						            echo "Error al cargar el producto: " . $conexion->error;
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