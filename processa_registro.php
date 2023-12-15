<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Conectar ao banco de dados (substitua com suas próprias informações)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "agendamento_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Receber os dados do formulário
    $fullName = $_POST["fullName"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // **Não recomendado: Salvar senha em texto plano**
    // Certifique-se de entender os riscos associados a esta prática
    $plainTextPassword = mysqli_real_escape_string($conn, $password);

    // Inserir os dados no banco de dados
    $sql = "INSERT INTO usuarios (full_name, username, email, password) VALUES ('$fullName', '$username', '$email', '$plainTextPassword')";

    if ($conn->query($sql) === TRUE) {
        echo "Registro inserido com sucesso!";
        header("Location: index.html");
    } else {
        echo "Erro ao inserir registro: " . $conn->error;
    }

    // Fechar a conexão com o banco de dados
    $conn->close();
}
?>
