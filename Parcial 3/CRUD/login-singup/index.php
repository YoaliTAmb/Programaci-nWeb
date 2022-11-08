<?php
  session_start();

  require 'database.php';

  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id_usuario, usuario, contraseña, email, telefono, genero, entidad  FROM datos WHERE id_usuario = user_id');
    $records->bindParam('id_usuario', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
      $user = $results;
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Inicio CRUD</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

    <style type="text/css">
      body{
        
        background: #425a4a;
      }
      .form-header {
        margin-bottom: 1rem;
        display: flex;
        justify-content: center;
      }
      .form-header h1{
        color: white;
      }

      .form-header h1::after {
        content: '';
        display: block;
        width: 7rem;
        height: 0.3rem;
        background-color: black;
        margin: 0 auto;
        position: absolute;
        border-radius: 10px;
      }
      .form-image img{
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.212);
        margin-bottom: 20px;
      }
      .botones-inicio{
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        background-color: rgb(225, 225, 225);
        border-radius: 3px;
      }
      .botones-inicio a{
        text-decoration: none;
        width: 60%;
        margin-top: 2.5rem;
        border: none;
        background-color: black;
        padding: 0.62rem;
        border-radius: 5px;
        cursor: pointer;
        color: #fff;
        font-size: 0.93rem;
        font-weight: 500;
        margin: 1rem;
      }
      .botones-inicio a:hover {
        background-color: rgb(225, 225, 225);
        color: black;
      }
    </style>

  </head>
  <body>
    <?php require 'header.php' ?>

    <?php if(!empty($user)): ?>
      <br> Welcome. <?= $user['email']; ?>
      <br>You are Successfully Logged In
      <a href="logout.php">
        Logout
      </a>
    <?php else: ?>
      <div class="form-header">
        <div class="title">
          <h1>Bienvenido al sistema</h1>
        </div>
      </div>
      <div class="form-image">
            <img src="img/Inicio.jpg" alt="" width=60%>
        </div>

      <div class="botones-inicio">
        <a href="login.php">Login</a>
        <a href="signup.php">SignUp</a>
      </div>
    <?php endif; ?>
  </body>
</html>
