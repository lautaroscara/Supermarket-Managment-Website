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
				<h1>Más información</h1>
			</div>
			      
				<div class="productos">	
					<?php 
					       $descrip= $_GET['descrip'];
					       $stock= $_GET['stock'];
					       $precio= $_GET['precio'];
					       $foto= $_GET['foto'];
                        echo" <div class='ampliar'>
								  <div class='foto_amp'>
								  	<a href='fotos/grandes/$foto' target='_blank' title='Ampliar Foto'><img src='fotos/grandes/$foto' alt=''></a>
								  </div>
									<div class='texto_amp'>
										<p>$descrip</p>
										<p>Stock: $stock</p>
										<p>Precio C/U: $$precio</p>
										<a href='progp.php' title='Volver al inicio'>Volver</a>
								    </div>"
						?>
					</div>
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