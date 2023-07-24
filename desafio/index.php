<?php
require_once('assets/database/conn.php');
$query = "SELECT * FROM desafio";
$result = mysqli_query($conexao, $query); 

$query = new MongoDB\Driver\Query([]);
$cursor = $conn->executeQuery("$database.$collection", $query);

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
  <h1>Tabela de Registros</h1>
	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalIncluir">Inserir Registro</button>
  <a href="log.php"><button type="button" class="btn btn-info">Histórico de Alterações</button></a>
    <table id="example" class="display" style="width:100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Data de Nascimento</th>
          <th>Salário</th>
          <th>Ferramentas</th>          
        </tr>
      </thead>
      <tbody>
        <?php 
          $i = 0; 
          foreach ($cursor as $objeto) {
        ?>
        <tr>
          <td><?php echo $objeto->_id; ?></td>
          <td><?php echo $objeto->nome; ?></td>
          <td><?php echo date("d/m/Y", strtotime($objeto->data_nascimento)); ?></td>
		      <td><?php echo "R$ " . $objeto->salario; ?></td>
		  <td>
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalAlterar<?php echo $i ?>">Alterar</button>		
			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalExcluir<?php echo $i ?>">Excluir</button>		
		  </td>
        </tr>

<!-- Modal "Alterar Registro" -->
<div class="modal fade" id="ModalAlterar<?php echo $i ?>" aria-labelledby="modalTituloAlterar<?php echo $i ?>">
  <div class="modal-dialog" id="modalTituloAlterar<?php echo $i ?>">
    <div class="modal-content">
      <!-- Cabeçalho do Modal -->
      <div class="modal-header">
        <h4 class="modal-title">Alterar Registro</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Corpo do Modal -->
      <div class="modal-body">
        <!-- Formulário com os 3 campos -->
        <form action="assets/database/alterar.php" method="POST">
          <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $objeto->nome ?>">
          </div>
          <div class="form-group">
            <label for="email">Data de Nascimento:</label>
            <input type="date" class="form-control" id="dt_nascimento" name="dt_nascimento" value="<?php echo $objeto->data_nascimento ?>">
          </div>
          <div class="form-group">
            <label for="mensagem">Salário:</label>
            <input type="text" class="form-control" id="salarioAlterar<?php echo $i ?>" name="salario" value="<?php echo $objeto->salario ?>">
          </div>
      </div>
      
      <!-- Rodapé do Modal -->
      <div class="modal-footer">
          <input type="hidden" name="id_mongo" value="<?php echo $objeto->_id ?>">
          <button type="submit" class="btn btn-primary">Alterar</button>
        </form>
      </div>
      
    </div>
  </div>
</div>

<!-- Modal "Excluir Registro" -->
<div class="modal fade" id="ModalExcluir<?php echo $i ?>" aria-labelledby="modalTituloExcluir<?php echo $i ?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Cabeçalho do Modal -->
      <div class="modal-header">
        <h4 class="modal-title" id="modalTituloExcluir<?php echo $i ?>">Excluir Registro</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Corpo do Modal -->
      <div class="modal-body">
        <p>Tem certeza que deseja excluir o registro de <b><?php echo $objeto->nome ?></b> ?</p>
      </div>
      
      <!-- Rodapé do Modal -->
      <div class="modal-footer">
        <form action="assets/database/excluir.php" method="POST">
          <input type="hidden" name="id_mongo" value="<?php echo $objeto->_id ?>">
          <button type="submit" class="btn btn-danger">Excluir</button>
        </form>
      </div>
      
    </div>
  </div>
</div>

        <?php $i++; } ?>
      </tbody>
    </table>
  </div>



<!-- Modal "Incluir Registro" -->
<div class="modal fade" id="ModalIncluir">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Cabeçalho do Modal -->
      <div class="modal-header">
        <h4 class="modal-title">Incluir Registro</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Corpo do Modal -->
      <div class="modal-body">
        <!-- Formulário com os 3 campos -->
        <form action="assets/database/incluir.php" method="POST">
          <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" class="form-control" id="nome" name="nome">
          </div>
          <div class="form-group">
            <label for="email">Data de Nascimento:</label>
            <input type="date" class="form-control" id="dt_nascimento" name="dt_nascimento">
          </div>
          <div class="form-group">
            <label for="mensagem">Salário:</label>
            <input type="text" class="form-control" id="salarioIncluir" name="salario">
          </div>
      </div>
      
      <!-- Rodapé do Modal -->
      <div class="modal-footer">
          <button type="submit" class="btn btn-success">Incluir</button>
        </form>
      </div>
      
    </div>
  </div>
</div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/scripts.js"></script>  
</body>
</html>
