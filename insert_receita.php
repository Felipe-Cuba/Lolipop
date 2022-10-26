<?php
include 'assets/rotinas/connect.php';
 session_start();

 $idUsu = $_SESSION['id_usu'];

if(isset($_POST['title'])){
  $title = addslashes($_POST['title']);
  $preparo = addslashes($_POST['preparo']);
  $categoria = addslashes($_POST['categoria']);
  $preparo = utf8_decode($preparo);
  $categoria = utf8_decode($categoria);
  $title  = utf8_decode($title);
  $sql_1 = "INSERT into receitas (nome_receita, conteudo_receita, id_usu, id_cat) VALUES ('$title', '$preparo', $idUsu, $categoria);";

  $query_1 = mysqli_query($conn, $sql_1) or die (mysqli_error($conn));

  $sql_2 = "SELECT id_receita from receitas where conteudo_receita = '$preparo'";

  $query_2 = mysqli_query($conn, $sql_2) or die (mysqli_error($conn));

  $row_receita = mysqli_fetch_assoc($query_2);


	$i = count($_POST['ing']);

	$contador = 0;

	while($contador < $i){
		$ing = addslashes($_POST['ing'][$contador]);
    $qtd = addslashes($_POST['qtd'][$contador]);
    $qtd = utf8_decode($qtd);
    $sql_3 = "INSERT INTO itensreceita (id_receita, ing_codigo, itr_quantidade) VALUES ($row_receita[id_receita], $ing, '$qtd') ";

    $query_3 = mysqli_query($conn, $sql_3) or die (mysqli_error($conn));

    if($query_3){
      echo "<script> alert('Receita cadastrada com sucesso');
					  location.href='publicar.php'
	  </script>";
    }
		$contador++;
	}




}

?>
