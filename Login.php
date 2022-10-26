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
  <!-- Script para redirecionamento automático -->
  <script type="text/javascript">
      function sucesso(){
        setTimeout("window.location='index.php'", 2000);
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
    height: 60px;
  }
  .erro h2{
    text-align: center;
    color: white;
    font-size: 16px;
    padding: 8px;
  }

  .container{
    position: absolute;
    top: 3%;
    left: 50%;
    transform: translate(-50%);
    text-align: center;
    width: 30%;
    border: 1.5px solid rgba(0,255,0,1);
    background: rgba(0,255,0, 0.6);
  }
  .container h2{
    color: white;
    font-size: 14px;;
  }

  </style>
</head>
<body>
  <div class="fundo">


  <div class="caixalog">
      <img src="assets/images/avatar.png" class="avatar">
      <h1>Entrar na conta</h1>
      <form method="post" target="_self">
        <p>Email</p>
        <input type="email" name="user" placeholder="Entre com o usuário" maxlength="50">
        <p>Senha</p>
        <input type="password" name="pass" placeholder="Entre com a senha" maxlength="20">
        <input type="submit" name="" value="Entrar">
        <a href="#">Esqueceu a senha?</a><br>
        <a href="cadastro.php">Não é cadastrado? Clique aqui</a>
      </form>
  </div>
    </div>

  <?php
      if(isset($_POST['user'])){
        $user = addslashes($_POST['user']);
        $pass = addslashes($_POST['pass']);
        $passcripty = md5($pass);
        // Teste para ver se todos os campos foram preenchidos
        if (!empty($user) or !empty($pass)){
            // Se sim verificar se o usuário esta cadastrado utilizando os parametros passados
            $sql_login = "SELECT id_usu FROM usuario WHERE email_usu = '$user' AND password_usu = '$passcripty'";
            $query = mysqli_query($conn,$sql_login) or die (mysqli_error($conn));
            // Contador para checar se existem linhas existentes a partir da consulta acima
            $linhas = mysqli_num_rows($query);

            if($linhas == 0 ){
              // Se forem 0 linhas exiba a mensagem abaixo
              echo "<div class='erro'><h2>Suas credenciais não batem</h2></div>";
            } else {
              // Se for maior que 0, execute o codigo abaixo e exiba  mensagem a seguir
              while($result = mysqli_fetch_assoc($query)){
                $id_user = $result['id_usu'];
                $_SESSION['id_usu'] = $id_user;

                echo "<div class='container'><h2>Você foi autenticado com sucesso!! Será redirecionado em 3 segundos</h2></div>";
                echo "<script type='text/javascript'>sucesso()</script>";
              }
            }

        } else {
          // Se não exibir a mensagem a seguir
          echo "<div class='erro'><h2>Preencha todos os campos!!</h2></div>";
        }
      }
   ?>
</body>
</html>
