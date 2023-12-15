<?php
// Conexão com o banco de dados
$servername = "localhost";  // substitua pelo seu servidor
$username = "root";
$password = "";
$dbname = "agendamento_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Consulta SQL para verificar as credenciais
    $sql = "SELECT * FROM usuarios WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Usuário encontrado, verifica a senha
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            // Senha correta, redireciona para a página de sucesso
            header("Location: index.php");
            exit();
        } else {
            // Senha incorreta
            $loginError = "Senha incorreta. Tente novamente.";
        }
    } else {
        // Usuário não encontrado
        $loginError = "Usuário não encontrado. Tente novamente.";
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <title>Login</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

<div class="login-container animate__animated animate__fadeInDown">
    <h2>Login</h2>
    <form id="loginForm" method="post" action="processa_login.php">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" class="login-btn">Login</button>

        <?php if (!empty($loginError)) { ?>
            <p class="error-message"><?php echo $loginError; ?></p>
        <?php } ?>
    </form>
    <a href="registro.html" class="link-btn" target="">Registre-se</a>
</div>

<!-- Restante do seu código HTML -->

</body>
</html>
