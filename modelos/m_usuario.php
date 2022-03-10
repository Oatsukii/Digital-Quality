<?php

include("../db/ConexionDB.php");

class ModeloUsuario extends ConexionDB
{

    public static function listarUsuariosM()
	{
		static $tabla = "usuario";
		$stmt = ConexionDB::conectar()->prepare("SELECT * FROM $tabla ORDER BY id_usuario ASC");
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
	}

	public static function agregarUsuariosM($datos)
	{
		static $tabla = "usuario";
		$stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (nombre,paterno,materno,activo,usuario,contrasena,ad_user_id)
                                                 VALUES (:first_name,:paternal_name,:maternal_name,:checked,LOWER(:user),md5('refividrio20'),:ad_user)");    

        $stmt->bindParam(":first_name", $datos->first_name, PDO::PARAM_STR);
        $stmt->bindParam(":paternal_name", $datos->paternal_name, PDO::PARAM_STR);
        $stmt->bindParam(":maternal_name", $datos->maternal_name, PDO::PARAM_STR);
        $stmt->bindParam(":user", $datos->user, PDO::PARAM_STR);
        $stmt->bindParam(":ad_user", $datos->ad_user, PDO::PARAM_INT);
        $stmt->bindParam(":checked", $datos->checked, PDO::PARAM_BOOL);

        if($stmt->execute())
			return true;
			
        $stmt->close();
	}

	public static function editarUsuariosM($datos)
	{
            try {
            static $tabla = "usuario";
            $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET nombre = :first_name, paterno = :paternal_name, materno = :maternal_name, activo = :checked, usuario = :user, ad_user_id = :ad_user WHERE id_usuario = :id");


            $stmt->bindParam(":first_name", $datos->first_name, PDO::PARAM_STR);
            $stmt->bindParam(":paternal_name", $datos->paternal_name, PDO::PARAM_STR);
            $stmt->bindParam(":maternal_name", $datos->maternal_name, PDO::PARAM_STR);
            $stmt->bindParam(":user", $datos->user, PDO::PARAM_STR);
            $stmt->bindParam(":ad_user", $datos->ad_user, PDO::PARAM_INT);
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

    public static function obtenerDatosUsuariosM($datos)
	{
        try {

            $data = array(); 
            static $tabla = "usuario";
            $stmt = ConexionDB::conectar()->prepare("SELECT * FROM $tabla WHERE id_usuario = :id");
            $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

            $stmt -> execute();
            $result = $stmt -> fetchAll();

            foreach ($result as $row) {
                $data['id'] = $row['id_usuario'];
                $data['first_name'] = $row['nombre'];
                $data['paternal_name'] = $row['paterno'];
                $data['maternal_name'] = $row['materno'];
                $data['user'] = $row['usuario'];
                $data['ad_user_id'] = $row['ad_user_id'];
                $data['checked'] = $row['activo'];
            }

            return $data;

            $stmt->close();

        } catch (Exception $exc) {

            return $exc;
        }  

	}  
    
	public static function cambiarContraseniaUsuariosM($datos)
	{
        try { 

            static $tabla = "usuario";
            $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET  contrasena =  md5('refividrio20') WHERE id_usuario = :id");
            $stmt->bindParam(":id", $datos->hiddenId, PDO::PARAM_INT);

            if($stmt->execute())
                return true;
               $stmt->close();

        } catch (Exception $exc) {

            return $exc;
        }  

	}

    public static function busquedaUsuarioM($datos)
	{
		$query = "SELECT * FROM usuario
                                
                WHERE
                activo = :combo
                AND ( UNACCENT(nombre) ILIKE '%'||:busqueda||'%'
                OR usuario ILIKE '%'||:busqueda||'%' )

                ORDER BY id_usuario   
              
                        ";

                        //print_r($query);
                        
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt->bindParam(":busqueda", $datos->busqueda, PDO::PARAM_STR);
        $stmt->bindParam(":combo", $datos->combo, PDO::PARAM_BOOL);

        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $stmt->close();
	}    


}

?>