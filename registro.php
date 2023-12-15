<?php
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

// Processamento do formulário de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";

    if ($conn->query($sql) === TRUE) {
        // Criação do subdomínio
        $subdomain = strtolower($nome);
        $htdocs_path = "C:/xampp/htdocs"; // Caminho para o diretório htdocs do XAMPP
        $command = "mkdir $htdocs_path/$subdomain && chmod 755 $htdocs_path/$subdomain";
        shell_exec($command);

        // Redirecionamento para o subdomínio criado
        header("Location: http://$subdomain.localhost/teste/index.php");
        exit();
    } else {
        echo "Erro no registro: " . $conn->error;
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
    <link rel="stylesheet" href="registro.css">
    <title>Registro</title>
</head>
<body>
    <h2>Registro</h2>
    <form action="registro.php" method="post">
        Nome: <input type="text" name="nome" required><br>
        Email: <input type="email" name="email" required><br>
        Senha: <input type="password" name="senha" required><br>
        <input type="submit" value="Registrar">
    </form>
</body>
</html>
