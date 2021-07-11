<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as ResponseMW;

class Mdw{

    // el metodo siempre retorna un objeto de tipo Response
    public function miMdw (Request $request, RequestHandler $handler) : ResponseMW {
        
        if($request->getMethod() === "GET")
        {
            $antes =  " desde el metodo de instacia (antes del verbo)<br>"; // escribo algo
            $response = $handler->handle($request); // ejecuto el metodo desde donde soy invocado
            $contenidoAPI =  (string) $response->getBody(); // guardo el body en un variable
            $response =  new ResponseMW(); // genero instancia de nueva respuesta
            $despues =  " desde el metodo de instancia (despues del verbo)"; // escribo otra cosa 
            $response->getBody()->write("{$antes} {$contenidoAPI} <br> {$despues}"); //muestro todo
        }
        else{
            $ArrayDeParametros = $request->getParsedBody();
            $tipo="";
            $nombre="";
            if(isset($ArrayDeParametros))
            {
                $nombre=$ArrayDeParametros['nombre'];
                $tipo=$ArrayDeParametros['tipo'];
            }
            if($tipo=="administrador"){
                $response =  new ResponseMW(); 
                $response->getBody()->write("Bienvenido Admin " . $nombre);
            }
            else{
                $response =  new ResponseMW(); 
                $response->getBody()->write("Necesita autentificacion");
            }

        }
 
        return $response;
    }
}


?>