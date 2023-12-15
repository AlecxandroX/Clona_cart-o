<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Agendamento</title>
    <style>
  body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f8f8;
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

form {
    max-width: 400px;
    margin: 20px;
    padding: 30px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

label {
    display: block;
    font-size: 14px;
    margin-bottom: 8px;
    color: #333;
}

input,
select {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    transition: border-color 0.3s ease-in-out;
}

select {
    appearance: none;
}

input[type="datetime-local"] {
    padding: 12px;
}

input[type="submit"] {
    background-color: #3498db;
    color: #fff;
    cursor: pointer;
    padding: 14px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    transition: background-color 0.3s ease-in-out;
}

input[type="submit"]:hover {
    background-color: #2980b9;
}

/* Responsive Styles */
@media screen and (max-width: 600px) {
    form {
        width: 90%;
    }
}

    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

<?php
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

// Obter o subdomínio da URL
$subdominio = explode('.', $_SERVER['HTTP_HOST'])[0];

// Consulta para obter os nomes e IDs dos atendentes filtrados pelo subdomínio
$query_atendentes = "SELECT id, nome FROM atendentes WHERE nome_empresa = '$subdominio'";
$result_atendentes = $conn->query($query_atendentes);

// Consulta para obter os trabalhos
$query_trabalhos = "SELECT trabalho_id, atendente_id, nome, valor FROM trabalhos";
$result_trabalhos = $conn->query($query_trabalhos);
?>

<form action="processa_agendamento.php" method="post">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" required>

    <br>

    <label for="telefone">Telefone:</label>
    <input type="text" name="telefone" id="telefone" required>

    <br>

    <label for="opcao1">Atendente:</label>
    <select name="opcao1" id="opcao1" required>
        <?php
        while ($row = $result_atendentes->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['nome']}</option>";
        }
        ?>
    </select>

    <br>

    <label for="opcao2">Trabalho:</label>
    <select name="opcao2" id="opcao2" required>
        <!-- Opções dos trabalhos serão preenchidas dinamicamente pelo JavaScript -->
    </select>

    <br>

    <label for="data_hora">Data e Hora:</label>
    <input type="datetime-local" name="data_hora" id="data_hora" required>

    <br>

    <input type="submit" value="Agendar">
</form>

<script>
$(document).ready(function() {
    // Quando o atendente é alterado, carregar os trabalhos correspondentes
    $('#opcao1').change(function() {
        var atendenteId = $(this).val();

        // Fazer uma solicitação AJAX para obter os trabalhos correspondentes ao atendente
        $.ajax({
            type: 'POST',
            url: 'obter_trabalhos.php',
            data: { atendente_id: atendenteId },
            dataType: 'json',
            success: function(response) {
                // Limpar as opções atuais e adicionar as novas opções
                $('#opcao2').empty();
                $.each(response, function(index, value) {
                    $('#opcao2').append('<option value="' + value.trabalho_id + '">' + value.nome + '</option>');
                });
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});
</script>

</body>
</html>
