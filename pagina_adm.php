<?php
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
            <?php if(isset($_SESSION['id_usu'])){

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
              <?php if($result['tipo_usu'] == 1){
                echo "<a href='pagina_adm.php'>ADM</a>";
              }
              ?>
              <?php
            } ?>
          </li>
        <?php } ?>
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
  <div class="scroll">


       <table class="content-table" >
         <thead>
           <tr>
             <th>Usuário</th>
             <th>Receitas</th>
             <th>Categoria</th>
             <th>Controle</th>
           </tr>
         </thead>
         <tbody>
           <?php

              $sql_lista = "SELECT id_receita, nome_usu, nome_receita, C.id_cat, nome_cat from receitas R, usuario U, categoria C where R.id_usu = U.id_usu
              and C.id_cat = R.id_cat order by nome_cat";

              $query_lista  = mysqli_query($conn, $sql_lista) or die (mysqli_error($conn));


              while($row_lista = mysqli_fetch_assoc($query_lista)){ ?>
           <tr>
             <td><?php echo $row_lista['nome_usu']; ?></td>
             <td><a href="receitas.php?id=<?php echo $row_lista['id_receita']?>"><?php echo utf8_encode($row_lista['nome_receita'])?></a></td>
             <td><a href="lista_receitas.php?id=<?php echo $row_lista['id_cat']?>"><?php echo utf8_encode($row_lista['nome_cat'])?></a></td>
             <td><a href="javascript: if(confirm('Tem certeza que deseja deletar essa receita ?'))
               location.href='delete_receita.php?receita=<?php echo $row_lista['id_receita']; ?>';"class="delete">Deletar</a></td>
           </tr>
           <?php } ?>
         </tbody>

       </table><br>
       <table class="content-table">
         <thead>
           <tr>
             <th>Id do usuário</th>
             <th>Nome do usuário</th>
             <th>Tipo do usário</th>
             <th>Controle</th>
           </tr>
         </thead>
         <tbody>
           <?php

              $sql_usu = "SELECT id_usu, nome_usu, nivel_tpusu from usuario U, tipousuario TU where u.tipo_usu = tu.cod_tpusu order by nivel_tpusu";

              $query_usu  = mysqli_query($conn, $sql_usu) or die (mysqli_error($conn));


              while($row_usu = mysqli_fetch_assoc($query_usu)){ ?>
           <tr>
             <td><?php echo $row_usu['id_usu']; ?></td>
             <td><p><?php echo $row_usu['nome_usu']?></p></td>
             <td><p><?php echo $row_usu['nivel_tpusu']; ?></p></td>
             <td><a href="editar.php?usuario=<?php echo $row_usu['id_usu']?>" class="edit">Editar</a>/
               <a href="javascript: if(confirm('Tem certeza que deseja deletar o usuário <?php echo $row_usu['nome_usu']; ?>?'))
         			location.href='delete_usu.php?usuario=<?php echo $row_usu['id_usu']; ?>';" style="text-decoration:none;">Deletar</a>
             </td>
           </tr>
           <?php } ?>
         </tbody>
       </table>

  </div>
  <div class="sc">
    <form   method="post">
      <div class="form-group mb-2">
        <label  style="color: white;">Adicionar ingrediente</label><br>
        <input type="text" class="form-control"name="ingrediente">
        <button type="submit" class="btn btn-primary mb-2" style="margin-top: 20px;">Enviar ingrediente</button>
      </div>
    </form>
    <form  method="post" style="min-width: 350px;">
      <div class="form-group mb-2">
        <label  style="color: white;">Adicionar Categoria</label><br>
        <input type="text" class="form-control" name="categoria">
        <button type="submit" class="btn btn-primary mb-2" style="margin-top: 20px;">Enviar categoria</button>
      </div>
    </form>
  </div>
</section>

<?php
  if (isset($_POST['ingrediente'])) {
      $ing = addslashes($_POST['ingrediente']);
        $sql = "SELECT * FROM ingrediente WHERE ing_descricao = '$ing'";
        $query = mysqli_query($conn, $sql) or die (mysqli_error($conn));
        $num = mysqli_num_rows($query);

    if ($num == 0) {


    $sql = "INSERT into ingrediente (ing_descricao) values('$ing')";
    $query = mysqli_query($conn, $sql) or die (mysqli_error($conn));

    if ($query) {
      echo "<script>
            alert('Ingrediente cadastrado com sucesso');
      </script>";
    } else {
      echo "<script>
            alert('Ingrediente não pode ser cadastrado');
      </script>";;
    }
  } else {
    echo "<script>
          alert('Ingrediente já está cadastrado');
    </script>";;
  }
}

if (isset($_POST['categoria'])) {
    $cat = addslashes($_POST['categoria']);
      $sql = "SELECT * FROM categoria WHERE nome_cat = '$cat'";
      $query = mysqli_query($conn, $sql) or die (mysqli_error($conn));
      $num = mysqli_num_rows($query);


  if ($num == 0) {


    $sql = "INSERT into categoria (nome_cat) values('$cat')";
    $query = mysqli_query($conn, $sql) or die (mysqli_error($conn));
    if ($query) {
      echo "<script>
            alert('Categoria adicionada com sucesso');
            location.href='pagina_adm.php';
      </script>";
    } else {
      echo "<script>
            alert('Categoria não pode ser adicionada');
            location.href='pagina_adm.php';
      </script>";;
    }
  } else {
    echo "<script>
          alert('Categoria já existe');
          location.href='pagina_adm.php';
    </script>";;
  }
}

 ?>
<script src="assets/js/scripts.js">
</script>
</body>
</html>
