<?php 
include("../db/ConexionDB.php");

class LoginModelo extends ConexionDB{

	public static function buscarUsuarioM($datos){
        try {
            static $query = "SELECT
                                e.id_s_usuario
                                ,e.nombre
                                ,e.usuario
                            FROM s_usuario e
                            WHERE e.usuario = :usuario 
                                -- AND contrasena = md5(:contrasenia)
                                AND e.activo = true;";

                $stmt = ConexionDB::conectar()->prepare($query);
                $stmt->bindParam(":usuario", $datos->user, PDO::PARAM_STR);
                // $stmt->bindParam(":contrasenia", $datos->password, PDO::PARAM_STR);

                $stmt -> execute();
                return $stmt -> fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {

                return $e;
            }

    }


	public static function obtenerRolesUsuarioM($datos){
        //$rol =  $datos->rol;
            try {
                        
                        static $query = "SELECT
                                            e.id_s_usuario
                                            ,e.id_s_empresa
                                            ,e.nombre
                                            ,e.materno
                                            ,e.paterno
                                            ,e.usuario
                                            ,r.rol
                                            ,r.id_s_rol
                                            ,r.nombre AS nombrerol
                        
                                        FROM s_usuario e
                                        INNER JOIN s_usuario_rol er ON er.id_s_usuario = e.id_s_usuario
                                        INNER JOIN s_rol r ON r.id_s_rol = er.id_s_rol
                                        WHERE e.activo = true 
                                            AND r.activo = true
                                                AND usuario = :usuario --AND contrasena =  md5(:contrasenia)
                                                ";

                        $stmt = ConexionDB::conectar()->prepare($query);
                        $stmt->bindParam(":usuario", $datos->user, PDO::PARAM_STR);
                        // $stmt->bindParam(":contrasenia", $datos->password, PDO::PARAM_STR);

                        $stmt -> execute();
                        
                        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
                        
                        

            } catch (Exception $e) {
                    return $e;
                }

    }


	public static function validaraccesoM($datos){

            try {
                static $query = "SELECT
                                    e.id_s_usuario
                                    ,e.id_s_empresa
                                    ,e.nombre
                                    ,e.materno
                                    ,e.paterno
                                    ,e.usuario
                                    ,r.rol
                                    ,r.id_s_rol
                                    ,r.nombre AS nombrerol
                                    ,COALESCE(e.ad_user_id,1000035) AS ad_user_id
                
                                    FROM s_usuario e
                                    INNER JOIN s_usuario_rol er 
                                        ON er.id_s_usuario = e.id_s_usuario
                                    INNER JOIN s_rol r 
                                        ON r.id_s_rol = er.id_s_rol
                                    INNER JOIN s_empresa AS em 
                                        ON em.id_s_empresa = e.id_s_empresa
                                    WHERE 
                                        e.usuario= :usuario --AND e.contrasena = md5(:contrasenia)
                                    AND r.id_s_rol = :rol
                                    AND e.activo = true;	
                                ";


                        $stmt = ConexionDB::conectar()->prepare($query);
                        $stmt->bindParam(":usuario", $datos->user, PDO::PARAM_STR);
                        // $stmt->bindParam(":contrasenia", $datos->password, PDO::PARAM_STR);
                        $stmt->bindParam(":rol", $datos->rol, PDO::PARAM_INT);

                        $stmt -> execute();

                        session_start();   
                        $_SESSION['usuario'] = $stmt -> fetchAll(PDO::FETCH_ASSOC);
                        $resultado = new LoginModelo();
                        $resultado ->obtenerMenu($_SESSION['usuario'][0]['id_s_usuario'] ,$_SESSION['usuario'][0]['id_s_rol']);
                        return $stmt -> fetchAll(PDO::FETCH_ASSOC);

            } catch (Exception $e) {
                    return $e;
                }
    }

	public static function obtenerMenu($idusuario,$idrol){

        try {
            static $query = "SELECT 
                                us.id_s_usuario AS IDUsuario
                                ,us.nombre AS Usuario
                                ,us.id_s_empresa
                                ,rol.rol AS IdentificadorRol
                                ,rol.nombre AS Rol
                                ,menu.nombre AS NombreUrl
                                ,menu.url AS Url
                                ,menu.svg AS SVG

                            FROM s_usuario AS us
                            INNER JOIN s_usuario_rol AS us_rol
                                ON us_rol.id_s_usuario = us.id_s_usuario
                            INNER JOIN s_rol AS rol	
                                ON rol.id_s_rol = us_rol.id_s_rol
                                AND rol.activo = true
                            INNER JOIN s_rol_menu AS menu_rol
                                ON menu_rol.id_s_rol = rol.id_s_rol
                            INNER JOIN s_menu AS menu
                                ON menu.id_s_menu = menu_rol.id_s_menu
                            INNER JOIN s_menu_relacion AS menu_relacion
                                ON menu_relacion.id_s_menu = menu.id_s_menu 
                            INNER JOIN s_empresa AS em
                                ON em.id_s_empresa = us.id_s_empresa
                                    AND menu_rol.id_s_empresa = em.id_s_empresa
                                    AND menu_relacion.id_s_empresa = em.id_s_empresa
                            WHERE
                                us.id_s_usuario = :idusuario
                                AND rol.id_s_rol = :idrol
                                    AND menu.activo = true		
                                        AND menu.pagina_principal = true

                            ORDER BY menu.orden ASC
                            ";


                    $stmt = ConexionDB::conectar()->prepare($query);
                    $stmt->bindParam(":idusuario", $idusuario, PDO::PARAM_STR);
                    $stmt->bindParam(":idrol", $idrol, PDO::PARAM_INT);

                    $stmt -> execute();

                    //session_start();   
                    $_SESSION['menu'] = $stmt -> fetchAll(PDO::FETCH_ASSOC);

                    return $stmt -> fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
                return $e;
            }

}






}

?>