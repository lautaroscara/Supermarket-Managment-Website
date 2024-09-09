<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Formularios</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
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
			<h1>Baja de productos</h1>
		</div>
			<div class="alta">
				<?php 
				    $conexion = new mysqli("localhost", "root", "", "super");
				    // Verificar la conexión
				    if ($conexion->connect_error) 
				    {
				        die("Conexión fallida:". $conexion->connect_error . "Por favor comunicarse con el dueño de la página.");
				    }
				    $codigo = $_GET["codigo"];				    
				    $resultado = $conexion->query("DELETE FROM productos WHERE codigo=$codigo");
				    if ($resultado === TRUE) 
				    {
				        echo "<div class='bus'>
				                <div class='texto_er'>
				                    <p>El producto se ha eliminado correctamente.</p>
				                    <a href='baja.php' class='bot_alta'>Volver</a>
				                </div>
				              </div>";
				    } 
					    else 
					    {
					        echo "<div class='bus'>
					                <div class='texto_er'>
					                    <p>El producto no pudo ser eliminado.</p>
					                    <a href='baja.php' class='bot_alta'>Volver</a>
					                </div>
					              </div>";
						}
					$conexion->close();    
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