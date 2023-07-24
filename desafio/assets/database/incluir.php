<?php
require_once('conn.php');

//Atribuição de Variáveis
$nome = $_POST['nome'];
$dt_nascimento = date("Y-m-d", strtotime($_POST['dt_nascimento']));
    //Tratar salário
$salario = preg_replace('/[^\d]/', '', $_POST['salario']);
$salario = (float)($salario / 100);

//Inscerção MongoDB
$bulk = new MongoDB\Driver\BulkWrite;
$id_mongo = new MongoDB\BSON\ObjectId();
$bulk->insert([
    "_id" => $id_mongo,
    "nome" => $nome,
  "data_nascimento" => $dt_nascimento,
  "salario" => $salario
]);

$conn->executeBulkWrite("$database.$collection", $bulk);

//Inscerção MySQL
$query = "INSERT INTO desafio (id_mongo,nome,dt_nascimento,salario) VALUES ('$id_mongo','$nome','$dt_nascimento',$salario)";
$result = mysqli_query($conexao, $query); 

if($result){
    header("Location: /desafio/index.php");
}else{
    echo "erro";
    var_dump($id_mongo);
}







?>