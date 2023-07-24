<?php
require_once('assets/database/conn.php');
$query = "SELECT * FROM log_desafio";
$result = mysqli_query($conexao, $query); 

if(@$_GET['apagar_log'] == "y"){
  $query_apagar = "DELETE FROM log_desafio";
  mysqli_query($conexao, $query_apagar); 
  header('Location: log.php');
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Desafio</title>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div id="container">
    <h1>Histórico de Registros</h1>
	<a href="index.php"><button type="button" class="btn btn-info">Voltar</button></a>
  <a href="log.php?apagar_log=y"><button type="submit" class="btn btn-danger">Apagar LOG</button></a>
    <table id="example" class="display" style="width:100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>Alteração</th>
          <th>De</th>
          <th>Para</th>
          <th>Data de Registro</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $i = 0; 
          while($array = $result->fetch_assoc()){ 
        ?>
        <tr>
          <td><?php echo $array['id_registro'] ?></td>
          <td><?php echo $array['alteracao'] ?></td>
          <td><?php echo $array['de'] ?></td>
		  <td><?php echo $array['para'] ?></td>
          <td><?php echo date("d/m/Y H:i", strtotime($array['dt_registro'])) ?></td>
        </tr>
        <?php $i++; } ?>
      </tbody>
    </table>
  </div>

  <script type="text/javascript">$("#salarioIncluir").maskMoney();$("#salarioAlterar").maskMoney();</script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/scripts.js"></script>  
</body>
</html>
