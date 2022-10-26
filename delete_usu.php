<?php

    include 'assets/rotinas/connect.php';

    $idUsu = $_GET['usuario'];

    $sql_receita = "SELECT * from receitas where id_usu = $idUsu";

    $query_receita = mysqli_query($conn, $sql_receita) or die (mysqli_error($conn));

    $row_count_receita = mysqli_num_rows($query_receita);

    if($row_count_receita > 0 ){

      while($resultReceita  = mysqli_fetch_assoc($query_receita)){
      $idReceita = $resultReceita['id_receita'];
      $sql_itensreceita = "SELECT ing_codigo FROM itensreceita WHERE id_receita = $idReceita ";
      $query_itens = mysqli_query($conn, $sql_itensreceita) or die (mysqli_error($conn));

      while($row_itens = mysqli_fetch_assoc($query_itens)){
        $sql_delete_i = "DELETE FROM itensreceita WHERE ing_codigo = $row_itens[ing_codigo] AND id_receita = $idReceita";
        $query_delete_i = mysqli_query($conn, $sql_delete_i) or die (mysqli_error($conn));
      }

      $sql_delete_r = "DELETE FROM receitas WHERE id_receita = $idReceita AND id_usu = $idUsu";
      $query_delete_r = mysqli_query($conn, $sql_delete_r) or die (mysqli_error($conn));

      $sql_delete = "DELETE FROM usuario WHERE id_usu = $idUsu";
      $query_delete = mysqli_query($conn, $sql_delete) or die (mysqli_error($conn));

      if($query_delete){
        echo "<script>
                alert('Usuário deletado com sucesso');
                location.href='pagina_adm.php';
              </script>";
      } else {
        echo "<script>
                alert('Não foi possível deletar o usuário');
                location.href='pagina_adm.php';
              </script>";
      }
     }
    } else {
      $sql_delete = "DELETE FROM usuario WHERE id_usu = $idUsu";
      $query_delete = mysqli_query($conn, $sql_delete) or die (mysqli_error($conn));

      if($query_delete){
        echo "<script>
                alert('Usuário deletado com sucesso');
                location.href='pagina_adm.php';
              </script>";
      } else {
        echo "<script>
                alert('Não foi possível deletar o usuário');
                location.href='pagina_adm.php';
              </script>";
      }
    }
 ?>
