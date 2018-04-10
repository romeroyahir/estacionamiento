<?php

class estacionamiento
{

	public static function Guardar($patente)
	{

		$archivo=fopen("archivos/estacionados.txt", "a");//escribe y mantiene la informacion existente		
		$ahora=date("Y-m-d H:i:s"); 
		$renglon=$patente."=>".$ahora."\n";
		fwrite($archivo, $renglon); 		 
		fclose($archivo);
	}


	public static function GuardarListado($listado)
	{
		$archivo=fopen("archivos/estacionados.txt", "w"); 	

		foreach ($listado as $auto) 
		{
	 		  if($auto[0]!=""){
	 		  		$dato=$auto[0] ."=>".$auto[1]."\n" ;
					fwrite($archivo, $dato);
	 		  }	 	
		}
		fclose($archivo);

	}

	public static function Sacar($patente)
	{

		$listado=estacionamiento::Leer();
		$ListadoAdentro=array();
		$estaElVehiculo=false;
		foreach ($listado as $auto) 
		{
			if($auto[0]==$patente)
			{
				$estaElVehiculo=true;
				$inicio=$auto[1];	
				$ahora=date("Y-m-d H:i:s"); 			 
 				$diferencia = strtotime($ahora)- strtotime($inicio) ;
 				//http://www.w3schools.com/php/func_date_strtotime.asp
 				$importe=$diferencia*15;
				$mensaje= "tiempo transcurrido:".$diferencia." segundos <br> costo $importe ";
				
				$archivo=fopen("archivos/facturacion.txt", "a"); 		  
		 		$dato=$patente ."=> $".$importe."\n" ;
		 		fwrite($archivo, $dato);
		 		fclose($archivo);


			}
			else
			{
				$ListadoAdentro[]=$auto;				
			}
		}// fin del foreach

		if(!$estaElVehiculo)
		{
			$mensaje= "no esta esa patente!!!";
		}


		estacionamiento::GuardarListado($ListadoAdentro);


		echo $mensaje;
	}
		
	public static function Leer()
	{
		$ListaDeAutosLeida=   array();
		$archivo=fopen("archivos/estacionados.txt", "r");//escribe y mantiene la informacion existente

			
		while(!feof($archivo))
		{
			$renglon=fgets($archivo);
			//http://www.w3schools.com/php/func_filesystem_fgets.asp
			$auto=explode("=>", $renglon);
			//http://www.w3schools.com/php/func_string_explode.asp
			$auto[0]=trim($auto[0]);
			if($auto[0]!="")
				$ListaDeAutosLeida[]=$auto;
		}

		fclose($archivo);
		return $ListaDeAutosLeida;
		

	}


	public static function CrearTablaEstacionados()
	{
		$lista =estacionamiento::TraerTodo();
		$archivo=fopen("archivos/tablaestacionados.php","w");


		$TablaCompleta=" <table border=1><th> patente </th><th> Ingreso</th>";
		$renglon="";
		
		foreach ($lista as $auto) 
		{
			$renglon= $renglon."<tr> <td> ".$auto[0] ." </td> <td> ". $auto[1]."</td> </tr>" ; 
		
  		}
		$TablaCompleta =$TablaCompleta.$renglon." </table>";

			fwrite($archivo, $TablaCompleta);

	}

	public static function CrearJSAutocompletar()
	{		
			$cadena="";

			$archivo=fopen("archivos/estacionados.txt", "r");

		    while(!feof($archivo))
		    {
			      $archAux=fgets($archivo);
			      //http://www.w3schools.com/php/func_filesystem_fgets.asp
			      $auto=explode("=>", $archAux);
			      //http://www.w3schools.com/php/func_string_explode.asp
			      $auto[0]=trim($auto[0]);

			      if($auto[0]!="")
			      {
			      	 $auto[1]=trim($auto[1]);
			      $cadena=$cadena." {value: \"".$auto[0]."\" , data: \" ".$auto[1]." \" }, \n"; 
		 


			      }
			}
		    fclose($archivo);

			 $archivoJS="$(function(){
			  var patentes = [ \n\r
			  ". $cadena."
			   
			  ];
			  
			  // setup autocomplete function pulling from patentes[] array
			  $('#autocomplete').autocomplete({
			    lookup: patentes,
			    onSelect: function (suggestion) {
			      var thehtml = '<strong>patente: </strong> ' + suggestion.value + ' <br> <strong>ingreso: </strong> ' + suggestion.data;
			      $('#outputcontent').html(thehtml);
			         $('#botonIngreso').css('display','none');
      						console.log('aca llego');
			    }
			  });
			  

			});";
			
			$archivo=fopen("js/funcionAutoCompletar.js", "w");
			fwrite($archivo, $archivoJS);
	}

		public static function CrearTablaFacturado()
	{
			if(file_exists("archivos/facturacion.txt"))
			{
				$cadena=" <table border=1><th> patente </th><th> Importe </th>";

				$archivo=fopen("archivos/facturacion.txt", "r");

			    while(!feof($archivo))
			    {
				      $archAux=fgets($archivo);
				      //http://www.w3schools.com/php/func_filesystem_fgets.asp
				      $auto=explode("=>", $archAux);
				      //http://www.w3schools.com/php/func_string_explode.asp
				      $auto[0]=trim($auto[0]);
				      if($auto[0]!="")
				       $cadena =$cadena."<tr> <td> ".$auto[0]."</td> <td>  ".$auto[1] ."</td> </tr>" ; 
				}

		   		$cadena =$cadena." </table>";
		    	fclose($archivo);

				$archivo=fopen("archivos/tablaFacturacion.php", "w");
				fwrite($archivo, $cadena);




			}	else
			{
				$cadena= "no hay facturación";

				$archivo=fopen("archivos/tablaFacturacion.php", "w");
				fwrite($archivo, $cadena);
			}

	}


}


?>