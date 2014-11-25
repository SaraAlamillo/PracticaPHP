<?php
// TODO: función por referencia
function  CargaVista($rutaFichero, array  $variablesDeVista=NULL)
{
	if (! file_exists($rutaFichero)) {	
		return "No existe: $rutaFichero"; // Nada que incluir
	}
	
	// Creamos variables que hemos pasado en el array
	/*foreach($variablesDeVista as $nombreVariableArrayEnForeach=>$valorVariableArray)
	{   // OJO al doble $
		$$nombreVariableArrayEnForeach=$valorVariableArray;
	}*/
	// Interpretamos plantilla
	ob_start();
	include($rutaFichero);
	return ob_get_clean();
	 	
}