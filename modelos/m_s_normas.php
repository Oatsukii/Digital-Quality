<?php
include("../db/ConexionDB.php");

class ModeloNormas extends ConexionDB
{
    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];

    }

    public static function listarNormasM($datos)
	{
		static $query = "SELECT
                            id_s_norma, creado, creadopor, actualizado, actualizadopor, nombre_norma, esactivo, esactivo, CASE WHEN  esactivo = true THEN 'SI' ELSE 'NO' END AS status_activo
                        FROM s_norma
                        ORDER BY id_s_norma
                        ";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

    public static function agregarNormasM($datos)
    {
        try {
                static $tabla = "s_norma";
                $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (creado, creadopor, actualizado, actualizadopor, nombre_norma, esactivo)
                                                        VALUES (NOW(),:usuario, NOW(),:usuario, :nombre_norma, :esactivo)");
                $stmt->bindParam(":usuario", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":nombre_norma", $datos->nombre_norma, PDO::PARAM_STR );
                $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);

                if ($stmt->execute()) {
                    return true;
                }
            } catch (Exception $exc) {
                return $exc;
            }
    }

    public static function editarNormasM($datos)
	{
            try {
                    static $tabla = "s_norma";
                    $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET esactivo =:esactivo, actualizado = NOW(), actualizadopor=:usuario, nombre_norma=:nombre_norma WHERE id_s_norma= :id");

                    $stmt->bindParam(":usuario", self::$vIdUsuario, PDO::PARAM_INT);
                    $stmt->bindParam(":nombre_norma", $datos->nombre_norma, PDO::PARAM_STR );
                    $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
                    $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        return true;
                    }

            } catch (Exception $exc) {

                return $exc;
            } 
	}

	public static function eliminarNormasM($datos)
    {
         try {
                static $tabla = "s_norma";
                $stmt = ConexionDB::conectar()->prepare("DELETE FROM $tabla WHERE id_s_norma = :id");
                $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
            } catch (Exception $exc) {

                return $exc;
            }
    }
}

ModeloNormas::inicializacion();


?>