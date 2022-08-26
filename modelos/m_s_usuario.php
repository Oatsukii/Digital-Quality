<?php

include("../db/ConexionDB.php");

class ModeloUsuario extends ConexionDB
{
    public static $vIdRol;
    public static $vIdUsuario;

    public static function inicializacion(){
        self::$vIdUsuario = (int) $_SESSION['usuario'][0]['id_s_usuario'];
        self::$vIdRol = (int) $_SESSION['usuario'][0]['id_s_rol'];
    }

    public static function listarUsuariosM()
	{
		static $tabla = "s_usuario";
		$stmt = ConexionDB::conectar()->prepare("SELECT * FROM $tabla ORDER BY id_s_usuario ASC");
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

	public static function agregarUsuariosM($datos)
	{
		static $tabla = "s_usuario";
		$stmt = ConexionDB::conectar()->prepare("INSERT INTO $tabla (creado, creado_por, actualizado, actualizado_por, id_s_empresa, nombre,paterno,materno,activo,usuario,contrasena,ad_user_id)
                                                 VALUES (now(), :creado_por, now(), :actualizado_por, :id_s_empresa, :first_name,:paternal_name,:maternal_name,:checked,LOWER(:user),md5('refividrio20'),:ad_user)");

        $stmt->bindParam(":creado_por", self::$vIdUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":actualizado_por", self::$vIdUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":first_name", $datos->first_name, PDO::PARAM_STR);
        $stmt->bindParam(":paternal_name", $datos->paternal_name, PDO::PARAM_STR);
        $stmt->bindParam(":maternal_name", $datos->maternal_name, PDO::PARAM_STR);
        $stmt->bindParam(":user", $datos->user, PDO::PARAM_STR);
        $stmt->bindParam(":ad_user", $datos->ad_user, PDO::PARAM_INT);
        $stmt->bindParam(":checked", $datos->checked, PDO::PARAM_BOOL);
        $stmt->bindParam(":id_s_empresa", $datos->id_s_empresa, PDO::PARAM_INT);

        if($stmt->execute())
			return true;
			
	}

	public static function editarUsuariosM($datos)
	{
            try {
            static $tabla = "s_usuario";
            $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET nombre = :first_name, paterno = :paternal_name, materno = :maternal_name, activo = :checked, usuario = :user, ad_user_id = :ad_user, id_s_empresa= :id_s_empresa, actualizado_por = :actualizado_por  WHERE id_s_usuario = :id");


            $stmt->bindParam(":first_name", $datos->first_name, PDO::PARAM_STR);
            $stmt->bindParam(":paternal_name", $datos->paternal_name, PDO::PARAM_STR);
            $stmt->bindParam(":maternal_name", $datos->maternal_name, PDO::PARAM_STR);
            $stmt->bindParam(":user", $datos->user, PDO::PARAM_STR);
            $stmt->bindParam(":ad_user", $datos->ad_user, PDO::PARAM_INT);
            $stmt->bindParam(":checked", $datos->checked, PDO::PARAM_BOOL);
            $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);
            $stmt->bindParam(":id_s_empresa", $datos->id_s_empresa, PDO::PARAM_INT);
            $stmt->bindParam(":actualizado_por", self::$vIdUsuario, PDO::PARAM_INT);

            if($stmt->execute())
                return true;
            //cerrar la conexion con la base de datos

        } catch (Exception $exc) {

            return $exc;
        }             

	}    

    public static function obtenerDatosUsuariosM($datos)
	{
        try {

            $data = array(); 
            static $tabla = "s_usuario";
            $stmt = ConexionDB::conectar()->prepare("SELECT * FROM $tabla WHERE id_s_usuario = :id");
            $stmt->bindParam(":id", $datos->id, PDO::PARAM_INT);

            $stmt -> execute();
            $result = $stmt -> fetchAll();

            foreach ($result as $row) {
                $data['id'] = $row['id_s_usuario'];
                $data['first_name'] = $row['nombre'];
                $data['paternal_name'] = $row['paterno'];
                $data['maternal_name'] = $row['materno'];
                $data['user'] = $row['usuario'];
                $data['ad_user_id'] = $row['ad_user_id'];
                $data['checked'] = $row['activo'];
                $data['id_s_empresa'] = $row['id_s_empresa'];
            }

            return $data;


        } catch (Exception $exc) {

            return $exc;
        }  

	}  
    
	public static function cambiarContraseniaUsuariosM($datos)
	{
        try { 

            static $tabla = "s_usuario";
            $stmt = ConexionDB::conectar()->prepare("UPDATE $tabla SET  contrasena =  md5('refividrio20') WHERE id_s_usuario = :id");
            $stmt->bindParam(":id", $datos->hiddenId, PDO::PARAM_INT);

            if($stmt->execute())
                return true;

        } catch (Exception $exc) {

            return $exc;
        }  

	}

    public static function busquedaUsuarioM($datos)
	{
		$query = "SELECT * FROM s_usuario
                                
                WHERE
                activo = :combo
                AND ( UNACCENT(nombre) ILIKE '%'||:busqueda||'%'
                OR usuario ILIKE '%'||:busqueda||'%' )

                ORDER BY id_s_usuario
              
                        ";

                        //print_r($query);
                        
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt->bindParam(":busqueda", $datos->busqueda, PDO::PARAM_STR);
        $stmt->bindParam(":combo", $datos->combo, PDO::PARAM_BOOL);

        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
	}

    public static function empresasM($datos)
    {
        static $query = "SELECT
                            id_s_empresa, creado, creado_por, actualizado, actualizado_por, nombre, descripcion, activo,s_contexto, id_adempiere_empresa
                        FROM s_empresa
                        ORDER BY id_s_empresa
                        ";
		$stmt = ConexionDB::conectar()->prepare($query);
        $stmt -> execute();
        
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }


}

ModeloUsuario::inicializacion();

?>