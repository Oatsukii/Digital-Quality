<?php
include("../db/ConexionDB.php");

class ModeloNormasDocumentos extends ConexionDB
{
    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];

    }

    public static function listarNormaDocumentoLineaM($datos)
	{
		static $query = "SELECT * FROM(
                            SELECT dl.s_documentos_lista ,docl.id_s_norma_documento_linea, docl.creado, docl.creadopo, docl.actualizado
                                            ,docl.actualizadopor, docl.id_s_norma_documento, docl.esactivo, docl.nombre_archivo
                                            ,dl.fecha_disponible, encode(dl.archivo, 'base64')AS archivo
                                            ,n.nombre_norma
                                            ,docl.esactivo
                                            ,CASE WHEN  docl.esactivo = true THEN 'SI' ELSE 'NO' END AS status_activo
                                            ,MAX(dl.fecha_disponible) OVER( PARTITION BY dl.id_s_norma_documento_linea)AS ultimaFecha
                                    FROM s_norma_documento_linea AS docl
                                    INNER JOIN s_norma_documento AS doc
                                        ON doc.id_s_norma_documento = docl.id_s_norma_documento
                                    INNER JOIN s_norma AS n
                                        ON n.id_s_norma = doc.id_s_norma
                                    INNER JOIN s_empresa AS em
                                        ON em.id_s_empresa = doc.id_s_empresa
                                    INNER JOIN s_documentos_lista AS dl
                                        ON dl.id_s_norma_documento_linea = docl.id_s_norma_documento_linea
                        ) AS documentos
                        WHERE fecha_disponible = ultimaFecha AND  id_s_norma_documento = :id_s_norma_documento";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt->bindParam(":id_s_norma_documento", $datos->id_s_norma_documento, PDO::PARAM_INT);
        $stmt -> execute();
        return  $stmt -> fetchAll(PDO::FETCH_ASSOC);
       
	}

    public static function agregarNormaDocumentoLineaM($datos)
    {
        try {
            static $tabla = "s_norma_documento_linea";
            $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla ( creado, creadopo, actualizado, actualizadopor, id_s_norma_documento, esactivo, nombre_archivo, fecha_disponible, archivo )
                                                    VALUES (CURRENT_TIMESTAMP,:usuario, CURRENT_TIMESTAMP,:usuario, :id_s_norma_documento, :esactivo, :nombre_archivo, :fecha_disponible, decode('{$datos->archivo_bytea}' , 'hex') )RETURNING id_s_norma_documento_linea");
            $stmt->bindParam(":usuario", self::$vIdUsuario, PDO::PARAM_INT);
            $stmt->bindParam(":id_s_norma_documento", $datos->id_s_norma_documento, PDO::PARAM_INT);
            $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
            $stmt->bindParam(":nombre_archivo", $datos->nombre_archivo, PDO::PARAM_STR);
            $stmt->bindParam(":fecha_disponible", $datos->fecha_disponible, PDO::PARAM_STR);

            if ($stmt->execute()) {

                // $id_s_norma_documento_linea = $stmt -> fetchAll(PDO::FETCH_ASSOC);
                // $id_s = $id_s_norma_documento_linea['id_s_norma_documento_linea'];
                // echo $id_s;
                // $resultado = new ModeloNormasDocumentos();
                // $resultado ->agregarDocumentos( $datos, $id_s );

                // $result = $stmt->fetch(PDO::FETCH_ASSOC);
                // $ID = $result["id_s_norma_documento_linea"]; 

                while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $id_s = $data['id_s_norma_documento_linea'];
                }
                $resultado = new ModeloNormasDocumentos();
                $resultado ->agregarDocumentos( $datos, $id_s );

                return true;

            }
           
            
        } catch (Exception $exc) {
            return $exc;
        }
    }

    public static function agregarDocumentos($datos, $id_s_norma_documento_linea)
    {
        try {
            static $tabla = "s_documentos_lista";
            $stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla ( creado, creadopor, actualizado, actualizadopor, id_s_norma_documento_linea, fecha_disponible, archivo )
                                                    VALUES (CURRENT_TIMESTAMP,:usuario, CURRENT_TIMESTAMP,:usuario, :id_s_norma_documento_linea, :fecha_disponible, decode('{$datos->archivo_bytea}' , 'hex') )");
            $stmt->bindParam(":usuario", self::$vIdUsuario, PDO::PARAM_INT);
            $stmt->bindParam(":id_s_norma_documento_linea", $id_s_norma_documento_linea, PDO::PARAM_INT);
            $stmt->bindParam(":fecha_disponible", $datos->fecha_disponible, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return true;
            }
           
            
        } catch (Exception $exc) {
            return $exc;
        }
    }

    public static function editarNormaDocumentoLineaM($datos)
	{
            try {
                    static $tabla = "s_norma_documento_linea";
                    $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET actualizado = NOW(), actualizadopor=:usuario, esactivo =:esactivo, nombre_archivo=:nombre_archivo, fecha_disponible=:fecha_disponible WHERE id_s_norma_documento_linea= :id");

                $stmt->bindParam(":usuario", self::$vIdUsuario, PDO::PARAM_INT);
                    $stmt->bindParam(":esactivo", $datos->esactivo, PDO::PARAM_BOOL);
                    $stmt->bindParam(":nombre_archivo", $datos->nombre_archivo, PDO::PARAM_STR);
                    $stmt->bindParam(":fecha_disponible", $datos->fecha_disponible, PDO::PARAM_STR);
                    $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                    if ($stmt->execute()) {

                        if($datos->documento == 1){
                            $resultado = new ModeloNormasDocumentos();
                            $resultado ->agregarDocumentos( $datos, $datos->id );
                        }
                        return true;
                    }
                   

            } catch (Exception $exc) {

                return $exc;
            } 
	}

	public static function eliminarNormaDocumentoLineaM($datos)
    {
         try {
                static $tabla = "s_norma_documento_linea";
                $stmt = ConexionDB::conectar()->prepare("DELETE FROM $tabla WHERE id_s_norma_documento_linea = :id");
                $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

                if($stmt->execute())
                    return true;
                   
            } catch (Exception $exc) {

                return $exc;
            }
    }
}

ModeloNormasDocumentos::inicializacion();


?>