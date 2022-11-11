<?php

  session_start();

  if (isset($_SESSION['user_id'])) {
    header('Location: /formulariophp');
  }
  require 'database.php';

  if (!empty($_POST['email']) && !empty($_POST['password'])) { 
    $email= $_POST['email'];
    $records = $conn->prepare("SELECT id_usuario, email, contraseña FROM datos WHERE email = ?");
    echo "Hi";
    $records->bindParam('email', $email);
    echo "Hi";
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
   
    $message = '';

    if (count($results) > 0 && password_verify($_POST['password'], $results['contraseña'])) {
      $_SESSION['user_id'] = $results['id_usuario'];
      header("Location: /formulariophp");
    } else {
      $message = 'Sorry, those credentials do not match';
    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <title>Login </title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style-login.css">
  </head>
  <body>
    <?php require 'header.php' ?>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <div class="main">
      <p class="sign" align="center"><a class="linked" href="index.php">Login</a></p>
        <div class="input-group">
          <form action="login.php" method="POST">
            <div class="input-box">
                  <label>Email</label>
                  <input type="email" placeholder="ejemplo@email.com" name="email" required>
              </div>
              <div class="input-box">
                  <label>Contraseña</label>
                  <input type="password" placeholder="*******" name="password" required>
              </div>
              <input type="submit" value="Submit" class="submit">
              <p class="forgot" align="center"><a href="formulario/signupform.html">¿Requiere registrarse?</p>
          </form>
        </div>
    </div>
  </body>
</html>
