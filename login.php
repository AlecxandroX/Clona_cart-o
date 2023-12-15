<?php
session_start();

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agendamento_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Processamento do formulário de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, nome, senha FROM usuarios WHERE nome = '$nome'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($senha, $row['senha'])) {
            // Iniciar a sessão e armazenar informações do usuário
            $_SESSION['id'] = $row['id'];
            $_SESSION['nome'] = $row['nome'];

            // Redirecionar para a página protegida
            header('Location: Dashboard.php');
            exit();
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Usuário não encontrado.";
    }
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="post">
        Nome: <input type="text" name="nome" required><br>
        Senha: <input type="password" name="senha" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
