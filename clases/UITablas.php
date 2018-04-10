<?php

class UITablas
{
    public function CrearTablaEstacionados()
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

    public function CrearJSAutocompletar()
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

    public function CrearTablaFacturado()
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