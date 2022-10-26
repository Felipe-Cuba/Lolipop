<?php
  include 'assets/rotinas/connect.php';
  session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lolipop Receitas</title>
    <!-- Links externos -->
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="assets/js/repeater.js" type="text/javascript"></script>
    <!-- Link interno -->
    <link href="assets/css/PStyle.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/images/icone.png" type="image/x-png"/>
</head>
<body>

<!-- <body style="background: #191919;"> -->

<!-- NavBar principal -->

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
<!-- Fim NavBar -->

<!-- Formulário -->
  <section class="hero">

    <div class="container" style=" ">
        <br />
        <h3 align="center"></h3>
        <br />
        <div style="width:100%; max-width: 600px; margin:0 auto;background: black; margin-top: 40px; ">
            <div class="panel panel-default">
                <div class="panel-heading">Preencha os campos para publicar sua receita</div>
                <div class="panel-body">
                    <span id="success_result"></span>
                    <form method="post" id="repeater_form" style="overflow: scroll; overflow-x: hidden; height:650px; ">
                        <div class="form-group">
                            <label>Título da receita</label>
                            <input type="text" name="title" id="name" class="form-control" required />
                        </div>
                        <div id="repeater">
                            <div class="repeater-heading" align="right">
                                <button type="button" class="btn btn-primary repeater-add-btn">Adicionar ingrediente</button>
                            </div>
                            <div class="clearfix"></div>
                            <div class="items" data-group="programming_languages">
                                <div class="item-content">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <label>Selecione os ingredietes da receita</label>
                                                <select data-skip-name="true" data-name="ing[]" class="form-control" required>
                                                  <?php
                                                    $result_ing = "select * from ingrediente order by ing_descricao";
                                                    $resultado_ing = mysqli_query($conn, $result_ing);
                                                    while($row_ingrediente = mysqli_fetch_assoc($resultado_ing)){?>
                                                    <option value="<?php echo $row_ingrediente['ing_codigo'];?>"><?php echo utf8_encode($row_ingrediente['ing_descricao']);?></option><?php } ?>


                                                </select><br>
                                                <label>Digite a quantidade desses ingredientes</label>
                                                <input type="text" data-skip-name="true" data-name="qtd[]" class="form-control" required>
                                            </div>
                                            <div class="col-md-3" style="margin-top:24px;" align="center">
                                                <button id="remove-btn" onclick="$(this).parents('.items').remove()" class="btn btn-danger">Remover</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label> Selecione a categoria de sua receita </label>
                        <select name="categoria" required class="form-control">
                        <?php
                         $result_cat = "SELECT * from categoria";
                         $resultado_cat = mysqli_query($conn, $result_cat);
                         while($row_categoria = mysqli_fetch_assoc($resultado_cat)){?>
                        <option value="<?php echo $row_categoria['id_cat'];?>"><?php echo utf8_encode($row_categoria['nome_cat']);?></option><?php } ?>
                      </select><br>
                        <label>Modo de preparo da receita</label>
                        <textarea name="preparo" rows="8" cols="80" class="form-control" required></textarea>
                        <div class="clearfix"></div>
                        <div class="form-group" align="center">
                            <br /><br />
                            <input type="submit" name="insert" class="btn btn-success" value="Publicar" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

  </section>

<!-- Fim formulário -->

<?php

?>

<!-- Script para adicionar inputs -->

<script>
$(document).ready(function(){

    $('#repeater').createRepeater();

    $('#repeater_form').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url:"insert_receita.php",
            method:"POST",
            data:$(this).serialize(),
            success:function(data)
            {
                $('#repeater_form')[0].reset();
                $('#repeater').createRepeater();
                $('#success_result').html(data);
            }
        })
    });

});

</script>

<!-- Fim script -->
  <script src="assets/js/scripts.js">
</script>
</body>

<!-- https://www.youtube.com/watch?v=83MrpW67iRU autocomplete textbox-->

</html>
