<?php
// processar_agendamento.php

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agendamento_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Obter os dados do formulário
$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$atendenteId = $_POST['opcao1'];
$trabalhoId = $_POST['opcao2'];
$dataHora = $_POST['data_hora'];

// Inserir os dados na tabela agendamentos
$query_inserir = "INSERT INTO agendamentos (nome, telefone, atendente_id, trabalho_id, data_hora) VALUES ('$nome', '$telefone', $atendenteId, $trabalhoId, '$dataHora')";

if ($conn->query($query_inserir) === TRUE) {
    echo "Agendamento salvo com sucesso!";
} else {
    echo "Erro ao salvar o agendamento: " . $conn->error;
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
