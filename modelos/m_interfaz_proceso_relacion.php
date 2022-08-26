<?php
include("../db/ConexionDB.php");

class ModeloInterfazProcesoLinea extends ConexionDB
{

    public static function listarDevAlmacenLineaM($datos)
	{
		static $query = "SELECT 

        ori.nombre AS Empresa
        ,id_dev_interfaz_origen
    FROM dev_interfaz AS di
        INNER JOIN dev_interfaz_origen AS dio
            ON dio.id_dev_interfaz = di.id_dev_interfaz
        INNER JOIN servidor_origen AS ori
            On ori.id_servidor_origen = dio.id_servidor_origen		
    WHERE
        di.id_dev_interfaz = :id
    ";

		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt->bindParam(":id", $datos->id, PDO::PARAM_BOOL);
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

    public static function agregarDevAlmacenLineaM($datos)
    {
        try {
                static $tabla = "dev_interfaz_origen";
                $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (id_dev_interfaz, id_servidor_origen, creado, actualizado, creadopor, actualizadopor, activo)
                                                         VALUES (:idtabla, :empresa, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, null, null, true)");    
    
                $stmt->bindParam(":idtabla", $datos->idtabla, PDO::PARAM_STR);
                $stmt->bindParam(":empresa", $datos->empresa, PDO::PARAM_STR);
    
                if($stmt->execute())
                    return true;
                    
            } catch (Exception $exc) {
    
                return $exc;
            }
    
    }

	public static function editarPlantillaCorreoLineaM($datos)
	{
            try {
                    static $tabla = "dev_interfaz_origen";
                    $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET nombre=:nombre ,correo = :correo ,activo = :activo WHERE id_dev_interfaz_origen= :id");

                    $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
                    $stmt->bindParam(":correo", $datos->correo, PDO::PARAM_STR);
                    $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);
                    $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                    if($stmt->execute())
                        return true;
                    //cerrar la conexion con la base de datos

            } catch (Exception $exc) {

                return $exc;
            }             
	}

	public static function eliminarDevAlmacenLineaM($datos)
    {
         try {
                static $tabla = "dev_interfaz_origen";
                $stmt = ConexionDB::conectar()->prepare("DELETE FROM $tabla WHERE id_dev_interfaz_origen = :id");
                $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
            } catch (Exception $exc) {

                return $exc;
            }     
    }




}

?>