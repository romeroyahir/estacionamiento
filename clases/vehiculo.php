<?php

class vehiculo
{
    private $patente;
    private $horaingreso;

    function __construct($pat, $ahora)
    {
        $this->$patente=$pat;
        $this->$horaingreso=$ahora;

    }

    public function GetPatente()
    {
        return $this->patente;
    }

    public function Estacionar($patente)
    {
        $archivo=fopen("archivos/estacionados.txt", "a");//escribe y mantiene la informacion existente		
		$ahora=date("Y-m-d H:i:s"); 
        
        $renglon=$patente."=>".$horaingreso."\n";
		fwrite($archivo, $renglon); 		 
        
        fclose($archivo);
    }

    public function Sacar($patente)
    {
        $listado=estacionamiento::TraerTodo();
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


    public function TraerTodo()
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

    public function GuardarTodo($ListaDeAutosLeida)
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

}



?>
