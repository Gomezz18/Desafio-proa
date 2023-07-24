<?php

header('Content-Type: text/html; charset=utf-8');

//Verifica se existe conexão com bd, caso não tenta criar uma nova
$conexao = mysqli_connect("150.230.79.119","teste","teste@123") or die ("Erro na conexão com banco de dados"); 
    
//Seleciona o banco de dados
$select_db = mysqli_select_db($conexao,"tst"); 

("SET NAMES 'utf8'");
("SET @@global.time_zone = '+3:00'");
mysqli_query($conexao,'SET character_set_connection=utf8');
mysqli_query($conexao,'SET character_set_client=utf8');
mysqli_query($conexao,'SET character_set_results=utf8'); 


//Conexão MongoDB
try{
    $conn = new MongoDB\Driver\Manager("mongodb://localhost:27017");
} catch (MongoDBDriverExceptionException $e) {
    echo 'Failed to connect to MongoDB, is the service intalled and running?<br /><br />';
    echo $e->getMessage();
    exit();
}

$database = "teste";
$collection = "desafio";




?>