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
				<h1>Búsqueda de productos</h1>
			</div>
			<div class="bus">	
					<select id="menu" onchange="formularios()">
						<option value=1>Por Código</option>
						<option value=2>Por Descripción</option>
						<option value=3>Por Marca</option>
						<option value=4>Por Precio</option>
					</select>
					</div>
			
			
			
			
			
			      <!--Por codigo-->
				<div id="cod" class="bus">	
					<form action="multibusqueda.php" method="post">
						<p>Codigo: <input type="number" name="code" autofocus required>
								   <button name="boton_cod" type="submit">Buscar</button>
						</p>
					</form>
					</div>
				<!--Por Descripción-->
				<div id="desc" class="bus">	
					<form action="multibusqueda.php" method="post">
						<p>Descripción: <input type="text" name="desc" autofocus required>
								   <button name="boton_desc" type="submit">Buscar</button>
						</p>
					</form>
					</div>
				<!--Por Marca-->
				<div id="marca" class="bus">	
					<form action="multibusqueda.php" method="post">
						<p>Marca: <input type="text" name="marca" autofocus required min="0" max="9999999999999">
								   <button name="boton_marca" type="submit">Buscar</button>
						</p>
					</form>
					</div>
				<!--Por Precio-->
				<div id="precio" class="bus">	
					<form action="multibusqueda.php" method="post">
						<p>Desde: <input type="number" name="precio" autofocus required min="0" max="9999999999999">
						<p>Hasta: <input type="number" name="precio2" autofocus required min="0" max="9999999999999">
								   <button name="boton_precio" type="submit">Buscar</button>
						</p>
					</form>
					</div>
					
				</div>
				<div class="productos">	
					<?php 
						if(isset($_POST["boton_cod"]))
						{
						   $codigo= $_POST["code"];
						   $conexion= new mysqli("localhost", "root","","super");
						   $resultado= $conexion->query("SELECT * FROM productos WHERE codigo=$codigo");
						   if($resultado->num_rows > 0)
						   {
						   	   $fila= $resultado->fetch_assoc();
							   $descrip=$fila["descrip"];
							   $precio=$fila["precio"];
							   $stock=$fila["stock"];
							   $foto=$fila["foto"];
							   echo" 
							    <div class='ampliar'>
							   		<div class='foto_amp'>
							  			<a href='fotos/grandes/$foto' target='_blank' title='Ampliar Foto'><img src='fotos/grandes/$foto' alt=''></a>
									</div>
									<div class='texto_amp'>
										<p>$descrip</p>
										<p>Stock: $stock</p>
										<p>Precio C/U: $$precio</p>
										<a href='multibusqueda.php' title='Volver a buscar'>Volver</a>
								</div>";
						    }
								else
								{
									echo" 
									<div class='er'>
										<div class='foto_er'>
											<img src='fotos/error.png' alt='imagen de error'>
										</div>
											<p>El producto no figura en la Base de datos.</p>
									</div>";
								}
						    $conexion->close();
						}	   
							elseif(isset($_POST["boton_desc"]))
								{
									$descrip= $_POST["desc"];
									$conexion= new mysqli("localhost", "root","","super");
									$resultado= $conexion->query("SELECT * FROM productos WHERE descrip LIKE '%$descrip%' ORDER BY descrip");
						   			if($resultado->num_rows > 0)
									{
										while($fila = $resultado->fetch_assoc())
											{
												$codigo=$fila["codigo"];															
												$sector=$fila["sector"];
												$marca=$fila["marca"];
												$descrip=$fila["descrip"];
											    $precio=$fila["precio"];
											    $stock=$fila["stock"];
											    $foto=$fila["foto"];
												echo"
												<div class='item'>
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
												<p>El producto no figura en la Base de datos.</p>
										</div>";
									}		
								}
									elseif(isset($_POST["boton_marca"]))
										{
											$marca= $_POST["marca"];
											$conexion= new mysqli("localhost", "root","","super");
											$resultado= $conexion->query("SELECT * FROM productos WHERE marca LIKE '$marca%'");
						   					if($resultado->num_rows > 0)
											{
												while($fila = $resultado->fetch_assoc())
													{
														$codigo=$fila["codigo"];															
														$sector=$fila["sector"];
														$marca=$fila["marca"];
														$descrip=$fila["descrip"];
													    $precio=$fila["precio"];
													    $stock=$fila["stock"];
													    $foto=$fila["foto"];
														echo"
														<div class='item'>
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
														<p>El producto no figura en la Base de datos.</p>
												</div>";
											}
										}
										
											elseif(isset($_POST["boton_precio"]))
												{
														$precio= $_POST["precio"];
														$precio2= $_POST["precio2"];
														$conexion= new mysqli("localhost", "root","","super");
														$resultado= $conexion->query("SELECT * FROM productos WHERE precio<=$precio2 AND precio>=$precio ORDER BY precio");
						   								if($resultado->num_rows > 0)
														{
															while($fila = $resultado->fetch_assoc())
																{
																	$codigo=$fila["codigo"];	
																	$sector=$fila["sector"];
																	$marca=$fila["marca"];
																	$descrip=$fila["descrip"];
																    $precio=$fila["precio"];
																    $stock=$fila["stock"];
																    $foto=$fila["foto"];
																	echo"
																	<div class='item'>
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
																		<p>El producto no figura en la Base de datos.</p>
																	</div>";
																}
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