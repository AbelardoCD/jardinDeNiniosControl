<?php

include("../conexion.php");
header("Content-Type: text/html;charset=utf-8");
$titulo = "";


mysql_set_charset('utf8');
$cnx = conectar();

$opcion = $_POST['opcion'];



///listar todos los registros del catalogo 
if ($opcion == "listar_todos"){
    
    $consulta = "SELECT id_alumno, nombre, apellidos,fecha_nacimiento,tipo_sangre,curp,id_tutor,direccion FROM alumno"; 

    $rset= @mysql_query($consulta, $cnx) or die(mysql_error());
    $cfilas = mysql_num_rows($rset);

    $arrayDatos = array();
    if ($cfilas != 0) {
        $i = 0;
        while ($fila = mysql_fetch_array($rset)) {
            $arrayDatos[$i] =
                            array(
                                'id_alumno' =>  $fila['id_alumno'], 
                                'nombre' =>  $fila['nombre'],
                                'apellidos' =>  $fila['apellidos'],
                                'fecha_nacimiento' =>  $fila['fecha_nacimiento'],
                                'tipo_sangre' =>  $fila['tipo_sangre'],
                                'curp' =>  $fila['curp'],
                                'direccion' =>  $fila['direccion'],
                                'id_tutor' =>  $id_tutor['id_tutor']
                                
                                
                               
                            );
                        
          $i++;
        }

    }

    echo json_encode($arrayDatos);


}



if ($opcion == "listar_usuarios"){
    
    $consulta = "SELECT id_usuario, correo, password, id_tipo_usuario FROM usuario"; 

    $rset= @mysql_query($consulta, $cnx) or die(mysql_error());
    $cfilas = mysql_num_rows($rset);

    $arrayDatos = array();
    if ($cfilas != 0) {
        $i = 0;
        while ($fila = mysql_fetch_array($rset)) {
            $arrayDatos[$i] =
                            array(
                                'id_usuario' =>  $fila['id_usuario'], 
                                'correo' =>  $fila['correo'],
                                'password' =>  $fila['password'],
                                'id_tipo_usuario' =>  $fila['id_tipo_usuario']
                            );
                        
          $i++;
        }

    }

    echo json_encode($arrayDatos);


}

//para ejecutar un SQL DELETE de un registro
if ($opcion  == "eliminar_registro"){
    
    $id_registro = setear_comillas($_POST['id_registro']);

    $query= " DELETE FROM tutor WHERE id_tutor = $id_registro  ";


    $ok = @mysql_query($query, $cnx) or die(mysql_error());

    echo "$ok";

}

//guardar un registro, ya sea un INSERT (accion = guardar) o un UPDATE (accion = actualizar)
if ($opcion  =="guardar_registro"){

    $id_tutor = setear_comillas($_POST['id_tutor']);
    $nombre = setear_comillas($_POST['nombre']);
    $apellidos = setear_comillas($_POST['apellidos']);
    $telefono = setear_comillas($_POST['telefono']);
    $id_usuario = setear_comillas($_POST['id_usuario']);

    $accion = $_POST['accion'];
            
    if ($accion == "guardar"){      //<---Nuevo registro
        $q = " INSERT INTO tutor (nombre, apellidos, telefono, id_usuario) " 
            ." VALUES ($nombre, $apellidos, $telefono, $id_usuario) ";
    }else{                          //<---Actualizar registro
        $q = " UPDATE  tutor SET  nombre = $nombre, apellidos = $apellidos, telefono = $telefono, id_usuario = $id_usuario  " 
        ." WHERE  id_tutor = $id_tutor ";
    }
    $ok = @mysql_query($q, $cnx) or die(mysql_error());

    echo "$ok";

}



//buscar y carga un solo registro para su edición
if ($opcion == "obtener_registro"){

    $id_tutor = setear_comillas($_POST['id_tutor']);
  

    $query= 
    "  SELECT id_tutor, nombre, apellidos, telefono, id_usuario FROM tutor ".
    "  WHERE  id_tutor = $id_tutor ";
    $rset = @mysql_query($query, $cnx) or die(mysql_error());

    $fila = mysql_fetch_row($rset);

    
    echo json_encode($fila);
}


?>