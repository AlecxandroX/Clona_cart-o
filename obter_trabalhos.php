<?php
// obter_trabalhos.php

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

// Obter o atendente_id enviado pela solicitação AJAX
$atendenteId = $_POST['atendente_id'];

// Consulta para obter os trabalhos correspondentes ao atendente
$query_trabalhos = "SELECT trabalho_id, nome FROM trabalhos WHERE atendente_id = $atendenteId";
$result_trabalhos = $conn->query($query_trabalhos);

// Criar um array para armazenar os resultados
$trabalhos = array();

// Transformar os resultados em um array associativo
while ($row = $result_trabalhos->fetch_assoc()) {
    $trabalhos[] = $row;
}

// Fechar a conexão com o banco de dados
$conn->close();

// Retornar os trabalhos como JSON
echo json_encode($trabalhos);
?>
