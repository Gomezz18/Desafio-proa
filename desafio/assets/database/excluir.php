<?php
require_once('conn.php');

$id_mongo = $_POST['id_mongo'];

//Excluir no Mysql
$query = "DELETE FROM desafio WHERE id_mongo = '$id_mongo'";
$result = mysqli_query($conexao, $query); 

if($result){
    header("Location: /desafio/index.php");
}else{
    echo "erro";
}

//Excluir no MongoDB
$bulk = new MongoDB\Driver\BulkWrite;
use MongoDB\BSON\ObjectId;
$filter = ['_id' => new ObjectId($id_mongo)];
$bulk->delete($filter, ['limit' => 0]); 
    // Executa o BulkWrite
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");
$result = $conn->executeBulkWrite("$database.$collection", $bulk);

//Criar Log de Exclusão
$query_log = "INSERT INTO log_desafio (id_registro,alteracao,de,para) VALUES ('$id_mongo','Registro Excluido','N/A','N/A')";
mysqli_query($conexao, $query_log); 

?>