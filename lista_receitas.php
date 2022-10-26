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
         <?php } else { ?>
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
   <div class="scroll">


        <table class="content-table">
          <thead>
            <tr>
              <th></th>
              <th>Receitas</th>
              <th>Categoria</th>
            </tr>
          </thead>
          <tbody>
            <?php
                if (isset($_GET['id'])) {


               $idCat = $_GET['id'];

               $sql_lista = "SELECT R.id_cat, id_receita, nome_receita, nome_cat from receitas R, categoria C where R.id_cat = C.id_cat and R.id_cat = $idCat order by nome_receita";

               $query_lista  = mysqli_query($conn, $sql_lista) or die (mysqli_error($conn));

               $contador = 1;

               while($row_lista = mysqli_fetch_assoc($query_lista)){ ?>
            <tr>
              <td><?php echo $contador ?></td>
              <td><a href="receitas.php?id=<?php echo $row_lista['id_receita']?>"><?php echo utf8_encode($row_lista['nome_receita'])?></a></td>
              <td><a href="lista_receitas.php?id=<?php echo $row_lista['id_cat'] ?>"><?php echo utf8_encode($row_lista['nome_cat']) ?></a></td>
            </tr>
            <?php $contador++;}}else {?>
          <?php
                  if(isset($_POST['search'])){
                    $pesq = addslashes($_POST['search']);
                    $contador = 1;
                    $sql = $conn->prepare("SELECT distinct C.id_cat, nome_cat, nome_receita, id_receita from receitas R, categoria C where R.id_cat = C.id_cat and (nome_cat like '%$pesq%' or nome_receita like '%$pesq%') order by nome_receita");
                    $sql->execute();
                    $resultado = $sql->get_result();
                    $conta = $resultado->num_rows;
                    if($conta > 0 ){
                      while($dados = $resultado->fetch_assoc()){
                        ?>
                        <tr>


                        <td><?php echo $contador; ?></td>
                        <td><a href="receitas.php?id=<?php echo $dados['id_receita']; ?>"><?php echo utf8_encode($dados['nome_receita']); ?></td>
                        <td><a href="lista_receitas.php?id=<?php echo $dados['id_cat']; ?>"><?php echo utf8_encode($dados['nome_cat']); ?></a></td>
                          </tr>
                        <?php
                      $contador++;
                    }
                    }
                    }else{
              echo "<script>alert('Não foi possivel acessar essa pagina');</script>";
            }

          } ?>
          </tbody>
        </table>

   </div>
 </section>
 <script src="assets/js/scripts.js">
 </script>
 </body>
 </html>
