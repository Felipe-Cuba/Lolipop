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
  <title>Document</title>
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
              <a href="index.php">Home</a>
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
  <div class="receita">
    <?php
      $idReceita = intval($_GET['id']);

      $sql_receita = "SELECT nome_usu, nome_receita, conteudo_receita from   receitas R,   usuario U
      where R.id_usu = U.id_usu
      and R.id_receita = $idReceita";
      $query_receita = mysqli_query($conn, $sql_receita) or die (mysqli_error($conn));

      $sql_ingrediente = "SELECT ing_descricao, itr_quantidade from ingrediente I, itensreceita IR, receitas R
      where R.id_receita = IR.id_receita
      and ir.ing_codigo = i.ing_codigo
      and R.id_receita = $idReceita ";

      $query_ingrediente = mysqli_query($conn,$sql_ingrediente) or die (mysqli_fetch_assoc($conn));
     ?>
     <div class="top">

       <?php
        while($row_receita = mysqli_fetch_assoc($query_receita)){
        ?>
     <h1><?php echo utf8_encode($row_receita['nome_receita']) ?></h1>
     <h2><?php echo utf8_encode($row_receita['nome_usu']); ?></h3>
     </div>
     <hr>
     <div class="ingrediente">
       <?php while ($row_ingrediente = mysqli_fetch_assoc($query_ingrediente)) {  ?>
         <p><?php echo utf8_encode($row_ingrediente['ing_descricao'])." - ".utf8_encode($row_ingrediente['itr_quantidade'])."\n" ?></p>
      <?php } ?>
     </div>
     <hr>
     <div class="bot">
     <h3>Modo de preparo</h3>
     <p><?php echo utf8_encode($row_receita['conteudo_receita']); ?></p>
    <?php } ?>
     </div>
  </div>
</section>
<script src="assets/js/scripts.js">
</script>
</body>
</html>
