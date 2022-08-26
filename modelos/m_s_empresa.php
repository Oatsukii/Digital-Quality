<?php
include("../db/ConexionDB.php");

class ModeloEmpresa extends ConexionDB
{
    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];
        self::$vIdRol = (int) $_SESSION['usuario'][0]['id_s_rol'];
    }   


    public static function listarEmpresaM($datos)
	{
		static $query = "SELECT
                            id_s_empresa, creado, creado_por, actualizado, actualizado_por, nombre, descripcion, CASE WHEN activo = TRUE THEN 'Activo' ELSE 'No Activo' END AS status_activo, activo,s_contexto, id_adempiere_empresa
                        FROM s_empresa
                        ORDER BY id_s_empresa
                        ";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
	}

    public static function agregarEmpresaM($datos)
    {
        try {
                static $tabla = "s_empresa";
                $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (creado, creado_por, actualizado, actualizado_por, nombre, descripcion, activo, s_contexto, id_adempiere_empresa)
                                                        VALUES (CURRENT_TIMESTAMP,:creadopor, CURRENT_TIMESTAMP,:actualizadopor, :nombre, :descripcion , :activo, :s_contexto, :id_adempiere)");
                $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
                $stmt->bindParam(":descripcion", $datos->descripcion, PDO::PARAM_STR );
                $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);
                $stmt->bindParam(":s_contexto", $datos->imagen, PDO::PARAM_STR );
                $stmt->bindParam(":id_adempiere", $datos->id_adempiere, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    return true;
                }
                
            } catch (Exception $exc) {
                return $exc;
            }
    }

    public static function editarEmpresaM($datos)
	{
            try {
                    static $tabla = "s_empresa";
                    $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, descripcion =:descripcion ,activo =:activo, actualizado = CURRENT_TIMESTAMP, actualizado_por=:actualizadopor, s_contexto=:s_contexto, id_adempiere_empresa=:id_adempiere 
                                                            WHERE id_s_empresa= :id");

                    $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);
                    $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
                    $stmt->bindParam(":descripcion", $datos->descripcion, PDO::PARAM_STR );
                    $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);
                    $stmt->bindParam(":s_contexto", $datos->s_contexto, PDO::PARAM_STR );
                    $stmt->bindParam(":id_adempiere", $datos->id_adempiere, PDO::PARAM_INT);
                    $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);


                    if ($stmt->execute()) {
                        return true;
                    }
                    

            } catch (Exception $exc) {

                return $exc;
            } 
	}

	public static function eliminarEmpresaM($datos)
    {
         try {
                static $tabla = "s_empresa";
                $stmt = ConexionDB::conectar()->prepare("DELETE FROM $tabla WHERE id_s_empresa = :id");
                $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
                    
            } catch (Exception $exc) {

                return $exc;
            }
    }

}

ModeloEmpresa::inicializacion();


?>