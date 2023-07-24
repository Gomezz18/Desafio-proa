<?php
require_once('conn.php');

//Atribuir Variáveis
$id_mongo = $_POST['id_mongo'];
$nome = $_POST['nome'];
$dt_nascimento = date("Y-m-d", strtotime($_POST['dt_nascimento']));
$dt_nascimento_antigo_tratado = date("d/m/Y", strtotime($_POST['dt_nascimento']));
$salario = $_POST['salario'];

//Buscar dados do registro
$query_dados = "SELECT * FROM desafio WHERE id_mongo = '$id_mongo'";
$result_dados = mysqli_query($conexao, $query_dados); 
$array = $result_dados->fetch_assoc();

//Validar alterações e inserir log
if($array['nome'] != $nome){
    $nome_antigo = $array['nome'];
    $query_nome = "INSERT INTO log_desafio (id_registro,alteracao,de,para) VALUES ('$id_mongo','Nome','$nome_antigo','$nome')";
    mysqli_query($conexao, $query_nome); 
}
if($array['dt_nascimento'] != $_POST['dt_nascimento']){
    $dt_nascimento_tratado = date("d/m/Y", strtotime($array['dt_nascimento']));
    $query_nasc = "INSERT INTO log_desafio (id_registro,alteracao,de,para) VALUES ('$id_mongo','Data de Nascimento','$dt_nascimento_tratado','$dt_nascimento_antigo_tratado')";
    mysqli_query($conexao, $query_nasc); 
}
if($array['salario'] != $salario){
    $salario_antigo = $array['salario'];
    $query_salario = "INSERT INTO log_desafio (id_registro,alteracao,de,para) VALUES ('$id_mongo','Salário','R$ " . $salario_antigo . "','R$ " . $salario . "')";
    mysqli_query($conexao, $query_salario); 
}

//Alterar registro no banco MySQL
$query = "UPDATE desafio SET nome='$nome', dt_nascimento='$dt_nascimento', salario=$salario WHERE id_mongo = '$id_mongo'";
$result = mysqli_query($conexao, $query); 

//Validar erros na alteração do registro
if($result){
    header("Location: /desafio/index.php");
    //echo $array['nome'] . "<br>" . $nome;
}else{
    echo "erro";
}


//Alterar registro no banco MongoDB

// Define o filtro para encontrar os documentos que serão atualizados
use MongoDB\BSON\ObjectId;
$filter = ['_id' => new ObjectId($id_mongo)];

// Define as alterações que deseja fazer no documento encontrado
if($array['nome'] != $nome){
    $bulkWrite_nome = new MongoDB\Driver\BulkWrite;
    $update_nome = ['$set' => ['nome' => $nome]];
    $bulkWrite_nome->update($filter, $update_nome, ['multi' => true]); // O parâmetro 'multi' atualiza vários documentos

    // Executa o BulkWrite
    $manager_nome = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $result_nome = $conn->executeBulkWrite("$database.$collection", $bulkWrite_nome);
}
if($array['dt_nascimento'] != $_POST['dt_nascimento']){
    $bulkWrite_nasc = new MongoDB\Driver\BulkWrite;
    $update_nasc = ['$set' => ['data_nascimento' => $dt_nascimento]];
    $bulkWrite_nasc->update($filter, $update_nasc, ['multi' => true]); // O parâmetro 'multi' atualiza vários documentos

    // Executa o BulkWrite
    $manager_nasc = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $result_nasc= $conn->executeBulkWrite("$database.$collection", $bulkWrite_nasc);
}
if($array['salario'] != $salario){
    $bulkWrite_salario = new MongoDB\Driver\BulkWrite;
    $update_salario = ['$set' => ['salario' => $salario]];
    // Adiciona a operação de atualização ao BulkWrite
    $bulkWrite_salario->update($filter, $update_salario, ['multi' => true]); // O parâmetro 'multi' atualiza vários documentos

    // Executa o BulkWrite
    $manager_salario = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $result_salario = $conn->executeBulkWrite("$database.$collection", $bulkWrite_salario);
}

?>