<?php

class ValidaSessionv2
{

public function verifica_session(){
    session_start();
    if (isset($_SESSION['usuario'])) {
          return true;
    }else{  
        session_destroy(); 
        return false; 
    }  
}

public function index_session(){
    session_start();
    if (isset($_SESSION['usuario'])) {
          return true;
    }else{  
        session_destroy(); 
        return false;
    }  
}

public function usuario_id(){
    session_start();
    $id =0;
    $rol='';
    $nombre = '';
      
    foreach ($_SESSION['usuario'] as $datos ) {
      $id = $datos['id_s_usuario'];
      $rol = $datos['nombrerol'];
      $nombre = $datos['nombre'] .' '. $datos['paterno'];;
    }

    return $id;
}


}
?>