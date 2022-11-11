<?php
$nombre=$_POST['nombre'];
$password=$_POST['password'];
$email=$_POST['email'];
$telefono=$_POST['telefono'];
$genero=$_POST['genero'];
$estado= $_POST['estado'];

if(!empty($nombre) || !empty($password) || !empty($email) || !empty($telefono) || !empty($genero) || !empty($estado)){
    
    $host = "localhost:3307";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "formulariophp";


    $conn = new mysqli($host,$dbusername, $dbpassword, $dbname);

    
    if (mysqli_connect_error()){
        die('connect error('.mysqli_connect_error().')'.mysqli_connect_error());
    }
    
    else{
        //Verificar que no se repitan datos de los registros
        $SELECTN = "SELECT usuario from datos where usuario = ?";
        $SELECT = "SELECT telefono from datos where telefono = ? limit 1"; 
        
        $INSERT = "INSERT INTO datos (usuario, contraseña, email, telefono, genero, entidad) values(?,?,?,?,?,?)";

        $stmtn = $conn->prepare($SELECTN);
        $stmtn ->bind_param("s", $nombre);
        $stmtn ->execute();
        $stmtn -> bind_result($nombre);
        $stmtn -> store_result();

        $stmt = $conn->prepare($SELECT);
        $stmt ->bind_param("i", $telefono);
        $stmt ->execute();
        $stmt -> bind_result($telefono);
        $stmt -> store_result();

        $rnum = $stmt->num_rows;
        $rnumn = $stmtn->num_rows;

        if ($rnum == 0 && $rnumn == 0){
            $stmt ->close();
            $stmt = $conn->prepare($INSERT);
            $stmt ->bind_param("ssssss", $nombre,$password, $email, $telefono, $genero, $estado);
            $stmt ->execute();

            $stmtn ->close();
            $stmtn = $conn->prepare($INSERT);
            $stmtn ->bind_param("ssssss", $nombre,$password, $email, $telefono, $genero, $estado);
            $stmtn ->execute();

            echo "REGISTRO COMPLETADO.";
        }
        else {
                echo "El numero o nombre ya se encuentra registrado.";            
        }
        $stmt->close();
        $conn->close();
    }
}
else{
    echo "Todos los datos son obligatorios";
    die(); 
}
?>