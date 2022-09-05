<?php
include("../db/ConexionDB.php");

class ModeloNormasDocumentos extends ConexionDB
{
    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];

    }

    public static function listarNormasDocumentosM($datos)
	{
		static $query = "SELECT nd.id_s_norma_documento, nd.creado, nd.creadopor, nd.actualizado, nd.actualizadopor, nd.id_s_empresa, nd.id_s_norma, nd.descripcion, nd.esactivo
                            ,em.nombre AS empresa, n.nombre_norma
                            ,CASE WHEN  nd.esactivo = true THEN 'SI' ELSE 'NO' END AS status_activo
                        FROM s_norma_documento AS nd
                        INNER JOIN s_empresa AS em
                            ON em.id_s_empresa  = nd.id_s_empresa
                        INNER JOIN s_norma AS n
                            ON n.id_s_norma = nd.id_s_norma
                        ";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

    public static function agregarNormasDocumentosM($datos)
    {
        try {
                static $tabla = "s_norma_documento";
                $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (creado, creadopor, actualizado, actualizadopor, id_s_empresa, id_s_norma, descripcion, esactivo)
                                                        VALUES (NOW(),:usuario, NOW(),:usuario, :id_s_empresa, :id_s_norma, :descripcion, :esactivo)");
                $stmt->bindParam(":usuario", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":id_s_empresa", $datos->id_s_empresa, PDO::PARAM_INT);
                $stmt->bindParam(":id_s_norma", $datos->id_s_norma, PDO::PARAM_INT);
                $stmt->bindParam(":descripcion", $datos->descripcion, PDO::PARAM_STR );
                $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);

                if ($stmt->execute()) {
                    return true;
                }
            } catch (Exception $exc) {
                return $exc;
            }
    }

    public static function editarNormasDocumentosM($datos)
	{
            try {
                    static $tabla = "s_norma_documento";
                    $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET esactivo =:esactivo, actualizado = NOW(), actualizadopor=:usuario, id_s_empresa=:id_s_empresa, id_s_norma = :id_s_norma, descripcion = :descripcion WHERE id_s_norma_documento= :id");
                    
                    $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
                    $stmt->bindParam(":usuario", self::$vIdUsuario, PDO::PARAM_INT);
                    $stmt->bindParam(":id_s_empresa", $datos->id_s_empresa, PDO::PARAM_INT);
                    $stmt->bindParam(":id_s_norma", $datos->id_s_norma, PDO::PARAM_INT);
                    $stmt->bindParam(":descripcion", $datos->descripcion, PDO::PARAM_STR );
                    $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        return true;
                    }

            } catch (Exception $exc) {

                return $exc;
            } 
	}

	public static function eliminarNormasDocumentosM($datos)
    {
         try {
                static $tabla = "s_norma_documento";
                $stmt = ConexionDB::conectar()->prepare("DELETE FROM $tabla WHERE id_s_norma_documento = :id");
                $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
            } catch (Exception $exc) {

                return $exc;
            }
    }

    public static function listarEmpresasM($datos)
	{
		static $query = "SELECT
                            *
                        FROM s_empresa
                        WHERE activo =true
                        ORDER BY id_s_empresa
                        ";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

    public static function listarNormasM($datos)
	{
		static $query = "SELECT
                            id_s_norma, creado, creadopor, actualizado, actualizadopor, nombre_norma, esactivo, esactivo, CASE WHEN  esactivo = true THEN 'SI' ELSE 'NO' END AS status_activo
                        FROM s_norma
                        WHERE esactivo =true
                        ORDER BY id_s_norma
                        ";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

}

ModeloNormasDocumentos::inicializacion();


?>