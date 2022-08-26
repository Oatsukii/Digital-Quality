<?php

include("../db/ConexionDB.php");

class ModeloInterfazProceso extends ConexionDB
{

    public static function listarInterfazProcesoM($datos)
	{
		static $tabla = "dev_interfaz";
		$stmt = ConexionDB::conectar()->prepare("SELECT * FROM $tabla WHERE activo = :activo ORDER BY orden ASC");
        $stmt->bindParam(":activo", $datos->activo, PDO::PARAM_BOOL);

        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

	public static function agregarInterfazProcesoM($datos)
	{
		static $tabla = "dev_interfaz";
		$stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (creado, actualizado, creadopor, actualizadopor, nombre, descripcion, metodo, activo, orden)
                                                 VALUES (CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, :creado, :actualizado, :nombre, :descripcion, :metodo, :checked, :orden)");    

        $stmt->bindParam(":creado", $_SESSION['idusuario'], PDO::PARAM_STR);
        $stmt->bindParam(":actualizado", $_SESSION['idusuario'], PDO::PARAM_STR);
        $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $datos->descripcion, PDO::PARAM_STR);
        $stmt->bindParam(":metodo", $datos->metodo, PDO::PARAM_STR);
        $stmt->bindParam(":orden", $datos->orden, PDO::PARAM_INT);;
        $stmt->bindParam(":checked", $datos->checked, PDO::PARAM_BOOL);

        if($stmt->execute())
			return true;
			
	}

	public static function editarInterfazProcesoM($datos)
	{
            try {
            static $tabla = "dev_interfaz";
            $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET actualizado=CURRENT_TIMESTAMP, actualizadopor=:actualizado,  nombre = :nombre, descripcion = :descripcion, metodo = :metodo, orden = :orden, activo = :checked WHERE id_dev_interfaz = :id");

            $stmt->bindParam(":actualizado", $_SESSION['idusuario'], PDO::PARAM_STR);
            $stmt->bindParam(":nombre", $datos->nombre, PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $datos->descripcion, PDO::PARAM_STR);
            $stmt->bindParam(":metodo", $datos->metodo, PDO::PARAM_STR);
            $stmt->bindParam(":orden", $datos->orden, PDO::PARAM_INT);;
            $stmt->bindParam(":checked", $datos->checked, PDO::PARAM_BOOL);
            $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

            if($stmt->execute())
                return true;

        } catch (Exception $exc) {

            return $exc;
        }             

	}    


    public static function busquedaInterfazProcesoM($datos)
	{
		$query = "SELECT * FROM dev_interfaz
                                
                WHERE
                activo = :combo
                AND ( UNACCENT(nombre) ILIKE '%'||:busqueda||'%'
                OR metodo ILIKE '%'||:busqueda||'%' )

                ORDER BY id_dev_interfaz   
              
                        ";
                        
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt->bindParam(":busqueda", $datos->busqueda, PDO::PARAM_STR);
        $stmt->bindParam(":combo", $datos->combo, PDO::PARAM_BOOL);

        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

    public static function tablaPlantillaM($datos)
	{
		static $tabla = "dev_interfaz";
		$stmt = ConexionDB::conectar()->prepare("SELECT * FROM $tabla WHERE id_dev_interfaz = :id ORDER BY id_dev_interfaz ASC");
        $stmt->bindParam(":id", $datos->id, PDO::PARAM_BOOL);

        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

    

}

?>