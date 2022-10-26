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
  <script type="text/javascript">
      function sucesso(){
        setTimeout("window.location='Login.php'", 2000);
      }
    </script>
  <title>Lolipop</title>
  <style media="screen">
    .erro{
      position: absolute;
      top: 85%;
      left: 50%;
      transform: translate(-50%);
      border: 1.5px solid red;
      background: rgba(255,0,0,0.4);
      width: 320px;
      height: 60px;
    }
    .erro .email{
      text-align: center;
      color: white;
      font-size: 16px;
      padding: 8px;
    }

    .erro .campos{
      font-size: 18px;
      text-align: center;
      color: white;
    }

    .success{
      position: absolute;
      top: 85%;
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

  <?php
  if($_GET['usuario']){
    $idUsu = intval($_GET['usuario']);
    $sql = "SELECT * from usuario where id_usu = $idUsu";

    $query = mysqli_query($conn, $sql) or die (mysqli_error($conn));

    $row = mysqli_fetch_assoc($query);

    $_SESSION['user'] = $row['nome_usu'];
    $_SESSION['email'] = $row['email_usu'];
    $_SESSION['senha'] = $row['password_usu'];
    $_SESSION['nivel'] = $row['tipo_usu'];
   ?>
   <div class="fundo">


  <div class="caixalog">
      <img src="assets/images/avatar.png" class="avatar">
      <h1>Editar usuário</h1>
      <form method="post">
        <p>Usuário</p>
        <input type="text" name="user" placeholder="Max: 20 characters..." maxlength="20" value="<?php echo $_SESSION['user']?>">
        <p> Email </p>
        <input type="email" name="email" placeholder="Email..." maxlength="50" value="<?php echo $_SESSION['email']?>">
        <p>Senha</p>
        <input type="password" name="pass" placeholder="Max: 20 characters..." maxlength="20">
        <p>Nível</p>
        <select style="color: white;" name="nivel" >
            <option style = "color: black;" value="">Selecione</option>
            <option style = "color: black;" value="1"<?php if($_SESSION['nivel'] == 1){echo "selected";} ?>>ADMIN</option>
            <option style = "color: black;" value="2"<?php if($_SESSION['nivel'] == 2){echo "selected";} ?>>COMUM</option>
        </select><br>
        <input type="submit"  value="Alterar">
         <a href="pagina_adm.php" style="font-size: 15px;">Voltar</a>
      </form>
  </div>
  </div>
  <?php
  if(isset($_POST['user'])){
    if(!empty($_POST['pass'])){
    $_SESSION['user'] = $_POST['user'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['senha'] = md5($_POST['pass']);
    $_SESSION['nivel'] = $_POST['nivel'];

    $sql_update = "UPDATE usuario SET
    nome_usu = '$_SESSION[user]',
    email_usu = '$_SESSION[email]',
    password_usu = '$_SESSION[senha]',
    tipo_usu = '$_SESSION[nivel]'
    where id_usu = $idUsu";

    $update = mysqli_query($conn, $sql_update) or die (mysqli_error($conn));
    }
    else {
      $_SESSION['user'] = $_POST['user'];
      $_SESSION['email'] = $_POST['email'];
      $_SESSION['nivel'] = $_POST['nivel'];

      $sql_update = "UPDATE usuario SET
      nome_usu = '$_SESSION[user]',
      email_usu = '$_SESSION[email]',
      password_usu = '$_SESSION[senha]',
      tipo_usu = '$_SESSION[nivel]'
      where id_usu = $idUsu";

      $update = mysqli_query($conn, $sql_update) or die (mysqli_error($conn));

      if($update){
        echo "<script>
                alert('Alteração feita com sucesso');
                location.href='pagina_adm.php';
              </script>";
      } else {
        echo "<script>
                alert('Não foi possível completar a alteração');
                location.href='pagina_adm.php';
              </script>";
      }
    }
  }
}
   ?>
</body>
</html>
