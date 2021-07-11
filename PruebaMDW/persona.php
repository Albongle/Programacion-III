<?php

class Persona{
    public function MostrarPersona($request, $response, $args)
    {
        $response->getBody()->write("Soy una Persona");
        return $response;
    }
}


?>