<?php
include("../db/ConexionDB.php");

class ModeloRol extends ConexionDB
{

    public static function listarRolM()
	{
		static $tabla = "rol";
		$stmt = ConexionDB::conectar()->prepare("SELECT *,CASE WHEN  activo = true THEN 'Activo' ELSE 'No Activo' END EstadoActivo FROM $tabla ORDER BY id_rol ASC");
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
	}
    
    public static function agregarRolM($datos)
    {
        try {
                static $tabla = "rol";
                $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (rol,nombre,activo)
                                                        VALUES (:rol,:alias,:checked)");    
    
                $stmt->bindParam(":rol", $datos->rol, PDO::PARAM_STR);
                $stmt->bindParam(":alias", $datos->alias, PDO::PARAM_STR);
                $stmt->bindParam(":checked", $datos->checked, PDO::PARAM_BOOL);
    
                if($stmt->execute())
                    return true;
                    
                $stmt->close();
            } catch (Exception $exc) {
    
                return $exc;
            }
    
    }
    
	public static function editarRolM($datos)
	{
            try {
                    static $tabla = "rol";
                    $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET rol = :rol ,nombre=:alias ,activo = :checked WHERE id_rol= :id");

                    $stmt->bindParam(":rol", $datos->rol, PDO::PARAM_STR);
                    $stmt->bindParam(":alias", $datos->alias, PDO::PARAM_STR);
                    $stmt->bindParam(":checked", $datos->checked, PDO::PARAM_BOOL);
                    $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                    if($stmt->execute())
                        return true;
                    //cerrar la conexion con la base de datos
                    $stmt->close();

            } catch (Exception $exc) {

                return $exc;
            }             
	}

	public static function eliminarRolM($datos)
    {
         try {
                static $tabla = "rol";
                $stmt = ConexionDB::conectar()->prepare("DELETE FROM $tabla WHERE id_rol = :id");
                $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
                    $stmt->close();
            } catch (Exception $exc) {

                return $exc;
            }     
    }    
        
    public static function listarRolEspecificoM($datos)
	{
		static $tabla = "rol";
		$stmt = ConexionDB::conectar()->prepare("SELECT *,CASE WHEN  activo = true THEN 'Activo' ELSE 'No Activo' END EstadoActivo FROM $tabla WHERE id_rol = :id");
        $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
	}

}

/*

    if ($received_data->action == 'mostarDato') {
        $query = "SELECT * FROM rol WHERE id_rol = '" . $received_data->id . "'  ";
    
        $statement = $connect->prepare($query);
    
        $statement->execute();
    
        $result = $statement->fetchAll();
        
        foreach ($result as $row) {
            $data['id'] = $row['id_rol'];
            $data['rol'] = $row['rol'];
            $data['alias'] = $row['nombre'];
            $data['checked'] = $row['activo'];

        }
    
        echo json_encode($data);
    }

    if ($received_data->action == 'mostarDatoParametro') {
        $query = "SELECT rol,nombre FROM rol WHERE id_rol = '" . $received_data->id . "'  ";
    
        $statement = $connect->prepare($query);
    
        $statement->execute();
    
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
    
        echo json_encode($data);
    }
  
*/
?>