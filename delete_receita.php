<?php
  include 'assets/rotinas/connect.php';
  $idReceita = intval($_GET['receita']);

  // Consulta pra saber o id do usuario publicador da receita
  $sql_usu = "SELECT id_usu FROM receitas WHERE id_receita = $idReceita";
  $query_usu = mysqli_query($conn, $sql_usu) or die (mysqli_error($conn));
  $result_usu = mysqli_fetch_assoc($query_usu);

  $idUsu = $result_usu['id_usu'];


  //Consulta para saber os registros relacionados a receita
  $sql_itens = "SELECT ing_codigo FROM itensreceita WHERE id_receita = $idReceita";
  $query_itens = mysqli_query($conn, $sql_itens) or die (mysqli_error($conn));

  while($row_itens = mysqli_fetch_assoc($query_itens)){
    //Deletando os registros relacionados a receita
   $sql_delete_i = "DELETE FROM itensreceita WHERE ing_codigo = $row_itens[ing_codigo] AND id_receita = $idReceita";
   $query_delete_i = mysqli_query($conn, $sql_delete_i) or die (mysqli_error($conn));
  }
    // Deletando a receita
   $sql_delete_r = "DELETE FROM receitas WHERE id_receita = $idReceita AND id_usu = $idUsu";
   $query_delete_r = mysqli_query($conn, $sql_delete_r) or die (mysqli_error($conn));

   if($query_delete_r){
     echo "<script>
             alert('Receita deletada com sucesso');
             location.href='pagina_adm.php';
           </script>";
   } else {
     echo "<script>
             alert('Não foi possível deletar a receita');
             location.href='pagina_adm.php';
           </script>";
   }
 ?>
