<?php
  include 'assets/rotinas/connect.php';
  session_start();
 ?>
<!DOCTYPE html>
<html lang="pt_br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="assets/css/cadlog.css">
  <script src="https://kit.fontawesome.com/dc02bb76bd.js"></script>
  <link rel="shortcut icon" href="assets/images/icone.png" type="image/x-png"/>
  <!-- Script para redirecionamente automático -->
  <script type="text/javascript">
      function sucesso(){
        setTimeout("window.location='Login.php'", 2000);
      }
    </script>
  <title>Lolipop</title>
  <style media="screen">
    .erro{
      position: absolute;
      top: 3%;
      left: 50%;
      transform: translate(-50%);
      border: 1.5px solid red;
      background: rgba(255,0,0,0.4);
      width: 320px;
      height: 40px;
	  align-items: center;
    }
    .erro .email{
      text-align: center;
      color: white;
      font-size: 14px;
      padding: 8px;
    }

    .erro .campos{
      font-size: 14px;
      text-align: center;
      color: white;
    }

    .success{
      position: absolute;
      top: 3%;
      left: 50%;
      transform: translate(-50%);
      border: 1.5px solid green;
      background: rgba(0,255,0,0.4);
    }

    .success h2{
      color: white;
      padding: 10px 10px;
      font-size: 14px;
      text-align: center;
    }

    .success h2 a{
      color: white;
      text-decoration: none;
      transition: 0.6s;
    }

    .success h2 a:hover{
      color: blue;
    }

  </style>
</head>
<body>
<div class="fundo">
  <div class="caixalog">
      <img src="assets/images/avatar.png" class="avatar">
      <h1>Cadastrar conta</h1>
      <form method="post">
        <p>Usuário</p>
        <input type="text" name="user" placeholder="Max: 20 characters..." maxlength="20">
        <p> Email </p>
        <input type="email" name="email" placeholder="Email..." maxlength="50">
        <p>Senha</p>
        <input type="password" name="pass" placeholder="Max: 20 characters..." maxlength="20">
        <input type="submit"  value="Cadastrar">
         <a href="Login.php">Já é cadastrado? Clique aqui</a>
      </form>
  </div>
</div>

  <?php
  if(isset($_POST['user'])){
    $user = addslashes($_POST['user']);
    $email =addslashes($_POST['email']);
    $pass = addslashes($_POST['pass']);

    // Teste para ver se todos os campos foram preenchidos
    if(!empty($user) or !empty($email) or !empty($pass)){
        // Se sim, checar se o email já está cadastrado
        $sql = mysqli_query($conn,"SELECT id_usu FROM usuario WHERE email_usu = '$email'  ");
        $linhas = mysqli_num_rows($sql);
        if ($linhas > 0 ){
          // Se sim, exibir a mensagem a seguir
          echo "<div class='erro'><h2 class='email'>Email já cadastrado!!</h2></div>";
          $_SESSION['email'] = "";
        } else {
          // Se não, cadastrar usuário
          $passcripty = md5($pass);
          mysqli_query($conn, "INSERT INTO usuario (nome_usu, email_usu, password_usu, tipo_usu)
          VALUES ('$user', '$email', '$passcripty', 2)") or die (mysqli_error($conn));

          echo "<div class='success'><h2 >Você foi cadastrado com sucesso!! Você deverá logar para acessar sua area privada";
          echo "<script type='text/javascript'>sucesso()</script>";
        }

    } else {
      // Se não exibir a mensagem a seguir
      $_SESSION['email'] = "";
      echo "<div class='erro'><h2 class='campos'>Voce deve preencher todos os campos!!!</h2></div>";
    }
  }
   ?>
</body>
</html>
