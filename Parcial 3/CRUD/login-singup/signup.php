<?php

  require 'database.php';

  $message = '';

  if(!empty($nombre) || !empty($password) || !empty($email) || !empty($telefono) || !empty($genero) || !empty($estado)){
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

            //echo "REGISTRO COMPLETADO.";
            $message = 'REGISTRO COMPLETADO.';
        }
        else {
                //echo "El numero o nombre ya se encuentra registrado."; 
                $message = 'El numero o nombre ya se encuentra registrado.';           
        }
        $stmt->close();
        $conn->close();
    }
    else{
        echo "Todos los datos son obligatorios";
        die(); 
    }
?>

<!-- 
    $sql = "INSERT INTO datos (usuario, contraseña, email, telefono, genero, entidad) values(?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam('email', $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->bindParam('password', $password);

    if ($stmt->execute()) {
      $message = 'Successfully created new user';
    } else {
      $message = 'Sorry there must have been an issue creating your account';
    }
  }
-->


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style copy.css">
  </head>
  <body>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <?php require 'header.php' // Para regresar al inicio.
    ?> 

    <!-- Aquí queda el formulario de registro de usuarios -->
    <div class="container">
        <div class="form-image">
            <img src="img/Desk.jpeg" alt="">
        </div>
        <div class="form">
            <form action="signup.php" method="POST">
                <div class="form-header">
                    <div class="title">
                        <h1>Registro de Usuario</h1>
                    </div>
                    <div class="login-button">
                        <button><a href="login.php">Login</a></button>
                    </div>
                </div>

                <div class="input-group">
                    <div class="input-box">
                        <label>Nombre</label>
                        <input type="text" placeholder="User" name="nombre" required>
                    </div>

                    <div class="input-box">
                        <label>Teléfono</label>
                        <input type="phone" placeholder="(xx) xxxx-xxxx"  name="telefono" required>
                    </div>
                  
                    <div class="input-box">
                        <label>E-mail</label>
                        <input type="email" placeholder="ejemplo@email.com" name="email" required>
                    </div>

                    <div class="input-box">
                        <label>Contraseña</label>
                        <input type="password" placeholder="*******" name="password" required>
                    </div>

                    <div class="entidad-input">
                        <div class="input-box">
                            <label>Entidad federativa</label>
                            <select class="selector" name="estado" required>
                                <option selected hidden value="">Entidad Federativa</option>
                                <option value="aguascalientes">Aguascalientes</option>
                                <option value="chihuahua">Chihuahua</option>
                                <option value="colima">Colima</option>
                                <option value="durango">Durango</option>
                                <option value="guadalajara">Guadalajara</option>
                                <option value="guanajuato">Guanajuato</option>
                                <option value="hidalgo">Hidalgo</option>
                                <option value="zacatecas">Zacatecas</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="gender-inputs">
                    <div class="gender-title">
                        <h6>Género</h6>
                    </div>

                    <div class="gender-group">
                        <div class="gender-input">
                            <input type="radio" name="genero" value="f" required>
                            <label>Feminino</label>
                        </div>

                        <div class="gender-input">
                            <input type="radio" name="genero" value="m" required>
                            <label>Masculino</label>
                        </div>

                        <div class="gender-input">
                            <input type="radio" name="genero" value="o" required>
                            <label>Otro</label>
                        </div>
                    </div>
                </div>

                <div class="continue-button">
                    <input type="submit" value="Submit" name="enviar">
                </div>
            </form>
        </div>
    </div><!--Fin container-->

  </body>
</html>
