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
    <link rel="stylesheet" href="registro_atendentes.css">
    <title>Adicionar Atendente</title>
</head>
<body>
    <h2>Adicionar Atendente</h2>
    <h2>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</h2>
    <?php
    // Exibir mensagens de sucesso ou erro
    if(isset($_GET['success']) && $_GET['success'] == 1) {
        echo "<p style='color:green;'>Atendente adicionado com sucesso!</p>";
    } elseif(isset($_GET['error'])) {
        echo "<p style='color:red;'>Erro ao adicionar atendente: {$_GET['error']}</p>";
    }
    ?>

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
                
                <label for="valor_trabalho">Valor do Trabalho:</label>
                <input type="number" name="valor_trabalho[]" required>

                <button type="button" onclick="adicionarTrabalho()">Adicionar Trabalho</button>
            </div>
        </div>

        <button type="submit">Adicionar Atendente</button>
    </form>

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
</body>
</html>
