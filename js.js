function formularios()
{
	//Recuperamos los divs de los formularios y el menu por ID 
	
	var form_cod= document.getElementById("cod");
	var form_desc= document.getElementById("desc");
	var form_marca= document.getElementById("marca");
	var form_precio= document.getElementById("precio");
	var menu= document.getElementById("menu");
	
	//Ocultamos todos los formularios

	form_cod.style.display="none";
	form_desc.style.display="none";
	form_marca.style.display="none";
	form_precio.style.display="none";
	
	//Mostramos los menus correspondientes
	
	switch(menu.value)
	{
		case "1": form_cod.style.display="block";
				break;
		case "2": form_desc.style.display="block";
				break;
		case "3": form_marca.style.display="block";
				break;
		case "4": form_precio.style.display="block";
				break;
		
	}
}

