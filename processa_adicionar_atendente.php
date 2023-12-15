<?php
// Conexão com o banco de dados (substitua com suas próprias credenciais)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agendamento_db";

// Criação da conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter o nome do atendente e o nome da empresa do formulário
    $nome_atendente = $_POST["nome"];
    $nome_empresa = $_POST["nome_empresa"];

    // Adicionar atendente ao banco de dados
    $atendente_id = adicionarAtendente($nome_atendente, $nome_empresa, $conn);

    // Verificar se foram fornecidos trabalhos
    if (isset($_POST["nome_trabalho"]) && isset($_POST["valor_trabalho"])) {
        // Obter os dados dos trabalhos do formulário
        $nomes_trabalho = $_POST["nome_trabalho"];
        $valores_trabalho = $_POST["valor_trabalho"];

        // Adicionar trabalhos ao banco de dados
        adicionarTrabalhos($atendente_id, $nomes_trabalho, $valores_trabalho, $conn);
    }

    // Redirecionar para a página registro_atendentes.php com mensagem de sucesso
    header("Location: home.php?success=1");
    exit();
}

// Função para adicionar um atendente ao banco de dados
function adicionarAtendente($nome, $nome_empresa, $conn) {
    $sql = "INSERT INTO atendentes (nome, nome_empresa) VALUES ('$nome', '$nome_empresa')";
    
    if ($conn->query($sql) === TRUE) {
        // Obter o ID do último atendente adicionado
        return $conn->insert_id;
    } else {
        // Exibir mensagem de erro e encerrar o script
        die("Erro ao adicionar atendente: " . $conn->error);
    }
}

// Função para adicionar trabalhos ao banco de dados
function adicionarTrabalhos($atendente_id, $nomes_trabalho, $valores_trabalho, $conn) {
    // Garantir que os arrays tenham o mesmo tamanho
    if (count($nomes_trabalho) != count($valores_trabalho)) {
        // Exibir mensagem de erro e encerrar o script
        die("Os arrays de trabalho têm tamanhos diferentes");
    }

    // Preparar os dados para inserção
    $dados_trabalho = array();
    for ($i = 0; $i < count($nomes_trabalho); $i++) {
        $nome = $conn->real_escape_string($nomes_trabalho[$i]);
        $valor = $conn->real_escape_string($valores_trabalho[$i]);
        $dados_trabalho[] = "('$atendente_id', '$nome', '$valor')";
    }

    // Inserir trabalhos no banco de dados
    $sql = "INSERT INTO trabalhos (atendente_id, nome, valor) VALUES " . implode(", ", $dados_trabalho);

    if ($conn->query($sql) !== TRUE) {
        // Exibir mensagem de erro e encerrar o script
        die("Erro ao adicionar trabalhos: " . $conn->error);
    }
}

// Fechar a conexão com o banco de dados no final do script
$conn->close();
?>
