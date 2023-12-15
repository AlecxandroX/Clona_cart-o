<?php
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

// Resto do conteúdo da página protegida
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-H+KMS7Hlr6a/RQFEJMmDWdMXDXBdeF8An/aI4SDzO9RDfGx24Qd4Zd5AaSE1tKxaq13pZHsP8Tu3A3BHh2TjDA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Dashboard</title>

    <style>
   body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    background: linear-gradient(to right, #2980b9, #3498db);
    color: #fff;
    transition: background 0.3s ease;
}

header {
    background: #3498db;
    color: #fff;
    padding: 1em;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    transition: background 0.3s ease, box-shadow 0.3s ease;
}

nav {
    display: flex;
    background: #2c3e50;
    padding: 1em;
    border-bottom: 2px solid #34495e;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
}

nav a {
    color: #fff;
    text-decoration: none;
    padding: 1em;
    margin-right: 10px;
    border-radius: 6px;
    transition: background 0.3s ease;
}

nav a:hover {
    background: #34495e;
}

section {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    padding: 2em;
    transition: margin 0.3s ease;
}

.card, button {
    border-radius: 10px;
}

.card {
    color: #2c3e50;
    background: #fff;
    border: 1px solid #ddd;
    margin: 1em;
    padding: 1em;
    flex: 1 1 300px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: box-shadow 0.3s ease, transform 0.3s ease, background 0.3s ease;
}

.card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    transform: scale(1.05);
}

h2 {
    margin-bottom: 1em;
    font-size: 1.8em;
    color: #3498db;
}

ul {
    list-style-type: none;
    padding: 0;
}

li {
    margin-bottom: 0.5em;
    color: #333;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 0.5em;
    color: #2c3e50;
}

input, button {
    padding: 0.5em;
    margin-bottom: 1em;
    border: 1px solid #ddd;
    border-radius: 10px;
}

button {
    background-color: #3498db;
    color: #fff;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

button:hover {
    background-color: #2980b9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1em;
}

th, td {
    padding: 0.5em;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #3498db;
    color: #fff;
}

#quantidade {
    font-size: 6em;
    color: #3498db;
    font-weight: bold;
    text-align: center;
    margin-top: 20px;
}

.perfil {
    color: #fff;
}
nav a i {
    margin-right: 5px; /* Ajuste o espaçamento entre o ícone e o texto conforme necessário */
}


    </style>
</head>
<body>
    <header>
        <h1>Dashboard</h1>
        
      
    </header>
    
    <nav>
    <a href="#"><i class="fa-solid fa-house"></i> Home</a>
<a href="#"><i class="fas fa-chart-bar"></i> Financeiro</a>
<a href="#"><i class="fas fa-users"></i> Clientes</a>
<a href="#"><i class="fas fa-file-alt"></i> Relatórios</a>

            </nav>
            <div class="perfil">
        <h1>Bem vindo <?php echo $_SESSION['nome']; ?></h1>
        </div>
    <section>
        <div class="card" style="animation: fadeIn 1s ease;">
            <h2>Aqui Esta A Sua Agenda</h2>
            <?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agendamento_db";

// Cria uma conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi estabelecida com sucesso
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Inicia a sessão apenas se não estiver ativa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifique se a variável de sessão 'nome' está definida
if (isset($_SESSION['nome'])) {
    // Consulta SQL para recuperar as informações desejadas com filtro por nome da empresa
    $sql = "SELECT 
                agendamentos.id AS agendamento_id,
                agendamentos.data_hora,
                atendentes.nome AS atendente_nome,
                atendentes.nome_empresa,
                agendamentos.nome AS nome
            FROM 
                agendamentos
            JOIN 
                atendentes ON agendamentos.atendente_id = atendentes.id
            WHERE 
                atendentes.nome_empresa = '{$_SESSION['nome']}'";
} else {
    // Consulta SQL para recuperar as informações desejadas sem filtro
    $sql = "SELECT 
                agendamentos.id AS agendamento_id,
                agendamentos.data_hora,
                atendentes.nome AS atendente_nome,
                atendentes.nome_empresa,
                agendamentos.nome AS nome
            FROM 
                agendamentos
            JOIN 
                atendentes ON agendamentos.atendente_id = atendentes.id";
}

// Executa a consulta e armazena o resultado em $result
$result = $conn->query($sql);

// Verifica se a consulta retornou resultados
if ($result->num_rows > 0) {
    // Exibe os dados em uma tabela HTML
    echo "<table border='1'>
            <tr>
                <th>Data e Hora</th>
                <th>Nome Atendente</th>
                <th>Cliente</th>
                <th>Ação</th>
            </tr>";

    // Loop através dos resultados e exibe cada linha na tabela
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['data_hora']}</td>
                <td>{$row['atendente_nome']}</td>
                <td>{$row['nome']}</td>
                <td><button onclick=\"excluirLinha({$row['agendamento_id']})\">Excluir</button></td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "Nenhum resultado encontrado.";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

        </div>

        <div class="card" style="animation: fadeIn 1s ease 0.2s;">
        <h2>Adicionar Atendente</h2>
            <div class="for2">

    <form action="processa_adicionar_atendente.php" method="post">
        <label for="nome">Nome do Atendente:</label>
        <input type="text" name="nome" id="nome" required>

        <!-- Nome da Empresa preenchido automaticamente -->
        <input type="hidden" name="nome_empresa" value="<?php echo $_SESSION['nome']; ?>">

        <h3>Trabalhos</h3>
        <div id="trabalhos">
            <div class="trabalho">
                <label for="nome_trabalho">Nome do Trabalho:</label>
                <input type="text" name="nome_trabalho[]" required>
                <br>
                
                <label for="valor_trabalho">Valor do Trabalho:</label>
                <input type="number" name="valor_trabalho[]" required>

                <button type="button" onclick="adicionarTrabalho()">+</button>
            </div>
        </div>
        <script>
        function toggleCard() {
            var cardContainer = document.getElementById('cardContainer');
            cardContainer.style.display = (cardContainer.style.display === 'none') ? 'block' : 'none';
        }
    </script>
    <script>
        function adicionarTrabalho() {
            var divTrabalhos = document.getElementById('trabalhos');
            var novoTrabalho = document.createElement('div');
            novoTrabalho.className = 'trabalho';

            novoTrabalho.innerHTML = `
                <label for="nome_trabalho">Nome do Trabalho:</label>
                <input type="text" name="nome_trabalho[]" required>
                
                <label for="valor_trabalho">Valor do Trabalho:</label>
                <input type="number" name="valor_trabalho[]" required>

                <button type="button" onclick="removerTrabalho(this)">Remover Trabalho</button>
            `;

            divTrabalhos.appendChild(novoTrabalho);
        }

        function removerTrabalho(botao) {
            var divTrabalhos = document.getElementById('trabalhos');
            divTrabalhos.removeChild(botao.parentNode);
        }
    </script>

        <button type="submit">Adicionar Atendente</button>
    </form>
    </div>
    </div>
        </div>

        <div class="card" style="animation: fadeIn 1s ease 0.4s;">
            <h2>Agendamentos</h2>
            <div id="quantidade">
            <?php

// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agendamento_db";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se a sessão 'nome' está definida
if (isset($_SESSION['nome'])) {
    // Consulta SQL para recuperar as informações desejadas com filtro por nome da empresa
    $sql = "SELECT 
                agendamentos.id AS agendamento_id,
                agendamentos.data_hora,
                atendentes.nome AS atendente_nome,
                atendentes.nome_empresa
            FROM 
                agendamentos
            JOIN 
                atendentes ON agendamentos.atendente_id = atendentes.id
            WHERE 
                atendentes.nome_empresa = '{$_SESSION['nome']}'";
} else {
    // Consulta SQL para recuperar as informações desejadas sem filtro
    $sql = "SELECT 
                agendamentos.id AS agendamento_id,
                agendamentos.data_hora,
                atendentes.nome AS atendente_nome,
                atendentes.nome_empresa
            FROM 
                agendamentos
            JOIN 
                atendentes ON agendamentos.atendente_id = atendentes.id";
}

// Consulta para contar o número de linhas
$result = $conn->query($sql);

// Verifica se a consulta foi bem-sucedida
if ($result) {
    // Obtém o número de linhas
    $total_linhas = $result->num_rows;
    
    // Exibe a quantidade de linhas
    echo " " . $total_linhas;
} else {
    echo "Erro na consulta: " . $conn->error;
}

// Fecha a conexão com o banco de dados
$conn->close();

?>



</div>
        </div>

        <div class="card" style="animation: fadeIn 1s ease 0.6s;">
           
            <?php
// Supondo que você já tenha iniciado a sessão em algum lugar do seu código

// Substitua os valores de host, usuário, senha e nome do banco de dados conforme necessário
$host = "localhost";
$usuario = "root";
$senha = "";
$nomeBanco = "agendamento_db";

// Conectar ao banco de dados
$conexao = new mysqli($host, $usuario, $senha, $nomeBanco);

// Verificar a conexão
if ($conexao->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conexao->connect_error);
}

// Evitar SQL injection
$nomeEmpresa = $conexao->real_escape_string($_SESSION['nome']);

// Consulta SQL para recuperar dados filtrados
$sql = "SELECT a.id, a.nome, t.nome AS trabalho 
        FROM atendentes a 
        LEFT JOIN trabalhos t ON a.id = t.atendente_id 
        WHERE a.nome_empresa = '$nomeEmpresa'";
$resultado = $conexao->query($sql);

// Verificar se a consulta foi bem-sucedida
if ($resultado) {
    // Verificar se há pelo menos uma linha retornada
    if ($resultado->num_rows > 0) {
        // Exibir os resultados
        echo "<h2>Dados dos Atendentes</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Nome</th><th>Trabalho</th><th>Ação</th></tr>";

        // Loop através dos resultados e exibir cada linha com um botão "Excluir"
        while ($linha = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $linha['nome'] . "</td>";
            echo "<td>" . $linha['trabalho'] . "</td>";
            echo "<td><form method='post' action='".$_SERVER['PHP_SELF']."'>";
            echo "<input type='hidden' name='id_atendente' value='" . $linha['id'] . "'>";
            echo "<button type='submit' name='excluir_atendente'>Excluir</button>";
            echo "</form></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Nenhum resultado encontrado.";
    }
} else {
    echo "Erro na consulta: " . $conexao->error;
}

// Processar a exclusão quando o formulário for enviado
if (isset($_POST['excluir_atendente'])) {
    $idAtendente = $conexao->real_escape_string($_POST['id_atendente']);
    
    // Consulta SQL para excluir o atendente
    $sqlExcluir = "DELETE FROM atendentes WHERE id = '$idAtendente'";
    $resultadoExcluir = $conexao->query($sqlExcluir);

    // Verificar se a exclusão foi bem-sucedida
    if ($resultadoExcluir) {
        echo "Atendente excluído com sucesso.";
    } else {
        echo "Erro ao excluir o atendente: " . $conexao->error;
    }
}

// Fechar a conexão
$conexao->close();
?>
            
        </div>
    </section>
</body>
</html>
