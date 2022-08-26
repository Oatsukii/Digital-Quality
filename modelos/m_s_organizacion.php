<?php
include("../db/ConexionDB.php");

class ModeloOrganizacion extends ConexionDB
{
    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];
        self::$vIdRol = (int) $_SESSION['usuario'][0]['id_s_rol'];
    }   


    public static function listarOrganizacionM($datos)
	{
		static $query = "SELECT
                            o.id_s_organizacion, o.creado, o.creado_por, o.actualizado, o.actualizado_por, o.nombre, o.descripcion, o.segmento, CASE WHEN o.activo = TRUE THEN 'Activo' ELSE 'No Activo' END AS status_activo, o.activo,o.s_contexto, o.id_adempiere_organizacion
                            ,em.nombre AS empresa, em.id_s_empresa
                        FROM s_organizacion AS o
                        INNER JOIN s_empresa AS em ON em.id_s_empresa = o.id_s_empresa
                        ORDER BY id_s_organizacion
                        ";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        
	}

    public static function agregarOrganizacionM($datos)
    {
        try {
                static $tabla = "s_organizacion";
                $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (id_s_empresa, creado, creado_por, actualizado, actualizado_por, nombre, descripcion, segmento, activo, s_contexto, id_adempiere_organizacion)
                                                        VALUES (:id_s_empresa,CURRENT_TIMESTAMP,:creadopor, CURRENT_TIMESTAMP,:actualizadopor, :nombre, :descripcion , :segmento, :activo, :s_contexto, :id_adempiere)");
                $stmt->bindParam(":creadopor", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);
                $stmt->bindParam(":id_s_empresa", $datos->id_s_empresa, PDO::PARAM_INT );
                $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
                $stmt->bindParam(":descripcion", $datos->descripcion, PDO::PARAM_STR );
                $stmt->bindParam(":segmento", $datos->segmento, PDO::PARAM_INT );
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

    public static function editarOrganizacionM($datos)
	{
            try {
                    static $tabla = "s_organizacion";
                    $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, descripcion =:descripcion, segmento = :segmento,activo =:activo, actualizado = CURRENT_TIMESTAMP, actualizado_por=:actualizadopor, s_contexto=:s_contexto, id_adempiere_organizacion=:id_adempiere 
                                                            WHERE id_s_organizacion= :id");

                    $stmt->bindParam(":actualizadopor", self::$vIdUsuario, PDO::PARAM_INT);
                    $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
                    $stmt->bindParam(":descripcion", $datos->descripcion, PDO::PARAM_STR );
                    $stmt->bindParam(":segmento", $datos->segmento, PDO::PARAM_INT );
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

	public static function eliminarOrganizacionM($datos)
    {
         try {
                static $tabla = "s_organizacion";
                $stmt = ConexionDB::conectar()->prepare("DELETE FROM $tabla WHERE id_s_organizacion = :id");
                $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
                    
            } catch (Exception $exc) {

                return $exc;
            }
    }

    public function EmpresasM($datos){
        static $query = "SELECT
                    id_s_empresa, creado, creado_por, actualizado, actualizado_por, nombre, descripcion, activo,s_contexto, id_adempiere_empresa
                FROM s_empresa
                WHERE activo = true
                ORDER BY id_s_empresa";
                
        $stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        

    }

}

ModeloOrganizacion::inicializacion();


?>