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
			<h2>Listado de productos</h2>
		</div>
			<div class="productos">	
					<?php 
						$conexion = new mysqli("localhost", "root", "", "super");
						if ($conexion->connect_error)
						{
                           	die("Conexión fallida:". $conexion->connect_error . "Por favor comunicarse con el dueño de la página.");
                        }
                        $resultado = $conexion -> query("select * from productos order by descrip");
                        if ($resultado->num_rows > 0)
                        {
                     	while ($fila = $resultado -> fetch_assoc())
                      	{
                     		$codigo = $fila["codigo"];
                       		$descrip = $fila["descrip"];
                       		$stock = $fila["stock"];
                       		$precio = $fila["precio"];
                       		$sector = $fila["sector"];
                      		$marca = $fila["marca"];
                      		$foto = $fila["foto"];
                       		echo"<div class='item'>
		                         <div class='foto'>
									 <a href='ampliado.php?descrip=$descrip&stock=$stock&precio=$precio&foto=$foto' title='Ampliar'>
									 <img src='fotos/muestras/$foto' alt='producto'>
									 </a>
								 </div>
			                         <div class='texto'>
										 <p>$descrip</p>
											 <p class='precio'>$$precio</p>
										 </div>
			                         </div>";
                             	}
                             }
                           	else
                           	{
                          		echo" 
                            		<div class='er'>
										<div class='foto_er'>
											<img src='fotos/error.png' alt='imagen de error'>
										</div>
											<p>Se han encontrado 0 resultados</p>
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