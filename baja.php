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
			<div class="productos">	
				<form action="baja.php" method="post">
					<p>Código: <input type="number" name="code" autofocus required min="0" max="9999999999999">
							   <button name="boton_cod" type="submit">Buscar</button>
					</p>
				</form>
			</div>
		<div class="productos">	
			<?php 
			    if(isset($_POST["boton_cod"]))
			    {
			        $codigo = $_POST["code"];
			        $conexion = new mysqli("localhost", "root", "", "super");
			        if ($conexion->connect_error) {
			            die("Conexión fallida:". $conexion->connect_error . "Por favor comunicarse con el dueño de la página.");
			        }
			        $resultado = $conexion->query("SELECT * FROM productos WHERE codigo=$codigo");
			        $n = $resultado->num_rows;
			        if($resultado->num_rows > 0)
			        {
			            $fila = $resultado->fetch_assoc();
			            $descrip = $fila["descrip"];
			            $precio = $fila["precio"];
			            $stock = $fila["stock"];
			            $foto = $fila["foto"];
			            echo "<div class='ampliar'>
			                    <div class='foto_amp'>
			                        <a href='fotos/grandes/$foto' target='_blank' title='Ampliar Foto'><img src='fotos/grandes/$foto' alt=''></a>
			                    </div>
			                    <div class='texto_amp'>
			                        <p>$descrip</p>
			                        <p>Stock: $stock</p>
			                        <p>Precio C/U: $$precio</p>
			                        <div class='texto_er'>
			                            <p>El producto se encuentra en la base de datos, ¿Desea eliminar el producto?</p>
			                            <a href='baja.php' title='Volver a baja'>Cancelar</a>
			                            <a href='baja2.php?codigo=$codigo' class='bot_alta'>Eliminar</a>
			                        </div>
			                    </div>
			                  </div>";
			        }
				        else
				        {
				            echo "<div class='er'>
				                    <div class='foto_er'>
				                        <img src='fotos/error.png' alt='imagen de error'>
				                    </div>
				                    <p>El producto no figura en la Base de datos.</p>
				                  </div>";
				        }
			        $conexion->close();
			    }	   
			?>
		</div>
	</main>
	<footer>
		<div class="logo">
			<img src="fotos/logo1.jpg">
		</div>
		<div class="info">
			<p>W. de Tata 4699, B1676 BBE, Provincia de Buenos Aires</p>
			<p>Telefono: 011 4750-4314</p>
		</div>
	</footer>
</body>
</html>