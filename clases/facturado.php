<?php
Clase Facturado
Atributos Privados: Vehiculo, HoraSalida, Importe
Constructor: Recibe un vehiculo y una HoraSalida
Metodo TraerTodo: Retorna listado de facturados
Metodo GuardarTodo: Retorna TRUE o FALSE, recibe un litado de facturados
class Facturado
{
    private $vehiculo;
    private $horasalida;
    private $importe;

    public function __construct($vehic, $horachau)
    {
        $this->$vehiculo=$vehic;
        $this->$horasalida=$horachau;
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
        
                foreach ($ListaDeAutosLeida as $auto) 
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