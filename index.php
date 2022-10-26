<?php
  // Incluindo rotina de conexão
  include 'assets/rotinas/connect.php';
  session_start();


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lolipop Receitas</title>
    <script src="https://kit.fontawesome.com/dc02bb76bd.js"></script>
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
    <link href="assets/css/PStyle.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/images/icone.png" type="image/x-png"/>
</head>
<body>
<!--Marcação da navbar começa aqui-->
  <header>
    <div class="cont">
      <nav>
        <div class="menu-icons">
          <i class="icon ion-md-menu"></i>
          <i class="icon ion-md-close"></i>
        </div>
        <a href="index.php" class="logo">
          <i class="icon ion-md-restaurant"></i>
        </a>
        <ul class="nav-list">
          <li>
              <a href="#">Home</a>
          </li>
          <li>
              <a href="#">Categorias
                <i class="icon ion-md-arrow-dropdown"></i>
              </a>
              <ul class="sub-menu">
                <li>
                  <?php
                  $sql = "SELECT * FROM categoria order by nome_cat";

                  $query  = mysqli_query($conn, $sql) or die (mysqli_error($conn));

                  while($row_categoria = mysqli_fetch_assoc($query)){ ?>
                  <a href="lista_receitas.php?id=<?php echo $row_categoria['id_cat'];?>"><?php echo utf8_encode($row_categoria['nome_cat']);?></a><?php } ?>
                </li>
              </ul>
          </li>
          <li>
            <?php
            // Verificando se a varivael $_SESSION['id_usu'] existe
            if(isset($_SESSION['id_usu'])){
              // Se sim executar os comandos abaixo
            $idUsu = $_SESSION['id_usu'];

            $sql = "SELECT nome_usu, tipo_usu FROM usuario WHERE id_usu = '$idUsu'";
            $query = mysqli_query($conn,$sql);
            while($result = mysqli_fetch_assoc($query)){ ?>
              <a href="#"><?php
                  echo $result['nome_usu'];?>
              <i class="icon ion-md-arrow-dropdown"></i>
              </a>
              <ul class="sub-menu">
                <li>
                  <a href="publicar.php">Publicar</a>
                </li>
                <li>
                  <a href="logout.php">Sair</a>
                </li>
              </ul>
          </li>

          <li>
              <?php
                // Verificando se o usuário logado tem permissão de administrador
              if($result['tipo_usu'] == 1){
                echo "<a href='pagina_adm.php'>ADM</a>";
              }
              ?>
              <?php  } ?>
          </li>
        <?php } else { // Se não executar os comandos abaixo ?>

        <a href="cadastro.php">Cadastrar</a> <?php } ?>
          <li class="move-right">
          <form action="lista_receitas.php" method="post">
                <input class="pesquisa" type="text" name="search" placeholder="Pesquisar">
              </form>
          </li>
        </ul>
      </nav>
    </div>
  </header>
<!--Fim nav-->

<!--Hero-->
<section class="hero">
  <div class="text">
      <h2>Aprenda fácil</h2>
      <h1>Lolipop Receitas</h1>
      <p>Um site para você aprender receitas deliciosas!!</p>
      <div class="s-m">
        <a href="https://www.facebook.com/receitaslolipop.ofc/" target="_blank"><i class=" fab fa-facebook-f"></i></a>
        <a href="https://twitter.com/LolipopReceitas " target="_blank"><i class=" fab fa-twitter"></i></a>
        <a href="https://www.instagram.com/receitaslolipop_ofc/" target="_blank"><i class=" fab fa-instagram"></i></a>
      </div>
  </div>
</section>
<script src="assets/js/scripts.js">
</script>
</body>
</html>
