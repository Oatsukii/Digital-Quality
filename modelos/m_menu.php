<?php

include("../db/ConexionDB.php");

class ModeloMenu extends ConexionDB
{

    public static function listarMenuM()
	{
		static $tabla = "menu";
		$stmt = ConexionDB::conectar()->prepare("SELECT *,CASE WHEN  activo = true THEN 'Activo' ELSE 'No Activo' END EstadoActivo FROM $tabla ORDER BY orden ASC");
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
	}

    public static function agregarMenuM($datos)
    {
        try {
                static $tabla = "menu";
                $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (nombre,url,svg,orden,activo,pagina_principal)
                                                        VALUES (:nombre,:url,:svg,:orden,:checked,:principal)");    
    
                $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
                $stmt->bindParam(":url", $datos->url, PDO::PARAM_STR);
                $stmt->bindParam(":svg", $datos->svg, PDO::PARAM_STR);
                $stmt->bindParam(":orden", $datos->orden, PDO::PARAM_INT);
                $stmt->bindParam(":checked", $datos->checked, PDO::PARAM_BOOL);
                $stmt->bindParam(":principal", $datos->principal, PDO::PARAM_BOOL);
    
                if($stmt->execute())
                    return true;
                    
            } catch (Exception $exc) {
    
                return $exc;
            }
    
    }

	public static function editarMenuM($datos)
	{
            try {
                    static $tabla = "menu";
                    $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET nombre=:nombre, url=:url, svg=:svg, orden=:orden, activo = :checked, pagina_principal=:principal WHERE id_menu= :id");

                    $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
                    $stmt->bindParam(":url", $datos->url, PDO::PARAM_STR);
                    $stmt->bindParam(":svg", $datos->svg, PDO::PARAM_STR);
                    $stmt->bindParam(":orden", $datos->orden, PDO::PARAM_INT);
                    $stmt->bindParam(":checked", $datos->checked, PDO::PARAM_BOOL);
                    $stmt->bindParam(":principal", $datos->checked, PDO::PARAM_BOOL);
                    $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                    if($stmt->execute())
                        return true;
            } catch (Exception $exc) {

                return $exc;
            }             
	}
    
	public static function eliminarMenuM($datos)
    {
         try {
                static $tabla = "menu";
                $stmt = ConexionDB::conectar()->prepare("DELETE FROM $tabla WHERE id_menu = :id");
                $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
                    
            } catch (Exception $exc) {

                return $exc;
            }     
    }

    public static function listadoMenuM($datos)
	{
        try {
                static $tabla = "menu";
                $stmt = ConexionDB::conectar()->prepare("SELECT *,CASE WHEN  activo = true THEN 'Activo' ELSE 'No Activo' END EstadoActivo FROM $tabla WHERE activo = :activo ORDER BY orden ASC");
                $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);
                $stmt -> execute();
                return $stmt -> fetchAll(PDO::FETCH_ASSOC);
                
            } catch (Exception $exc) {

                return $exc;
            }   

	}    

}

/*
    $received_data = json_decode(file_get_contents("php://input"));
    $data = array();

    if ($received_data->action == 'mostrarTodoActivo') {
        $query = " SELECT * FROM menu WHERE activo = true ORDER BY orden ASC ";
        $statement = $connect->prepare($query);
        $statement->execute();
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        echo json_encode($data);
    }

*/
?>